<?php
/**
 * Created by PhpStorm.
 * User: faree
 * Date: 1/27/2020
 * Time: 3:54 PM
 */

namespace App\Http\Controllers;

use App\Models\CurrencyRates;
use App\Models\ServerCredentials;
use App\Bitcoin\Bitcoin;
use App\Litecoin\Litecoin;
use App\Monero\Monero;
use App\Models\User;
use App\Models\UserAddresses;
use App\Models\UserTransactions;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{

    public function DepositBitcoin(Request $request){
        $btc_credentials = ServerCredentials::where("currency",1)->first();
        $bitcoin = new Bitcoin($btc_credentials->username,$btc_credentials->password,$btc_credentials->host,$btc_credentials->port);
        $information = $bitcoin->gettransaction($request->input("tx_id"));
        if(!is_object($information)){
            exit;
        }
        $user_addresses = UserAddresses::where("btc_address",$information->result['details'][0]['address'])->first();
        if($user_addresses){
            $transaction = UserTransactions::where("tx_id",$request->input("tx_id"))->where("currency",1)->first();
            $user = User::find($user_addresses->user_id);
            if($transaction){
                if($information->result['confirmations'] > 2 && $transaction->status == "Pending"){
                        $user->btc_balance = $user->btc_balance + floatval($information->result['details'][0]['amount']);
                        $user->save();
                        $transaction->confirmations = $information->result['confirmations'];
                        $transaction->status = "Completed";
                        $transaction->save();
                }
            }else{
                    $new_transaction = new UserTransactions();
                    $new_transaction->tx_id = $request->input("tx_id");
                    $new_transaction->user_id = $user->id;
                    $new_transaction->address = $information->result['details'][0]['address'];
                    $new_transaction->currency = 1;
                    $new_transaction->amount = $information->result['details'][0]['amount'];
                    $new_transaction->type = "Deposit";
                    $new_transaction->confirmations = $information->result['confirmations'];
                    $new_transaction->status = "Pending";
                    $new_transaction->save();
            }
        }
        return response("")
            ->header('Content-Type', "json/application");
    }

    public function DepositLitecoin(Request $request){
        $ltc_credentials = ServerCredentials::where("currency",2)->first();
        $litetcoin = new Litecoin($ltc_credentials->username,$ltc_credentials->password,$ltc_credentials->host,$ltc_credentials->port);
        $information = $litetcoin->gettransaction($request->input("tx_id"));
        if(!is_object($information)){
            exit;
        }
        $user_addresses = UserAddresses::where("ltc_address",$information->result['details'][0]['address'])->first();
        if($user_addresses){
            $transaction = UserTransactions::where("tx_id",$request->input("tx_id"))->where("currency",2)->first();
            $user = User::find($user_addresses->user_id);
            if($transaction){
                if($information->result['confirmations'] > 2 && $transaction->status == "Pending"){
                        $user->ltc_balance = $user->ltc_balance + floatval($information->result['details'][0]['amount']);
                        $user->save();
                        $transaction->confirmations = $information->result['confirmations'];
                        $transaction->status = "Completed";
                        $transaction->save();
                }
            }else{
                $new_transaction = new UserTransactions();
                $new_transaction->tx_id = $request->input("tx_id");
                $new_transaction->user_id = $user->id;
                $new_transaction->address = $information->result['details'][0]['address'];
                $new_transaction->currency = 2;
                $new_transaction->amount = $information->result['details'][0]['amount'];
                $new_transaction->type = "Deposit";
                $new_transaction->confirmations = $information->result['confirmations'];
                $new_transaction->status = "Pending";
                $new_transaction->save();
            }
        }
        return response("")
            ->header('Content-Type', "json/application");
    }

    public function DepositMonero(Request $request){
        $xmr_credentials = ServerCredentials::where("currency",3)->first();
        $monero = new Monero($xmr_credentials->username,$xmr_credentials->password,$xmr_credentials->host,$xmr_credentials->port);
        $information = $monero->get_transfer_by_txid(array("txid" => $request->input("tx_id")));
        if(!is_object($information)){
            exit;
        }
        $user_addresses = UserAddresses::where("xmr_address",$information->result['transfer']['address'])->first();
        if($user_addresses){
            $transaction = UserTransactions::where("tx_id",$request->input("tx_id"))->where("currency",3)->first();
            $user = User::find($user_addresses->user_id);
            if($transaction){
                if($information->result['transfer']['confirmations'] > 2 && $transaction->status == "Pending"){
                        $user->xmr_balance = $user->xmr_balance + floatval($information->result['transfer']['amount'])/pow(10,12);
                        $user->save();
                        $transaction->confirmations = $information->result['transfer']['confirmations'];
                        $transaction->status = "Completed";
                        $transaction->save();
                }
            }else{
                $new_transaction = new UserTransactions();
                $new_transaction->tx_id = $request->input("tx_id");
                $new_transaction->user_id = $user->id;
                $new_transaction->address = $information->result['transfer']['address'];
                $new_transaction->currency = 3;
                $new_transaction->amount = floatval($information->result['transfer']['amount'])/pow(10,12);
                $new_transaction->type = "Deposit";
                $new_transaction->confirmations = $information->result['transfer']['confirmations'];
                $new_transaction->status = "Pending";
                $new_transaction->save();
            }
        }
    }

    public function UpdateRates(){

     $rates = new CurrencyRates();
     $rates = $rates->orderBy('created_at', 'asc')->first();
     $last_update = strtotime('now');
     if($rates){
         $last_update = strtotime($rates->created_at);
     }
     $time = strtotime('now');
     if(($time - $last_update) > 2000 || !$rates){
        $btc_rates = file_get_contents("https://api.coingecko.com/api/v3/coins/bitcoin?localization=false&tickers=false&market_data=true&community_data=false&developer_data=false&sparkline=false");
        $ltc_rates = file_get_contents("https://api.coingecko.com/api/v3/coins/litecoin?localization=false&tickers=false&market_data=true&community_data=false&developer_data=false&sparkline=false");
        $xmr_rates = file_get_contents("https://api.coingecko.com/api/v3/coins/monero?localization=false&tickers=false&market_data=true&community_data=false&developer_data=false&sparkline=false");

        $btc_rates = json_decode($btc_rates);
        $btc_rates = (array) $btc_rates->market_data->current_price;
        $ltc_rates = json_decode($ltc_rates);
        $ltc_rates = (array) $ltc_rates->market_data->current_price;
        $xmr_rates = json_decode($xmr_rates);
        $xmr_rates = (array) $xmr_rates->market_data->current_price;

        CurrencyRates::updateOrCreate(['currency_id'=>1],['currency_id' => 1 ,'usd' => $btc_rates['usd'], 'eur' => $btc_rates['eur'], 'gbp' => $btc_rates['gbp'], 'cad' => $btc_rates['cad'], 'aud' => $btc_rates['aud'], 'brl' => $btc_rates['brl'], 'dkk' => $btc_rates['dkk'], 'nok' => $btc_rates['nok'], 'sek' => $btc_rates['sek'], 'try' => $btc_rates['try'], 'cny' => $btc_rates['cny'], 'hkd' => $btc_rates['hkd'], 'rub' => $btc_rates['rub'], 'inr' => $btc_rates['inr'], 'jpy' => $btc_rates['jpy']]);
        CurrencyRates::updateOrCreate(['currency_id'=>2],['currency_id' => 2 ,'usd' => $ltc_rates['usd'], 'eur' => $ltc_rates['eur'], 'gbp' => $ltc_rates['gbp'], 'cad' => $ltc_rates['cad'], 'aud' => $ltc_rates['aud'], 'brl' => $ltc_rates['brl'], 'dkk' => $ltc_rates['dkk'], 'nok' => $ltc_rates['nok'], 'sek' => $ltc_rates['sek'], 'try' => $ltc_rates['try'], 'cny' => $ltc_rates['cny'], 'hkd' => $ltc_rates['hkd'], 'rub' => $ltc_rates['rub'], 'inr' => $ltc_rates['inr'], 'jpy' => $ltc_rates['jpy']]);
        CurrencyRates::updateOrCreate(['currency_id'=>3],['currency_id' => 3 ,'usd' => $xmr_rates['usd'], 'eur' => $xmr_rates['eur'], 'gbp' => $xmr_rates['gbp'], 'cad' => $xmr_rates['cad'], 'aud' => $xmr_rates['aud'], 'brl' => $xmr_rates['brl'], 'dkk' => $xmr_rates['dkk'], 'nok' => $xmr_rates['nok'], 'sek' => $xmr_rates['sek'], 'try' => $xmr_rates['try'], 'cny' => $xmr_rates['cny'], 'hkd' => $xmr_rates['hkd'], 'rub' => $xmr_rates['rub'], 'inr' => $xmr_rates['inr'], 'jpy' => $xmr_rates['jpy']]);

     }
    }

    public function Cron(){

        $transactions = UserTransactions::where("status","Pending")->get();

        foreach ($transactions as $transaction){

            $currency = $transaction->currency;
            $type = "btc";
            if($currency == 2){
                $type = "ltc";
            }elseif ($currency == 3){
                $type = "xmr";
            }
            $curl    = curl_init("https://superweb-dev.com/transactions/".$type);
            $options = array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => "tx_id=".$transaction->tx_id
            );

            curl_setopt_array($curl, $options);
            $response = curl_exec($curl);

        }


    }

}