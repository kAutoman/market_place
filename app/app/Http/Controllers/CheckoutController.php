<?php

namespace App\Http\Controllers;

use App\Models\CurrencyRates;
use App\Models\MultisigTransactions;
use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Validator;
use MetaTag;
use GNUPG;


class CheckoutController extends Controller
{

	protected $btc_rates;
    protected $ltc_rates;
    protected $xmr_rates;

    public function __construct()
    {
        $rates = new CurrencyRates();

        $this->btc_rates = $rates->where("currency_id",1)->first();
        $this->ltc_rates = $rates->where("currency_id",2)->first();
        $this->xmr_rates = $rates->where("currency_id",3)->first();
    }

    public function index()
    {    
        MetaTag::set('title', "Check Out");


        if(session()->get('quantity') == null) {
            return redirect()->route('browse');
        }

        return view('checkout.index');
    }

    
    public function checkout($listing, Request $request) {

        $validator = Validator::make($request->all(), [
            'shipping_option' => 'required',
            'quantity' => 'required|integer|between:1,999',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        
        $shipping_method = new \stdClass();
        if(in_array($request->input('shipping_option'), $listing->shipping_options->pluck('id')->toArray())) {
            $shipping_method = $listing->shipping_options->where('id',$request->input('shipping_option'))->first();
            session()->put('shipping_method', $shipping_method);
        } else {
            abort(404);
        }

        $price = ($listing->price * $request->input('quantity')) + $shipping_method->price;
        $currency = $listing->currency;
        switch($request->input('paymentmethod')) {

            case 1:
                $price = $price / $this->btc_rates->$currency;
                if($price > auth()->user()->btc_balance && $listing->payment_type_id != 4) {
                    return redirect()->back()->with('error','You have currently not enough Bitcoin to buy this product.');
                }
                session()->put('payment_method', $request->input('paymentmethod'));
            break;
            case 2:
                $price = $price / $this->ltc_rates->$currency;
                if($price > auth()->user()->ltc_balance) {
                    return redirect()->back()->with('error','You have currently not enough Litecoin to buy this product.');
                }
                session()->put('payment_method', $request->input('paymentmethod'));
                break;
            case 3:
                $price = $price / $this->xmr_rates->$currency;
                if($price > auth()->user()->xmr_balance) {
                    return redirect()->back()->with('error','You have currently not enough Monero to buy this product.');
                }
                session()->put('payment_method', $request->input('paymentmethod'));
            break;
            default:
            abort(404);
        }
    

        session()->put('quantity', $request->input('quantity'));
        session()->put('listing', $listing);

        $address = "";
        $btc_price = 0;

        if($listing->payment_type_id == 4){

            if(strlen(auth()->user()->multisig_key_pub) < 65 || strlen(auth()->user()->address_refunds) < 25 ){
                return redirect()->back()->with('error','Invalid public key or refund address');
            }
            session()->forget('price');
            session()->put('price', $price);
            $btc_price = file_get_contents("https://blockchain.info/tobtc?currency=USD&value=".$price);
            $listing->btc_price = $btc_price;
            $multisig = new MultisigController();
            $fee = $multisig->GetTransactionFee();
            $btc_price = $btc_price + $fee;
            $address = $multisig->CreateMultiSig($listing,auth()->user()->id);
        }

        session()->forget('address');
        if(is_object($address)){
        session()->put('address', $address->result['address']);
        }
        session()->put('btc_price', $btc_price);

        return redirect('checkout');
    }

    public function CheckMultisig($address){

        $multisig = new MultisigController();
        $content = array();
        if($multisig->CheckMultiSigAmount($address)){
            $content['response'] = "paid";
        }else{
            $content['response'] = "pending";
        }



        return response($content)
            ->header('Content-Type', "application/json");

    }

    public function placingOrder(Request $request) {
        $validator = Validator::make($request->all(), [
            'agremeent' => 'required',
            'shipping' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $listingOrder = $request->session()->get('listing');
        $user = User::find(auth()->user()->id);
        if($listingOrder == null) {
            abort(404);
        }

        $paymentmethod = $request->session()->get('payment_method');
        $total_amount = ($listingOrder->price * $request->session()->get('quantity')) + $request->session()->get('shipping_method')->price;
        switch($paymentmethod) {
            case 1:
                $currency = $listingOrder->currency;
                $btc_total = $total_amount / $this->btc_rates->$currency;
                if($listingOrder->payment_type_id != 4){ // do not apply for multisig
                    if($btc_total > $user->btc_balance ) {
                        return redirect()->back()->with('error','You have currently not enough Bitcoin to buy this product.');
                    }
                    $user->btc_balance = $user->btc_balance - $btc_total;
                }else{
                    $multisig = new MultisigController();
                    if(!$multisig->CheckMultiSigAmount($request->session()->get("address"))){
                        return redirect()->back()->with('error','Payment hasn\'t been received yet. If you have just sent it please wait a few seconds before submitting');
                    }
                }
            break;
            case 2:
                $currency = $listingOrder->currency;
                $ltc_total = $total_amount / $this->ltc_rates->$currency;
                if($ltc_total > $user->ltc_balance) {
                    return redirect()->back()->with('error','You have currently not enough Litecoin to buy this product.');
                } 
                $user->ltc_balance = $user->ltc_balance - $ltc_total;
            break;
            case 3:
                $currency = $listingOrder->currency;
                $xmr_total = $total_amount / $this->xmr_rates->$currency;
                if($xmr_total > $user->xmr_balance) {
                    return redirect()->back()->with('error','You have currently not enough Monero to buy this product.');
                }
                $user->xmr_balance = $user->xmr_balance - $xmr_total;
            break;
        }
        $user->save();

        $message = '';
        if($listingOrder->user->pgp_key != null) {
            $gpg = new gnupg();
            $info = $gpg->import($listingOrder->user->pgp_key);
            $gpg->addencryptkey($info['fingerprint']);
            $message = $gpg->encrypt($request->input('shipping'));
        }

        $order = new Order;
        $order->listing_id = $listingOrder->id;
        $order->seller_id = $listingOrder->user_id;
        $order->user_id = $user->id;
        $order->shipping_id = $request->session()->get('shipping_method')->id;
        $order->status = 'processing';
        $order->currency = $paymentmethod == 1 ? 'BTC' : $paymentmethod == 2 ? 'XMR' : $paymentmethod == 3 ? $paymentmethod : '';
        $order->amount = $request->session()->get('quantity');
        $order->price = (($listingOrder->price * $request->session()->get('quantity'))  + $request->session()->get('shipping_method')->price);
        $order->service_fee = (($listingOrder->price * $request->session()->get('quantity')) + $request->session()->get('shipping_method')->price) * (setting('marketplace_transaction_fee')/100);
        $order->payment_type_id = $listingOrder->payment_type_id;
        $order->shipping_address = $message;
        $order->save();

        if($listingOrder->payment_type_id == 4){
            $notifications = new NotificationController();
            $notifications->notifyTranReceived(auth()->user()->id,$order->price,"USD");
            $notifications->notifyOrderCreate(auth()->user()->id,$order->id);
            $notifications->notifyOrderReceived($listingOrder->user_id,$order->id);
            MultisigTransactions::where("multisig_address",$request->session()->get("address"))->update(["order_id" => $order->id]);
        }

        $request->session()->forget('shipping_method');
        $request->session()->forget('payment_method');
        $request->session()->forget('quantity');
        $request->session()->forget('listing');
        $request->session()->forget('address');
        $request->session()->forget('btc_price');
        return redirect()->route('account.purchase-history.show',$order)->with('message','Order has been successfully placed, the vendor has 3 days to accept the order. Don\'t forget to dispute the order or extend it when order has been shipped! <br><b>DONT FE ORDER IF THE VENDOR ASK</b>');

    }

}
