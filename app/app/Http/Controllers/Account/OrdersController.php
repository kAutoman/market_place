<?php

namespace App\Http\Controllers\Account;


use App\Http\Controllers\NotificationController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;

use MetaTag;
use Talk;
use App\Http\Controllers\MultisigController;
use App\Models\MultisigTransactions;
class OrdersController extends Controller
{

    public function index()
    {

        MetaTag::set('title', "Processing Orders");
        MetaTag::set('sub_id', "11");
        MetaTag::set('vendor_id', "5");
        MetaTag::set('id', "2");

        if(auth()->user()->trader_type != "individual" ) {
            abort(404);
        }


        $orders = Order::with('listing','user')->where('seller_id', auth()->user()->id)->process()->orderBy('created_at', 'DESC')->paginate(10);


        // dd($orders[0]->elapsed('updated_at'));

        

        // if($orders[0]->updated_at->addDay(3) < Carbon::now()) {
        //     dd('hoi');
        // }
        
        
        // dd($orders[0]->updated_at);


        return view('account.orders.index', compact('orders'));
    }

    public function accepted()
    {
        if(auth()->user()->trader_type != "individual" ) {
            abort(404);
        }

        MetaTag::set('title', "Accepted Orders");
        MetaTag::set('sub_id', "12");
        MetaTag::set('vendor_id', "5");
        MetaTag::set('id', "2");


        $orders = Order::with('listing','user')->where('seller_id', auth()->user()->id)->accepted()->orderBy('created_at', 'DESC')->paginate(10);
        return view('account.orders.accepted', compact('orders'));
    }


    public function shipped()
    {
        if(auth()->user()->trader_type != "individual" ) {
            abort(404);
        }

        MetaTag::set('title', "Shipped Orders");
        MetaTag::set('vendor_id', "5");
        MetaTag::set('id', "2");
        MetaTag::set('sub_id', "13");

        $orders = Order::with('listing','user')->where('seller_id', auth()->user()->id)->shipped()->orderBy('created_at', 'DESC')->paginate(10);

        return view('account.orders.shipped', compact('orders'));
    }

    public function cancelled()
    {
        if(auth()->user()->trader_type != "individual" ) {
            abort(404);
        }

        MetaTag::set('title', "Cancelled/Refunded Orders");
        MetaTag::set('sub_id', "14");
        MetaTag::set('vendor_id', "5");
        MetaTag::set('id', "2");


        $orders = Order::with('listing','user')->where('seller_id', auth()->user()->id)->cancelled()->orderBy('created_at', 'DESC')->paginate(10);
        return view('account.orders.cancelled', compact('orders'));
    }

    public function dispute()
    {
        if(auth()->user()->trader_type != "individual" ) {
            abort(404);
        }

        MetaTag::set('title', "Disputed Orders");
        MetaTag::set('sub_id', "15");
        MetaTag::set('vendor_id', "5");
        MetaTag::set('id', "2");


        $orders = Order::with('listing','user')->where('seller_id', auth()->user()->id)->dispute()->orderBy('created_at', 'DESC')->paginate(10);
        return view('account.orders.disputed', compact('orders'));
    }


    public function finalized()
    {
        if(auth()->user()->trader_type != "individual" ) {
            abort(404);
        }

        MetaTag::set('title', "Finalized Orders");
        MetaTag::set('sub_id', "16");
        MetaTag::set('vendor_id', "5");
        MetaTag::set('id', "2");

        $orders = Order::with('listing','user')->where('seller_id', auth()->user()->id)->finalized()->orderBy('created_at', 'DESC')->paginate(10);
        return view('account.orders.finalized', compact('orders'));
    }


    public function show($order)
    {
        if(auth()->user()->trader_type != "individual" ) {
            abort(404);
        }

        if(auth()->user()->id != $order->seller_id ) {
                abort(404);
        }
        MetaTag::set('vendor_id', "5");
        MetaTag::set('id', "2");

        MetaTag::set('title', "Sale Details");


        $this->authorize('update', $order);


        return view('account.orders.show', compact('order'));
    }

