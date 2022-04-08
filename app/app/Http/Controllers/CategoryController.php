<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\Category;
use App\Models\Country;
use App\Models\ListingSearch;
use App\Models\User;
use MetaTag;


class CategoryController extends Controller
{
    public function index($category_id){

        
        $category = Category::find($category_id); 

        if($category == null) {
            abort(404);
        }

   
        $categories = Category::nested()->get();
        $countries = Country::All();

        $categories_clear = flatten($categories, 0);

        $list = [];
        foreach($categories_clear as $categoryd) {
            $list[''] = '';
            $list[$categoryd['id']] = str_repeat("&mdash;", $categoryd['depth']+1) . " " .$categoryd['name'];
        }


        $data['categories_filter'] = $list;
        $data['categories'] = $categories;
        $data['countries'] = $countries;
        $data['category_choosed'] = $category;
        
        if($category->categories()->count() != 0) {
            $data['listings'] = Listing::where('category_id',$category_id)->active()->orWhere('category_id',$category->categories()->pluck('id')->toArray())->orderBy('priority_until', 'DESC')->paginate(10);
        } else {
            $data['listings'] = $category->listings()->orderBy('priority_until', 'DESC')->active()->paginate(10);
        }

        $breadcrumbs = [];


        MetaTag::set('title', __($category->name));

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


        return view('category.index',$data);
    }


    public function filter($category_id,Request $request) {

        $category = Category::find($category_id); //current category

        if($category == null) {
            abort(404);
        }


        $categories = Category::nested()->get();
        $countries = Country::All();

        $categories_clear = flatten($categories, 0);

        $list = [];
        foreach($categories_clear as $categoryd) {
            $list[''] = '';
            $list[$categoryd['id']] = str_repeat("&mdash;", $categoryd['depth']+1) . " " .$categoryd['name'];
        }


        $data['categories_filter'] = $list;
        $data['categories'] = $categories;
        $data['countries'] = $countries;
        $data['category_choosed'] = $category;
        

        $data['listings'] = ListingSearch::apply($request);

        $breadcrumbs = [];

        MetaTag::set('title', "Searching");

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


        return view('category.index',$data);

    }




    


}
