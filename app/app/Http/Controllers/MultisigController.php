<?php
/**
 * Created by PhpStorm.
 * User: faree
 * Date: 1/19/2020
 * Time: 4:12 PM
 */

namespace App\Http\Controllers;

use App\Bitcoin\Bitcoin;
use App\Models\MultisigAddresses;
use App\Models\MultisigTransactions;
use App\Models\ServerCredentials;
use App\Models\User;
class MultisigController extends Controller
{

  private $bitcoin;

  private $credentials;

  private $user;

  public function __construct(){

      $this->user = User::find(auth()->user()->id);
      $this->credentials = ServerCredentials::where("currency",1)->first();
      $this->bitcoin = new Bitcoin($this->credentials->username,$this->credentials->password,$this->credentials->host,$this->credentials->port);

  }

  public function CreateAddress(){
      $address = $this->bitcoin->getnewaddress();
      $address_info = $this->bitcoin->getaddressinfo($address->result);
      return (object) $address_info->result;
  }

  public function CreateMultiSig($listing,$buyer){

      $address_1 = $this->CreateAddress();
      $address_2 = $this->CreateAddress();
      $address_3 = $this->CreateAddress();
      $addresses_array = array($address_1->pubkey,$address_2->pubkey,$address_3->pubkey);

      $multisig_address = $this->bitcoin->addmultisigaddress(2,$addresses_array);

      $multisig_record = new MultisigTransactions();
      $multisig_record->multisig_address = $multisig_address->result['address'];
      $multisig_record->multisig_redeem = $multisig_address->result['redeemScript'];
      $multisig_record->multisig_amount = $listing->btc_price;
      $multisig_record->listing_id = $listing->id;
      $multisig_record->buyer_id = $buyer;
      $multisig_record->seller_id = $listing->user_id;
      $multisig_record->save();

      $addresses_record = new MultisigAddresses();
      $addresses_record->multisig_id = $multisig_record->id;
      $addresses_record->address_1 = $address_1->address;
      $addresses_record->address_2 = $address_2->address;
      $addresses_record->address_3 = $address_3->address;
      $addresses_record->save();

      return $multisig_address;

  }

  public function CheckMultiSigAmount($address,$confirmations = 0){

      $multisig_record = MultisigTransactions::where("multisig_address",$address)->first();
      $address = $multisig_record->multisig_address;
      $amount = $this->bitcoin->getreceivedbyaddress($address,$confirmations);
      if($amount->result >= $multisig_record->multisig_amount){
          return true;
      }else{
          return false;
      }

  }

  public function GetMultiSigTxid($address){
      $transaction_txid = $this->bitcoin->listreceivedbyaddress(0,true,true,$address);
      $transaction_info = $this->bitcoin->gettransaction($transaction_txid->result[0]['txids'][0]);
      return $transaction_info;
  }

  public function GetScriptPubKey($transaction_info){
      $raw_transaction = $this->bitcoin->decoderawtransaction($transaction_info->result['hex']);
      $transaction_vout_key = array_search($transaction_info->result['amount'],array_column($raw_transaction->result['vout'],'value'));
      $transaction_scriptpubkey = $raw_transaction->result['vout'][$transaction_vout_key]['scriptPubKey']['hex'];
      return $transaction_scriptpubkey;
  }

  public function GetPrivateKey($address){
      $private_key = $this->bitcoin->dumpprivkey($address);
      return $private_key->result;
  }

  public function GetMultiSigAddresses($address_id){
      $addresses = new MultisigAddresses();
      $multisig_addresses = $addresses->where("multisig_id",$address_id)->first();
      return [$multisig_addresses->address_1,$multisig_addresses->address_2,$multisig_addresses->address_3];
  }

  public function GetMultiSigPrivKeys($addresses_array){
      $privkey0 = $this->GetPrivateKey($addresses_array[0]);
      $privkey1 = $this->GetPrivateKey($addresses_array[1]);
      $privkey2 = $this->GetPrivateKey($addresses_array[2]);
      return [$privkey0,$privkey1,$privkey2];
  }

  public function GetTransactionFee(){
      $fee = $this->bitcoin->estimatesmartfee(6);
      print_r($fee);
      return $fee->result['feerate'];
  }

  public function CreateRawTransaction($txid,$vout,$address,$amount){
        $json = '[
                      {
                        "txid": "'.$txid.'",
                        "vout": '.$vout.'
                      }
                   ]';
        $address = '{
                      "'.$address.'": '.$amount.'
                    }';
        $hex = $this->bitcoin->createrawtransaction(json_decode($json),json_decode($address));
        return $hex->result;
  }

  public function SignTransaction($hex,$json,$key){
      $private_key = '["'.$key.'"]';
      $hex = $this->bitcoin->signrawtransactionwithkey($hex,json_decode($private_key),json_decode($json));
      return $hex->result['hex'];
  }

  public function SendMultiSigTransaction($address,$vendor_address){
      $transaction_info = $this->GetMultiSigTxid($address->multisig_address);
      $fee = $this->GetTransactionFee();
      $receive_amount = floatval($transaction_info->result['amount']) - floatval($fee);
      $rawtransaction = $this->CreateRawTransaction($transaction_info->result['txid'],$transaction_info->result['details']['0']['vout'],$vendor_address,$receive_amount);
      $scriptpubkey = $this->GetScriptPubKey($transaction_info);
      $multisig_redeem = $address->multisig_redeem;
      $addresses = $this->GetMultiSigAddresses($address->id);
      $private_keys = $this->GetMultiSigPrivKeys($addresses);
      $json = '[
                  {
                    "txid": "'.$transaction_info->result['txid'].'",
                    "vout": '.$transaction_info->result['details']['0']['vout'].',
                    "scriptPubKey": "'.$scriptpubkey.'", 
                    "redeemScript": "'.$multisig_redeem.'",
                    "amount": '.$transaction_info->result['amount'].'
                  }
               ]';
      $partially_signed = $this->SignTransaction($rawtransaction,$json,$private_keys[0]);
      $signed = $this->SignTransaction($partially_signed,$json,$private_keys[1]);
      $send = $this->bitcoin->sendrawtransaction($signed);
      return $send;
  }

}