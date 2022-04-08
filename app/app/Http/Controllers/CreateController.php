<?php

namespace App\Http\Controllers;

use App\Models\ListingPlan;
use App\Models\ListingShippingOption;
use App\Models\ListingClass;
use App\Models\Country;


use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Filter;
use App\Models\Listing;
use App\Models\Category;
use Illuminate\Support\Facades\Input;

use Storage;
use Image;
use DB;
use Validator;
use MetaTag;
use File;

use Gerardojbaez\Laraplans\Models\Plan;
use Gerardojbaez\Laraplans\Models\PlanFeature;
class CreateController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {

        if(auth()->user()->trader_type != 'individual') {
            return redirect('/account/apply_vendor');
        }

        MetaTag::set('title', "Create Listing");

        $data = [];
        
        $countries = Country::All();
       

        $category = new Category();
        if(Input::old('category')) $cat_id = Input::old('category');
		else $cat_id ="";
        $cat_options = $category->getOptionCategories(0,$cat_id);
        
        $data['categories'] = $cat_options;
        $data['countries'] = $countries;

        $data['form'] = 'create';

        $view = 'listing.create.create_listing';

        return view($view, $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    #public function store(StoreListing $request)
    public function store(Request $request)
    {
		$rules = array(
			'title'		=>'required',
			'description'	=>'required',
			'category'		=> 'required',
			'price'			=> 'required|numeric',
            'ships_to'		=> 'required',	
            'shipped_from'		=> 'required',	
			'postage_shipping_1'		=> 'required',
			'postage_option_1'		=> 'required',
			'postage_price_1'		=> 'required|numeric',
            'image_1' => 'mimes:jpg,jpeg,png',
            'quantity'			=> 'required|numeric',

        );
              
        for ($i=2; $i <=8 ; $i++) { 
        	$postage_shipping = $request->input('postage_shipping_'.$i);
        	$postage_option = $request->input('postage_option_'.$i);
        	$postage_price = $request->input('postage_price_'.$i);
        	if(!empty($postage_shipping) || !empty($postage_option) || !empty($postage_price))
        		$rules += array(					
					'postage_shipping_'.$i		=> 'required',
					'postage_option_'.$i		=> 'required',
					'postage_price_'.$i		=> 'required|numeric'
		        );
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {            
            return redirect()->back()->withInput()->withErrors($validator);
        }  

        if ($request->hasFile('image_1')){
        	$size = $request->file('image_1')->getSize();
        	if(($size/1024) > 512) return redirect()->back()->withInput()->with('error','The size of image 1 must to less than or equal to 512Kb');
        }


        //save
        $listing = new Listing();
        $listing->user_id = auth()->user()->id;
        $listing->title = $request->input('title');
        $listing->description = $request->input('description');
        $listing->tags = $request->input('tags');
        $listing->category_id = $request->input('category');
        $listing->listing_class_id = $request->input('listingclass') == 1 ? 1 : 2;
        $listing->is_published = $request->input('status') == 1 ? 1 : 0;

        if(auth()->user()->has_fe != 1 ) {
            if($request->input('escrow') == 3 || $request->input('escrow') == 2 ) {
                redirect()->back()->with('error','<strong>Error!</strong> The listing was not updated.');
           } else {
              $listing->payment_type_id = $request->input('escrow');
           }
        } 
   

        $listing->currency = $request->input('currency');
        $listing->price = $request->input('price');
        if($request->input('quantity') < 1){
            return redirect()->back()->withInput()->with('error','Quantity can\'t be less than 1.');
        }
        $listing->quantity = $request->input('quantity');
        $listing->shipped_from = $request->input('shipped_from');
        $listing->ships_to =  serialize($request->input('ships_to'));

        if($listing->save()){
        	//save postage        	
        	for ($i=1; $i <=8 ; $i++) { 
	        	$postage_shipping = $request->input('postage_shipping_'.$i);
	        	$postage_option =  $request->input('postage_option_'.$i);
	        	$postage_price =  $request->input('postage_price_'.$i);
	        	if(!empty($postage_shipping) && !empty($postage_option) & !empty($postage_price)){
	        		$postage = new ListingShippingOption();
	        		$postage->listing_id = $listing->id;
	        		$postage->name = $postage_option;
                    $postage->days = $postage_shipping;
                    $postage->price = $postage_price;
	        		$postage->save();
                }
            }
            
             //save image
         $destinationPath = public_path().'/uploads/listings_images/';
         if ($request->hasFile('image_1')){
            $file = $request->file('image_1');

            $filename_ = str_random(25);
            $filename = preg_replace("/[^a-zA-Z0-9\.]/", "", strtolower($file->getClientOriginalName()));

            $file_uploaded=$filename_.'_'.$filename;

            $upload_success  = $file->move($destinationPath, $file_uploaded); 
        
            if( $upload_success ) {
                $listing->photo =  '/uploads/listings_images/'.$file_uploaded;
                $listing->save();                                            
            }
        }

	              
        }

       return redirect()->route('listing', ['id' => $listing, 'slug' => $listing->title])->with('message','<strong>Success!</strong> The listing was created.');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('create::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */


    public function clone($listing) {

        $listing = Listing::find($listing->id);
        if($listing != null && $listing->user_id == auth()->user()->id) {
        $clone_listing = $listing->replicate();
            if($clone_listing->save()) {
                $listing_postages = ListingShippingOption::where('listing_id',$listing->id)->get();		
	        	foreach ($listing_postages as $postage){ 
	        		$clone_postage = new ListingShippingOption();	
	        		$clone_postage->listing_id = $clone_listing->id;	        		
	        		$clone_postage->name = $postage->name;
                    $clone_postage->days = $postage->days;
                    $clone_postage->price = $postage->price;
	        		$clone_postage->save();	        	
                }	
                $clone_listing->title = "Cloned "  .  $listing->title;
                $clone_listing->views_count = 0;
                $clone_listing->created_at = Carbon::now();
                $clone_listing->save();
                return redirect()->route('listing', ['id' => $clone_listing, 'slug' => $clone_listing->title])->with('message','<strong>Success!</strong> The listing was cloned.');
            } else {
                return redirect()->back()->withInput()->with('error','The size of image 1 must to less than or equal to 512Kb');
            }
        }
        abort(404);
    }

    public function edit($listing)
    {
        MetaTag::set('title', "Edit Listing");


        if(auth()->user()->id != $listing->user_id) {
            abort(404);
        }


        $data = [];
        $data['listing'] = $listing;

        $category = new Category();

        $categories = $category->getOptionCategories(0,$listing->category_id);	
        
        $countries = Country::All();

        $data['categories'] = $categories;
        $data['countries'] = $countries;


        $data['own_countries'] = unserialize($listing->ships_to);

        $data['categories'] = $categories;
        $data['countries'] = $countries;


        return view('create.edit', $data);
    }


 

 

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update($listing, Request $request)
    {
        if(auth()->user()->id != $listing->user_id) {
            abort(404);
        }



        $rules = array(
			'title'		=>'required',
			'description'	=>'required',
			'category'		=> 'required',
            'price'			=> 'required|numeric',
			'quantity'			=> 'required|numeric',
            'ships_to'		=> 'required',	
            'shipped_from'		=> 'required',	
            'image_1' => 'mimes:jpg,jpeg,png',				
        );

        if($request->input('escrow') == 4) {
            if(auth()->user()->multisig_key_pub == null || auth()->user()->address_refunds == null ) {
                return redirect()->back()->withInput()->with('error','Please for accepting Multisig to your listing add first a Bitcoin Refund address or Bitcoin Multisig Key. You can do it via <a href="/account/multisig">here</a>');
            }
        }


        $postage_shipping_1 = $request->input('postage_shipping_1');
        if($postage_shipping_1)  {
        	$rules += array(					
				'postage_shipping_1'		=> 'required',
				'postage_option_1'		=> 'required',
				'postage_price_1'		=> 'required|numeric',
	        );
        } 

        for ($i=2; $i <=8 ; $i++) { 
            $postage_shipping =$request->input('postage_shipping_'.$i);
        	$postage_option = $request->input('postage_option_'.$i);
        	$postage_price = $request->input('postage_price_'.$i);
        	if(!empty($postage_shipping) || !empty($postage_option) || !empty($postage_price))
        		$rules += array(					
					'postage_shipping_'.$i		=> 'required',
					'postage_option_'.$i		=> 'required',
					'postage_price_'.$i		=> 'required|numeric'
                );
        }


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {            
            return redirect()->back()->withInput()->withErrors($validator);
        }  

        if ($request->hasFile('image_1')){
        	$size = $request->file('image_1')->getSize();
        	if(($size/1024) > 512) return redirect()->back()->withInput()->with('error','The size of image 1 must to less than or equal to 512Kb');
        }



 //save
 $listing = Listing::find($listing->id);
 if(isset($listing->id)){      
  	
     $listing->title = $request->input('title');
     $listing->description = $request->input('description');
     $listing->tags = $request->input('tags');
     $listing->category_id = $request->input('category');
     $listing->listing_class_id = $request->input('listingclass') == 1 ? 1 : 2;
     $listing->is_published = $request->input('status') == 1 ? 1 : 0;



     if(auth()->user()->has_fe != 1 ) {
         if($request->input('escrow') == 3 || $request->input('escrow') == 2 ) {
             redirect()->back()->with('error','<strong>Error!</strong> The listing was not updated.');
        } else {
           $listing->payment_type_id = $request->input('escrow');
        }
     } 


     $listing->currency = $request->input('currency');
     $listing->price = $request->input('price');

     $listing->quantity = $request->input('quantity');
     $listing->shipped_from = $request->input('shipped_from');
     $listing->ships_to =  serialize($request->input('ships_to'));
     if($listing->save()){
         //save postage 
         $count_postage = 0;  
         $listing_postages = ListingShippingOption::where('listing_id',$listing->id)->get();		
         foreach ($listing_postages as $postage){
             $postage_shipping = $request->input('postage_shipping_id_'.$postage->id);
             $postage_option = $request->input('postage_option_id_'.$postage->id);
             $postage_price = $request->input('postage_price_id_'.$postage->id);
             if(!empty($postage_shipping) && !empty($postage_option) & !empty($postage_price)){
                 $postage = ListingShippingOption::find($postage->id);       		
                 $postage->name = $postage_option;
                 $postage->days = $postage_shipping;
                 $postage->price = $postage_price;
                 $postage->save();
             }
             $count_postage++;
         }	

         for ($i=$count_postage+1; $i <=8 ; $i++) { 
             $postage_shipping = $request->input('postage_shipping_'.$i);
             $postage_option = $request->input('postage_option_'.$i);
             $postage_price = $request->input('postage_price_'.$i);
             if(!empty($postage_shipping) && !empty($postage_option) & !empty($postage_price)){
                 $postage = new ListingShippingOption();
                 $postage->listing_id = $listing->id;
                 $postage->name = $postage_option;
                 $postage->days = $postage_shipping;
                 $postage->price = $postage_price;
                 $postage->save();
             }
         }

        


         //save image
         $destinationPath = public_path().'/uploads/listings_images/';
         if ($request->hasFile('image_1')){
            $file = $request->file('image_1');

            $filename_ = str_random(25);
            $filename = preg_replace("/[^a-zA-Z0-9\.]/", "", strtolower($file->getClientOriginalName()));

            $file_uploaded=$filename_.'_'.$filename;

            $upload_success  = $file->move($destinationPath, $file_uploaded); 
        
            if($listing->photo != null) {
                File::delete(public_path().$listing->photo);
            }

            if( $upload_success ) {
                $listing->photo =  '/uploads/listings_images/'.$file_uploaded;
                $listing->save();                                            
            }
        }
         
         
     }
     return redirect()->back()->with('message','<strong>Success!</strong> The listing was updated. See now your latest update via <a href="/listing/'.$listing->hash.'/'.$listing->title.'">here</a>');
 }else redirect()->back()->withInput()->with('error','<strong>Error!</strong> Listing doesn\'t exist.');   


        return back();
    }


}