    public function updateAll(Request $request) {


        if(auth()->user()->trader_type != "individual" ) {
            abort(404);
        }

        $ids = $request->input('ids');

        if($ids == null) {
            return redirect(route('account.orders.index'));
        }
        

        if($request->input('accept') && $ids) {
            foreach($ids as $id) {
                $order = Order::Find($id);
                if($order != null) {
                    if(auth()->user()->id != $order->seller_id ) {
                        abort(404);
                     } else {
                            $order->status="accepted";
                            $order->save();
                            return redirect(route('account.orders.index'))->with('message','The order(s) has been accepted.');
                     }

                } else {
                    abort(404);
                }
            }
        }

        switch($request->input('status')) {
            case "accept":
                foreach($ids as $id) {
                    $order = Order::Find($id);
                    if($order != null) {
                        if(auth()->user()->id != $order->seller_id ) {
                            abort(404);
                         } else {
                             if($order->status == "processing") {
                                $notifications = new NotificationController();
                                $notifications->notifyOrderAccept($order->user_id,$order->id);
                                $order->status="accepted";
                                $order->save();
                             } else {
                                abort(404);
                             }
                         }
    
                    } else {
                        abort(404);
                    }
                }
                return redirect(route('account.orders.index'))->with('message','The order(s) has been accepted.');

            break;
            case "cancel":
                foreach($ids as $id) {
                    $order = Order::Find($id);
                    if($order != null) {
                        if(auth()->user()->id != $order->seller_id ) {
                            abort(404);
                         } else {
                             $buyer = User::find($order->user_id);
                             if($order->status == "processing") {
                                $order->status="cancelled";
                                $order->save();
                             } else if($order->status == "accepted") {
                                $order->status="cancelled";
                                $order->save();
                             } else {
                                abort(404);
                             }
                         }
    
                    } else {
                        abort(404);
                    }
                }
                return redirect(route('account.orders.index'))->with('message','The order(s) has been cancelled.');
            break;
            case "ship":
                foreach($ids as $id) {
                    $order = Order::Find($id);
                    if($order != null) {
                        if(auth()->user()->id != $order->seller_id ) {
                            abort(404);
                         } else {

                            $multisig = new MultisigController();
                            $multisig_record = MultisigTransactions::where("order_id",$order->id)->first();

                            if(!$multisig->CheckMultiSigAmount($multisig_record->multisig_address,2)){
                                return redirect()->back()->with('error','Not enough confirmations for the transactions (2 required), please wait.');
                            }

                             if($order->status == "accepted") {
                                 $notifications = new NotificationController();
                                 $notifications->notifyOrderShipped($order->user_id,$order->id);
                                $order->status="shipped";
                                $order->save();
                             } else {
                                abort(404);
                             }
                         }
    
                    } else {
                        abort(404);
                    }
                }
                return redirect(route('account.orders.shipped'))->with('message','The order(s) has been shipped.');
            break;
        }


        return redirect()->back();
    }



    public function update(Request $request, $order)
    {

        if(auth()->user()->trader_type != "individual" ) {
            abort(404);
        }

        if(auth()->user()->id != $order->seller_id ) {
            abort(404);
         }

        $notifications = new NotificationController();
        switch($request->input('status')) {
            case "accept":
            $order->status="accepted";
            $notifications->notifyOrderAccept($order->user_id,$order->id);
            break;
            case "shipped":
            if($order->status == 'accepted') {
                $order->status="shipped";
                $notifications->notifyOrderShipped($order->user_id,$order->id);
            }
            break;
            case "cancel":
            if($order->status == 'processing') {
                $order->status="cancelled";
            } else if($order->status == 'accepted') {
                $order->status="cancelled";
            }
            break;
        }

        if($request->input('notes')) {
            $order->notes= $request->input('notes');
         }

        $order->save();

      

        return redirect(route('account.orders.show', $order))->with('message','Order has been succesfull updated');
    }
}
