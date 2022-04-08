<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Listing;
use MetaTag;

class ListingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        MetaTag::set('title', "Listings");
        MetaTag::set('vendor_id', "2");
        MetaTag::set('id', "2");

        if(auth()->user()->trader_type != "individual" ) {
            abort(404);
        }

		$listings = Listing::where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->paginate(10);
		return view('account.listings', compact('listings'));
    }

    public function removeAll(Request $request) {


        if(auth()->user()->trader_type != "individual" ) {
            abort(404);
        }
        
        if($request->input('ids')) {
            foreach($request->input('ids') as $id){
                    Listing::where('id', $id)->where('user_id', auth()->user()->id)->delete();
                    return redirect()->back()->with('message','The listing(s) has been deleted.');
            }
        }

        return redirect()->back();

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
    public function show($id)
    {
        //
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
        //
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
