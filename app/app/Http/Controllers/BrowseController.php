<?php

namespace App\Http\Controllers;

use App\Models\CurrencyRates;
use App\Models\Listing;
use App\Models\Category;
use App\Models\News;
use MetaTag;


class BrowseController extends Controller
{

    public function listings() {
      
        $listingsRandom = Listing::where('spotlight')->get();
        $listingAds = Listing::whereNotNull('spotlight')->get();

        MetaTag::set('title', __("Browse listings"));

        $categories = Category::Where("parent_id","0")->get();

        $news = News::Where("featured","1")->get();

        $rates = new CurrencyRates();

        $btc_rates = $rates->where("currency_id",1)->first();
        $ltc_rates = $rates->where("currency_id",2)->first();
        $xmr_rates = $rates->where("currency_id",3)->first();

        return view('browse.index')->with("listingAds",$listingAds)->with("listingsRandom",$listingsRandom)->with("categories",$categories)->with("news",$news)->with(["btc_rates"=>$btc_rates,"ltc_rates"=>$ltc_rates,"xmr_rates"=>$xmr_rates]);
    }

    public function exchange($exchange){
        $exchange = strtoupper($exchange);
        session()->put('exchange', $exchange);
        return redirect()->back();
    }

}
