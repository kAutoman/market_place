<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\NotificationController;
use App\Models\MultisigTransactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Comment;
use MetaTag;
use Validator;
use App\Http\Controllers\MultisigController;

class PurchaseHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        MetaTag::set('title', "Orders");
        MetaTag::set('id', "6");

        $orders = Order::with('listing', 'listing.user')->where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->paginate(10);
        
		return view('account.purchase_history.index', compact('orders'));
    }

    public function feedbackPage($order, Request $request)
    {
         if($order->status != "finalized") {
            abort(404);
        } 

        if($order->user_id != auth()->user()->id) {
            return abort(404);
        }

        $comment = Comment::where('commenter_id',auth()->user()->id)->where('order_id',$order->id)->first();


        MetaTag::set('title', "Leave Feedback");
        MetaTag::set('id', "6");


        return view('account.purchase_history.feedback', compact('order','comment'));
        
    }


    public function finalizeOrder($order, Request $request) {
        if($order->user_id != auth()->user()->id) {
          abort(404);
        }

        if($order == null) {
            abort(404);
        }

        if($order->status != "shipped" || $order->status == "finalized") {
            abort(404);
        }

        $order->status="finalized";


        $seller = $order->seller;

        if($order->payment_type_id == 4){
            $multisig = new MultisigController();
            $multisig_record = MultisigTransactions::where("order_id",$order->id)->first();
            $multisig_release = $multisig->SendMultiSigTransaction($multisig_record,$seller->address_sales);
            if(isset($multisig_release->result) && !isset($multisig_release->error)){
                $notifications = new NotificationController();
                $notifications->notifyOrderFinalized($order->seller_id,$order->id,$multisig_release->result);
                $order->save();
                $seller->save();
            }else{
                return redirect()->back()->with('error','Error during releasing the transaction , please contact support.');
            }

        }else{

            $order->save();

            switch($order->currency) {
                case "XMR":
                   $seller->xmr_balance = $seller->xmr_balance + (($order->price * $order->amount) - $order->service_fee);
                break;
                case "BTC":
                    $seller->btc_balance = $seller->btc_balance + (($order->price * $order->amount) - $order->service_fee);
                break;
                case "LTC":
                    $seller->ltc_balance = $seller->ltc_balance + (($order->price * $order->amount) - $order->service_fee);
                break;
            }

            $seller->save();

        }

        return redirect()->route('account.give.feedback',$order)->with('message','You have finalized the order. The funds will be now transfered to the vendor. It is optional to leave a feedback.');

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($order, Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($order)
    {
       
        if($order->user_id != auth()->user()->id) {
            return abort(404);
        }

        MetaTag::set('title', "Order Detail");
        MetaTag::set('id', "6");



		return view('account.purchase_history.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($id == null) {
            return abort(404);
        }

        if($id->user_id != auth()->user()->id) {
            return abort(404);
        }

        if($id->status != "finalized") {
            return abort(404);
        } 

        $comment = Comment::where('commenter_id',auth()->user()->id)->where('order_id',$id->id)->first();
        if($comment != null) {
            return redirect()->back()->with('message','You have already placed rating');
        }

        $validator = Validator::make(request()->all(), [
            'rating' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $comment = new Comment;

        switch($request->input('rating')) {
            case 1:
         $comment->rate= 1;
            break;
            case 2:
                $comment->rate= 2;
            break;
            case 3:
                $comment->rate= 3;
            break;
            case 4:
                $comment->rate= 4;
            break;
            case 5:
                $comment->rate= 5;
            break;
        }

        if($request->input('notes') != null) {
            $comment->comment= $request->input('notes');
        }

        $comment->order_id=$id->id;
        $comment->listing_id=$id->listing_id;
        $comment->commenter_id=$id->user_id;
        $comment->seller_id=$id->seller_id;
        $comment->save();

        return redirect()->back()->with('message','Rating has been succesfull placed');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
