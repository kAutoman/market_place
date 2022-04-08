<?php

namespace App\Http\Controllers\Account;

use App\Models\MultisigTransactions;
use App\Http\Controllers\MultisigController;
use App\Http\Controllers\NotificationController;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dispute;
use App\Models\DisputeReply;
use App\Models\Order;


use MetaTag;
use Validator;

class DisputeController extends Controller
{
    public function index() {
        MetaTag::set('title', "Disputes");
        MetaTag::set('vendor_id', 15);
        MetaTag::set('id', "2");

        return view('account.disputes.dispute');
    }

    public function ModeratorIndex(){

        if(auth()->user()->is_admin != 1){
            return redirect()->back();
        }

        $disputes = Dispute::where("resolved",0)->get();

        foreach ($disputes as $dispute){

            $dispute->seller = User::find($dispute->seller_id);
            $dispute->buyer = User::find($dispute->buyer_id);

        }

        return view('account.disputes.moderator')->with(["disputes" => $disputes]);

    }

    public function ModeratorDecide($id){

        if(auth()->user()->is_admin != 1){
            return redirect()->back();
        }

        $decide_dispute = Dispute::find($id);
        $decide_dispute->seller = User::find($decide_dispute->seller_id);
        $decide_dispute->buyer = User::find($decide_dispute->buyer_id);

        $disputes = Dispute::where("resolved",0)->get();

        foreach ($disputes as $dispute){

            $dispute->seller = User::find($dispute->seller_id);
            $dispute->buyer = User::find($dispute->buyer_id);

        }

        return view('account.disputes.decide')->with(["decide_dispute" => $decide_dispute,"disputes" => $disputes]);

    }

   public function ModeratorDecision($id,$winner){
       if(auth()->user()->is_admin != 1){
           return redirect()->back();
       }
       $decision_dispute = Dispute::find($id);
       $decision_dispute->seller = User::find($decision_dispute->seller_id);
       $decision_dispute->buyer = User::find($decision_dispute->buyer_id);

       $multisig = new MultisigController();
       $multisig_record = MultisigTransactions::where("order_id",$decision_dispute->order_id)->first();
       $order = Order::find($decision_dispute->order_id);
       $multisig_release = new \stdClass();
       $notifications = new NotificationController();

       switch ($winner){
           case "buyer":
               $multisig_release = $multisig->SendMultiSigTransaction($multisig_record,$decision_dispute->buyer->refund_sales);
               $order->status="canceled";
               break;
           case "seller":
               $multisig_release = $multisig->SendMultiSigTransaction($multisig_record,$decision_dispute->seller->address_sales);
               $order->status="finalized";
               break;
       }

       if(isset($multisig_release->result) && !isset($multisig_release->error)){
           $notifications->NotifyDisputeDecision($decision_dispute,$winner);
           $order->save();
       }else{
           return redirect()->back()->with('error','Error during releasing the transaction , please contact support.');
       }

       return redirect()->route('account.dispute.moderator');

   }

    public function dispute($id) {
        $dispute = Dispute::where('id',$id)->first();

        if ($dispute == null) {
            return redirect()->back();
        }

        if (auth()->user()->id !== $dispute->seller->id && auth()->user()->id !== $dispute->buyer->id ) {
            if (auth()->user()->is_admin != 1) {
                return redirect()->back();
            }
        }

        MetaTag::set('title', "Dispute #".$id);
        MetaTag::set('vendor_id', 15);
        MetaTag::set('id', "2");


        return view('account.disputes.show')->with([
        'single_dispute'=>$dispute
      ]);
    }

    public function createDispute($id,Request $request){
        $order = Order::where('id',$id)->first();

        if($order == null) {
            return redirect()->back();
        }

        if(auth()->user()->id !== $order->user_id) {
            return redirect()->back();
        }

        if($order->status != "shipped") {
            return redirect()->back();
        }

        $dispute = new Dispute;
        $dispute->seller_id = $order->seller_id;
        $dispute->buyer_id = $order->user_id;
        $dispute->order_id = $order->id;
        $dispute->save();

        $notifications = new NotificationController();
        $notifications->NotifyDisputeCreated($dispute);

        $order->status="disputed";
        $order->save();

        return redirect('/account/dispute/0/'.$dispute->id);

    }

    public function sentMessage($id, Request $request) {

        $dispute = Dispute::where('id',$id)->first();
        if ($dispute == null) {
            return redirect()->back();
        }

        if (auth()->user()->id !== $dispute->seller->id && auth()->user()->id !== $dispute->buyer->id ) {
            if (auth()->user()->is_admin != 1) {
                return redirect()->back();
            }
        }

        if($dispute->resolved == 1) {
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $reply = new DisputeReply;
        $reply->user_id = auth()->user()->id;
        $reply->dispute_id = $dispute->id;
        $reply->message = $request->message;
        $reply->save();

        return redirect()->back();


    }


    public function cancel($id, Request $request) {
        $dispute = Dispute::where('id',$id)->first();
        if ($dispute == null) {
            return redirect()->back();
        }
        if($dispute->resolved == 1) {
            return redirect()->back();
        }

        if (auth()->user()->id == $dispute->buyer->id ) {
            $reply = new DisputeReply;
            $reply->user_id = 0;
            $reply->dispute_id = $dispute->id;
            $reply->adminreply = 1;
            $reply->message = "Buyer has cancelled the dispute which makes the order finalized. The vendor will get the funds now transfered.";
            $reply->save();
    
            $order = $dispute->order;
            $order->status = "finalized";
            $order->save();
    
            $dispute->resolved = 1;
            $dispute->winner = $dispute->seller->id;
            $dispute->save();
        } else if (auth()->user()->id == $dispute->seller->id) {
            $reply = new DisputeReply;
            $reply->user_id = 0;
            $reply->dispute_id = $dispute->id;
            $reply->adminreply = 1;
            $reply->message = "Vendor has cancelled the dispute. The buyer will get the funds now transfered.";
            $reply->save();
    
            $order = $dispute->order;
            $order->status = "cancelled";
            $order->save();
    
            $dispute->resolved = 1;
            $dispute->winner = $dispute->buyer->id;
            $dispute->save();
        } else {
            return redirect()->back();
        }
 
        return redirect()->back();

    }


}
