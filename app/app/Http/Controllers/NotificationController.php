<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\Alert;
use MetaTag;


class NotificationController extends Controller
{
    public function index(){
        MetaTag::set('title', "Notifications");

        // $details = [
        //     'message' => "Welcome at Roman Road! A safe environment where sellers and buyers can meet up without any limitation.",
        //     'image' => "/web/images/icon.png",
        //  ];

        // auth()->user()->notify(new Alert($details));

        //  $fak = [
        //     'message' => "A Roman Road Staff has responded to your ticket",
        //     'image' => "/web/images/icon.png",
        //     'url'   => "/help/1"
        //  ];

        // auth()->user()->notify(new Alert($fak));

        // $dan = [
        //     'message' => "A Roman Road Staff has responded to your dispute #2222",
        //     'image' => "/web/images/dispute.png",
        //     'url'   => "/help/1"
        //  ];

        // auth()->user()->notify(new Alert($dan));

        // $hoi = [
        //     'message' => "User Jeroen has made a dispute for sale #23112",
        //     'image' => "/web/images/dispute.png",
        //     'url'   => "/help/1"
        //  ];

        // auth()->user()->notify(new Alert($hoi));

        //  $has = [
        //     'message' => "New Bitcoin Deposit of 2 confirmations has come through!  We wish you a good and a safe day at shopping :)",
        //     'image' => "/web/images/btc.png",
        //     'url' => "/account/wallet/btc",
        //  ];

        // auth()->user()->notify(new Alert($has));

        // $dd = [
        //     'message' => "New Monero Deposit of 2 confirmations has come through! We wish you a good and a safe day at shopping :)",
        //     'image' => "/web/images/xmr.png",
        //     'url' => "/account/wallet/xmr",
        //  ];

        // auth()->user()->notify(new Alert($dd));


        // $ff = [
        //     'message' => "New Litecoin Deposit of 2 confirmations has come through! We wish you a good and a safe day at shopping :)",
        //     'image' => "/web/images/ltc.png",
        //     'url' => "/account/wallet/ltc",
        //  ];

        // auth()->user()->notify(new Alert($ff));

        // $gg = [
        //     'message' => "Vendor Jeroen has a new listing made called: asdasdasd check it fast :D",
        //     'image' => "https://cdn.shopify.com/s/files/1/1729/8573/products/The-Punisher-02.png?v=1519394547",
        //     'url' => "/listing/rEAbPqZJae/product-2",
        //  ];

        // auth()->user()->notify(new Alert($gg));


        return view('notifications');
    }

    public function delete($id){ 
        auth()->user()->notifications()
        ->where('id', $id)
        ->get()
        ->first()
        ->delete();

      return redirect()->back();
    }

    public function deleteAllNotifications(){ 
        auth()->user()->notifications()->delete();

      return redirect()->back();
    }


    public function markAllRead(){ 
        foreach(auth()->user()->notifications as $notification) {
                $notification->markAsRead();
        }
      return redirect()->back();
    }


    public function go($id){ 
        foreach(auth()->user()->notifications as $notification) {
            if($notification->id == $id) {
                $notification->markAsRead();
                return redirect($notification->data['url']);
            }
        }
      return redirect()->back();
    }

    public function notifyTranReceived($user,$amount,$currency){

        $details = [
            'message' => "Your transaction of ".$amount." ".$currency." has been received and will be available i you account after 2 confimations.",
            'image' => "/web/images/icon.png",
            'url' => "",
            'vendor' => ""
        ];

        $user = User::find($user);

        $user->notify(new Alert($details));

    }

    public function notifyOrderCreate($user,$order_id){

        $details = [
            'message' => "A new order has been made #".$order_id.".",
             'image' => "/web/images/icon.png",
             'url' => action("Account\PurchaseHistoryController@index"),
             'vendor' => ""
          ];

        $user = User::find($user);

        $user->notify(new Alert($details));

    }

    public function notifyOrderReceived($user,$order_id){

        $details = [
            'message' => "A new order has been made #".$order_id.".",
            'image' => "/web/images/icon.png",
            'url' => action("Account\OrdersController@accepted"),
            'vendor' => ""
        ];

        $user = User::find($user);

        $user->notify(new Alert($details));

    }

    public function notifyOrderAccept($user,$order_id){

        $details = [
            'message' => "Your order has been accepted by the seller #".$order_id.".",
            'image' => "/web/images/icon.png",
            'url' => action("Account\PurchaseHistoryController@index"),
            'vendor' => ""
        ];

        $user = User::find($user);

        $user->notify(new Alert($details));

    }

    public function notifyOrderShipped($user,$order_id){

        $details = [
            'message' => "your order been shipped to you. #".$order_id.".",
            'image' => "/web/images/icon.png",
            'url' => action("Account\PurchaseHistoryController@index"),
            'vendor' => ""
        ];

        $user = User::find($user);

        $user->notify(new Alert($details));

    }

    public function notifyOrderFinalized($user,$order_id,$transaction=""){

        $details = [
            'message' => "Order finalized and your transaction is released. #".$order_id.".",
            'image' => "/web/images/icon.png",
            'url' => action("Account\OrdersController@finalized"),
            'vendor' => ""
        ];

        $user = User::find($user);

        $user->notify(new Alert($details));

    }

    public function NotifyDisputeCreated($dispute){

        $details = [
            'message' => "Order has been disputed. #".$dispute->order_id,
            'image' => "/web/images/icon.png",
            'url' => action("Account\DisputeController@index"),
            'vendor' => ""
        ];

        $seller = User::find($dispute->seller_id);
        $buyer = User::find($dispute->buyer_id);

        $seller->notify(new Alert($details));
        $buyer->notify(new Alert($details));

    }

    public function NotifyDisputeDecision($dispute,$winner){

        $details = [
            'message' => "Dispute Decision",
            'image' => "/web/images/icon.png",
            'url' => action("Account\DisputeController@index"),
            'vendor' => ""
        ];

        $seller = User::find($dispute->seller_id);
        $buyer = User::find($dispute->buyer_id);

        if($winner == "buyer"){
            $details['message'] = "Dispute is resolved and money is refunded to the buyer";
        }else{
            $details['message'] = "Dispute is resolved and money is released to the vendor";
        }

        $seller->notify(new Alert($details));

        $buyer->notify(new Alert($details));

    }

}
