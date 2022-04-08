<?php

namespace App\Http\Controllers\Account;

use App\Models\ServerCredentials;
use App\Bitcoin\Bitcoin;
use App\Models\User;
use App\Models\UserAddresses;
use App\Models\UserTransactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use MetaTag;

class BitcoinController extends Controller
{
    protected $btc_credentials;
    protected $bitcoin;

    public function __construct(){
        $this->btc_credentials = ServerCredentials::where("currency",1)->first();
        $this->bitcoin = new Bitcoin($this->btc_credentials->username,$this->btc_credentials->password,$this->btc_credentials->host,$this->btc_credentials->port);
    }

    public function index() {
        MetaTag::set('title', "Bitcoin Wallet");
        $user = User::find(auth()->user()->id);
        $address = $user->GetBTCAddress();
        $transactions = UserTransactions::where("user_id",$user->id)->where("currency",1)->get();
        $fee = $this->bitcoin->estimatesmartfee(6);
        $fee->result['feerate'] = floatval($fee->result['feerate'])/10;
        $fee->result['feerate'] = number_format($fee->result['feerate'], 8, '.', ",");
        return view('wallet.btc')->with(["address"=>$address,"user" => $user,"transactions" => $transactions ,"btc_fee" => $fee->result['feerate']]);
    }

    public function Withdraw(Request $request){

        $user = User::find(auth()->user()->id);

        if (strlen($request->input("btcaddress")) < 25 || strlen($request->input("btcaddress")) > 35){
            return redirect()->back()->with('error','Invalid address.');
        }

        if ($request->input("withdrawPIN") != $user->withdrawpin){
            return redirect()->back()->with('error','Wrong PIN code.');
        }

        if($request->input("btcamount") > $user->btc_balance){
            return redirect()->back()->with('error','Not enough balance.');
        }

        if($this->isSystemAddress($request->input("btcaddress"))){
            return redirect()->back()->with('error','Can\'t withdraw to an address on the system.');
        }

        $amount = $request->input("btcamount");

        if($request->input("max")=="max"){
            $amount = $user->btc_balance;
        }
        $system_fee = $amount * 0.009;
        $send_amount = $amount - $system_fee;
        $fee = $this->bitcoin->estimatesmartfee(6);
        $fee = $fee->result['feerate'];
        if($request->input("btc_fee_type") == 2){
                $send_amount = $send_amount - $fee;
        }elseif ($request->input("btc_fee_type") == 3){
                $send_amount = $send_amount - ($fee*3);
        }
        if($send_amount <= 0){
            return redirect()->back()->with('error','Not enough balance.');
        }
        $send_amount = number_format($send_amount,8);

        $transaction = $this->bitcoin->sendtoaddress($request->input("btcaddress"),$send_amount,"","",true);
        if(!is_object($transaction)){
            return redirect()->back()->with('error','Error sending the transaction please contact support.');
        }
        $information = $this->bitcoin->gettransaction($transaction->result);
        if(!is_object($information)){
            return redirect()->back()->with('error','Error sending the transaction please contact support.');
        }

        if($request->input("btc_fee_type") == 2){
             $this->bitcoin->bumpfee($transaction->result,json_decode('{"confTarget": 3,"totalFee": '.$fee.'}'));
        }elseif ($request->input("btc_fee_type") == 3){
             $this->bitcoin->bumpfee($transaction->result,json_decode('{"confTarget": 3,"totalFee": '.($fee*3).'}'));
        }

        $user->btc_balance = $user->btc_balance - $amount;
        $user->save();

        $new_transaction = new UserTransactions();
        $new_transaction->tx_id = $transaction->result;
        $new_transaction->user_id = $user->id;
        $new_transaction->address = $information->result['details'][0]['address'];
        $new_transaction->currency = 1;
        $new_transaction->amount = $information->result['details'][0]['amount'];
        $new_transaction->type = "Withdraw";
        $new_transaction->confirmations = $information->result['confirmations'];
        $new_transaction->status = "Completed";
        $new_transaction->save();

        return redirect()->back()->with('success','Payment Sent. Transaction ID : '.$transaction->result);


    }

    public function isSystemAddress($address){
        $address = UserAddresses::where("btc_address",$address)->first();
        if($address){
            return true;
        }else{
            return false;
        }
    }

}
