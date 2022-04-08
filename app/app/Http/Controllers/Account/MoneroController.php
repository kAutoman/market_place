<?php

namespace App\Http\Controllers\Account;

use App\Models\ServerCredentials;
use App\Monero\Monero;
use App\Models\UserAddresses;
use App\Models\User;
use App\Models\UserTransactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use MetaTag;


class MoneroController extends Controller
{

    protected $xmr_credentials;
    protected $monero;

    public function __construct(){
        $this->xmr_credentials = ServerCredentials::where("currency",3)->first();
        $this->monero = new Monero($this->xmr_credentials->username,$this->xmr_credentials->password,$this->xmr_credentials->host,$this->xmr_credentials->port);
    }

    public function index() {
        MetaTag::set('title', "Monero Wallet");
        $user = User::find(auth()->user()->id);
        $address = $user->GetXMRAddress();
        $transactions = UserTransactions::where("user_id",$user->id)->where("currency",3)->get();
        $fee = $this->monero->get_fee_estimate();
        $fee->result['fee'] = intval($fee->result['fee'])/pow(10,12);
        $fee_normal = number_format($fee->result['fee'], 12, '.', "");
        return view('wallet.xmr')->with(["address"=>$address,"user" => $user,"transactions" => $transactions,"xmr_fee_normal" =>$fee_normal]);
    }

    public function Withdraw(Request $request){

        $user = User::find(auth()->user()->id);

        if (strlen($request->input("xmraddress")) < 95 || strlen($request->input("xmraddress")) > 106){
            return redirect()->back()->with('error','Invalid address.');
        }

        if ($request->input("withdrawPIN") != $user->withdrawpin){
            return redirect()->back()->with('error','Wrong PIN code.');
        }

        if($request->input("xmramount") > $user->xmr_balance){
            return redirect()->back()->with('error','Not enough balance.');
        }

        if($this->isSystemAddress($request->input("xmraddress"))){
            return redirect()->back()->with('error','Can\'t withdraw to an address on the system.');
        }

        $amount = $request->input("xmramount");
        if($request->input("max")=="max"){
            $amount = $user->xmr_balance;
        }
        $amount = number_format(($amount * pow(10,12)),12,"","");
        $system_fee = $amount * 0.009;
        $send_amount = $amount - number_format($system_fee,12,"","");
        $send_amount = number_format($send_amount,12,"","");
        if($send_amount <= 0){
            return redirect()->back()->with('error','Not enough balance.');
        }
        $transaction = $this->monero->transfer(["destinations"=>array(0 => array("amount"=>$send_amount,"address"=>$request->input("xmraddress")))]);
        if(!is_object($transaction)){
            return redirect()->back()->with('error','Error sending the transaction please contact support.');
        }
        $information = $this->monero->get_transfer_by_txid(array("txid" =>$transaction->result["tx_hash"]));
        if(!is_object($information)){
            return redirect()->back()->with('error','Error sending the transaction please contact support.');
        }

        $user->xmr_balance = $user->xmr_balance - $amount;
        $user->save();

        $new_transaction = new UserTransactions();
        $new_transaction->tx_id = $transaction->result['tx_hash'];
        $new_transaction->user_id = $user->id;
        $new_transaction->address = $information->result['transfer']['address'];
        $new_transaction->currency = 3;
        $new_transaction->amount = number_format($information->result['transfer']['amount']/pow(10,12),2,".",",");
        $new_transaction->type = "Withdraw";
        $new_transaction->confirmations = $information->result['transfer']['confirmations'];
        $new_transaction->status = "Completed";
        $new_transaction->save();

        return redirect()->back()->with('success','Payment Sent. Transaction ID : '.$transaction->result['tx_hash']);

    }

    public function isSystemAddress($address){
        $address = UserAddresses::where("xmr_address",$address)->first();
        if($address){
            return true;
        }else{
            return false;
        }
    }

}
