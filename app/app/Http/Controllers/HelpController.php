<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\NewsCategory;
use Validator;

use MetaTag;

class HelpController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }


    public function index()
    {
        $categories = NewsCategory::All();
        $news = News::orderBy('created_at','ASC')->paginate(10);

        $data = [];
        $data['categories'] = $categories;
        $data['news'] = $news;

        MetaTag::set('title', "Help");

        return view('page',$data);
    }

    public function help($id) {

        $categories = NewsCategory::All();
        $news = News::orderBy('created_at','ASC')->paginate(10);
        $single_news = News::findOrFail($id);

        $data = [];
        $data['categories'] = $categories;
        $data['news'] = $news;
        $data['single_news'] = $single_news;

        MetaTag::set('title', $single_news->title);

        return view('help',$data);
    }

    public function search(Request $request) {
        $params = $request->all();
        $validator = Validator::make($request->all(), [
            'searchtext' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }




        $data = [];
        $news = News::whereLike('title', $request->input('searchtext'))->orWhereLike('body', $request->input('searchtext'))->get();
        $categories = NewsCategory::All();

        $data['categories'] = $categories;
        $data['news'] = $news;
        MetaTag::set('title', "Help");


        return view('page',$data);
    }

    public function voteDown($id) {
        $single_news = News::findOrFail($id);
        $single_news->vote_down = $single_news->vote_down + 1;
        $single_news->save();
        return redirect()->back();
    }

    public function voteUp($id) {
        $single_news = News::findOrFail($id);
        $single_news->vote_up = $single_news->vote_up + 1;
        $single_news->save();

        return redirect()->back();
    }


}
