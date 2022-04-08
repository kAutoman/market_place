<?php

namespace App\Http\Controllers\Account;

use App\Models\ServerCredentials;
use App\Litecoin\Litecoin;
use App\Models\UserAddresses;
use App\Models\User;
use App\Models\UserTransactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use MetaTag;

class LiteCoinController extends Controller
{

    protected $ltc_credentials;
    protected $litecoin;

    public function __construct(){
        $this->ltc_credentials = ServerCredentials::where("currency",2)->first();
        $this->litecoin = new Litecoin($this->ltc_credentials->username,$this->ltc_credentials->password,$this->ltc_credentials->host,$this->ltc_credentials->port);
    }

    public function index() {
        MetaTag::set('title', "Litecoin Wallet");
        $user = User::find(auth()->user()->id);
        $address = $user->GetLTCAddress();
        $transactions = UserTransactions::where("user_id",$user->id)->where("currency",2)->get();
        $fee = $this->litecoin->estimatesmartfee(6);
        $fee->result['feerate'] = number_format($fee->result['feerate'], 8, '.', ",");
        return view('wallet.ltc')->with(["address"=>$address,"user" => $user,"transactions" => $transactions, "ltc_fee" => $fee->result['feerate']]);
    }

    public function Withdraw(Request $request){

        $user = User::find(auth()->user()->id);

        if (strlen($request->input("ltcaddress")) < 30 || strlen($request->input("ltcaddress")) > 45){
            return redirect()->back()->with('error','Invalid address.');
        }

        if ($request->input("withdrawPIN") != $user->withdrawpin){
            return redirect()->back()->with('error','Wrong PIN code.');
        }

        if($request->input("ltcamount") > $user->ltc_balance){
            return redirect()->back()->with('error','Not enough balance.');
        }

        if($this->isSystemAddress($request->input("ltcaddress"))){
            return redirect()->back()->with('error','Can\'t withdraw to an address on the system.');
        }

        $amount = $request->input("ltcamount");
        if($request->input("max")=="max"){
            $amount = $user->ltc_balance;
        }
        $system_fee = $amount * 0.009;
        $send_amount = $amount - $system_fee;
        $fee = $this->litecoin->estimatesmartfee(6);
        $fee = $fee->result['feerate'];
        if($request->input("ltc_fee_type") == 2){
            $send_amount = $send_amount - $fee;
        }elseif ($request->input("ltc_fee_type") == 3){
            $send_amount = $send_amount - ($fee*3);
        }
        if($send_amount <= 0){
            return redirect()->back()->with('error','Not enough balance.');
        }
        $send_amount = number_format($send_amount,8);
        $transaction = $this->litecoin->sendtoaddress($request->input("ltcaddress"),$send_amount,"","",true);
        if(!is_object($transaction)){
            return redirect()->back()->with('error','Error sending the transaction please contact support.');
        }
        $information = $this->litecoin->gettransaction($transaction->result);
        if(!is_object($information)){
            return redirect()->back()->with('error','Error sending the transaction please contact support.');
        }

        if($request->input("ltc_fee_type") == 2){
            $this->litecoin->bumpfee($transaction->result,json_decode('{"confTarget": 3,"totalFee": '.$fee.'}'));
        }elseif ($request->input("ltc_fee_type") == 3){
            $this->litecoin->bumpfee($transaction->result,json_decode('{"confTarget": 3,"totalFee": '.($fee*3).'}'));
        }

        $user->ltc_balance = $user->ltc_balance - $amount;
        $user->save();

        $new_transaction = new UserTransactions();
        $new_transaction->tx_id = $transaction->result;
        $new_transaction->user_id = $user->id;
        $new_transaction->address = $information->result['details'][0]['address'];
        $new_transaction->currency = 2;
        $new_transaction->amount = $information->result['details'][0]['amount'];
        $new_transaction->type = "Withdraw";
        $new_transaction->confirmations = $information->result['confirmations'];
        $new_transaction->status = "Completed";
        $new_transaction->save();

        return redirect()->back()->with('success','Payment Sent. Transaction ID : '.$transaction->result);

    }

    public function isSystemAddress($address){
        $address = UserAddresses::where("ltc_address",$address)->first();
        if($address){
            return true;
        }else{
            return false;
        }
    }

}
