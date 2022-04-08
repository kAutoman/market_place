<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\User;
use Carbon\Carbon;
use MetaTag;
use Validator;
class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($listing)
    {
        if(auth()->user()->id != $listing->user_id) {
            abort(404);
        }

        MetaTag::set('title', "Buy Ads");
        MetaTag::set('id', "2");
        MetaTag::set('vendor_id', "2");

        $count = 10 - Listing::whereNotNull('spotlight')->get()->count();

        
        $data = [];
        $data['listing'] = $listing;
        $data['count'] = $count;

		return view('account.ads',$data);
    }

    public function buyingAds($listing,Request $request) {
        if(auth()->user()->id != $listing->user_id) {
            abort(404);
        }

        // dd(Carbon::now()->addDays(5));


        $count = 10 - Listing::whereNotNull('spotlight')->get()->count();
        if($request->input('stara3') != null && $count == 0) {
            return redirect()->back()->with('error','This is already sold out. Please try again later');
        }

        switch($request->input('stara1')) {
            case 'xmr':
                if(auth()->user()->xmrBalance(10)) {
                    $listing->bold_until = Carbon::now()->addDays(5);
                    $listing->save();
                return redirect()->back()->with('message','You have succesfull bought the ads. The ads is now active and will only be active for 5 days.');
                } else {
                return redirect()->back()->with('error','You don\'t have enough Monero balance. Please deposit first');
                }
            break;
            case 'btc':
                if(auth()->user()->btcBalance(10)) {
                    $listing->bold_until = Carbon::now()->addDays(5);
                    $listing->save();
                    return redirect()->back()->with('message','You have succesfull bought the ads. The ads is now active and will only be active for 5 days.');
                    } else {
                    return redirect()->back()->with('error','You don\'t have enough Bitcoin balance. Please deposit first');
                    }
            break;
            case 'ltc':
                if(auth()->user()->ltcBalance(10)) {
                    $listing->bold_until = Carbon::now()->addDays(5);
                    $listing->save();
                    return redirect()->back()->with('message','You have succesfull bought the ads. The ads is now active and will only be active for 5 days.');
                    } else {
                    return redirect()->back()->with('error','You don\'t have enough Litecoin balance. Please deposit first');
                 }
            break; 
        }

        switch($request->input('stara2')) {
            case 'xmr':
                if(auth()->user()->xmrBalance(10)) {
                    $listing->priority_until = Carbon::now()->addDays(5);
                    $listing->save();
                return redirect()->back()->with('message','You have succesfull bought the ads. The ads is now active and will only be active for 5 days.');
                } else {
                return redirect()->back()->with('error','You don\'t have enough Monero balance. Please deposit first');
                }
            break;
            case 'btc':
                if(auth()->user()->btcBalance(10)) {
                    $listing->priority_until = Carbon::now()->addDays(5);
                    $listing->save();
                    return redirect()->back()->with('message','You have succesfull bought the ads. The ads is now active and will only be active for 5 days.');
                    } else {
                    return redirect()->back()->with('error','You don\'t have enough Bitcoin balance. Please deposit first');
                    }
            break;
            case 'ltc':
                if(auth()->user()->ltcBalance(10)) {
                    $listing->priority_until = Carbon::now()->addDays(5);
                    $listing->save();
                    return redirect()->back()->with('message','You have succesfull bought the ads. The ads is now active and will only be active for 5 days.');
                    } else {
                    return redirect()->back()->with('error','You don\'t have enough Litecoin balance. Please deposit first');
                 }
            break; 
        }

        switch($request->input('stara3')) {
            case 'xmr':
                if(auth()->user()->xmrBalance(10)) {
                    $listing->spotlight = Carbon::now()->addDays(5);
                    $listing->save();
                return redirect()->back()->with('message','You have succesfull bought the ads. The ads is now active and will only be active for 5 days.');
                } else {
                return redirect()->back()->with('error','You don\'t have enough Monero balance. Please deposit first');
                }
            break;
            case 'btc':
                if(auth()->user()->btcBalance(10)) {
                    $listing->spotlight = Carbon::now()->addDays(5);
                    $listing->save();
                    return redirect()->back()->with('message','You have succesfull bought the ads. The ads is now active and will only be active for 5 days.');
                    } else {
                    return redirect()->back()->with('error','You don\'t have enough Bitcoin balance. Please deposit first');
                    }
            break;
            case 'ltc':
                if(auth()->user()->ltcBalance(10)) {
                    $listing->spotlight = Carbon::now()->addDays(5);
                    $listing->save();
                    return redirect()->back()->with('message','You have succesfull bought the ads. The ads is now active and will only be active for 5 days.');
                    } else {
                    return redirect()->back()->with('error','You don\'t have enough Litecoin balance. Please deposit first');
                 }
            break; 
        }
        
    }



}
