<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Models\Filter;
use App\Models\Listing;
use App\Models\Category;


use MetaTag;

class ListingController extends Controller
{

    protected $category_id;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index($listing, $slug, Request $request)
    {
	
        $data = [];
        $visible_listing = $listing->is_published && !$listing->is_disabled;
        $can_edit = auth()->check() && (auth()->user()->id == $listing->user_id || auth()->user()->can('edit listing'));

        if(!$visible_listing && !$can_edit) {
            return abort(404);
        }

		$breadcrumbs = [];
        $category = $listing->category;


		if($category) {
            $i = 0;
			while($category = $category->child) {
                $breadcrumbs[] = $category;
				$i ++;
				if($i == 5)
					break;
            }
        }
        
        $data['breadcrumbs'] = array_reverse($breadcrumbs);


        $listing->load('shipping_options');
        
        $listing->views_count = $listing->views_count + 1;
        $listing->save();

        $data['listing'] = $listing;


        $data['seller'] = $listing->user;
        $data['comments'] = $listing->comments()->orderBy('created_at', 'DESC')->get();

        MetaTag::set('title', $listing->title);
     
        return view('listing.show', $data);
    }

	public function card($listing, $slug, Request $request) {
		
        $data = [];
        $visible_listing = $listing->is_published && $listing->is_admin_verified && !$listing->is_disabled;
        if(!$visible_listing && !$can_edit) {
            return abort(404);
        }

        $data['listing'] = $listing;
        $data['seller'] = $listing->user;
		
        MetaTag::set('title', $listing->title);
        MetaTag::set('description', $listing->description);
        MetaTag::set('image', url($listing->thumbnail));
        return view('listing.card', $data);
    }

    public function star($listing) {
        $listing->toggleFavorite();
        return redirect()->back()->with('message','You have succesfull added this listing as your favourite.');
    }


    public function follow($listing) {
        if(auth()->user()->getIsFollowed($listing->user)) {
            auth()->user()->unfollow($listing->user);
            return redirect()->back()->with('message','You have now unfollowed now the user: '.$listing->user->username.' any updates of this user will be ignored.');
        } else {
            auth()->user()->follow($listing->user);
            return redirect()->back()->with('message','You follow now the user: '.$listing->user->username.' any updates of this user will gets you notified.');
        }
    }

    public function spotlight($listing) {
        if(auth()->user()->can('disable listing')) {
            $listing->toggleSpotlight();
        }
        return redirect(route('listing', [$listing, $listing->slug]));
    }
    public function verify($listing) {
        if(auth()->user()->can('disable listing')) {
            if($listing->is_admin_verified && !$listing->is_disabled) {
                $listing->is_disabled = Carbon::now();
            } elseif($listing->is_admin_verified && $listing->is_disabled) {
                $listing->is_disabled = null;
            }


            $listing->save();
        }
        return redirect(route('listing', [$listing, $listing->slug]));
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($listing)
    {
        $data = [];
        $data['listing'] = $listing;
        $categories = Category::nested()->get();
        $categories = flatten($categories, 0);
        $list = [];
        foreach($categories as $category) {
            $list[''] = '';
            $list[$category['id']] = str_repeat("&mdash;", $category['depth']+1) . " " .$category['name'];
        }

        $data['categories'] = $list;


   

        $selected_category = null;
        $selected_category = Category::find(request('category', $listing->category_id));

        $data['selected_category'] = $selected_category;
        $data['form'] = 'edit';

        return view('create..partials.details', $data);
    }
	
}
