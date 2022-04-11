<?php

namespace App\Http\Controllers\Admin;

use App\Models\PaymentProvider;
use App\Models\ServerCredentials;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Models\Listing;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Kris\LaravelFormBuilder\FormBuilder;
use Modules\Panel\Forms\PaymentForm;
use Crypt;
use Setting;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index(Request $request)
    {
	#dd(config('marketplace.stripe_secret_key'));
        /*$default_providers = collect(json_decode(file_get_contents(resource_path('data/payment-providers.json'))));
		
        foreach($default_providers as $default_provider) {
            #dd(collect($default_provider)->toArray());
            $payment_provider = PaymentProvider::where('key', $default_provider->key)->first();
            if(!$payment_provider) {
                PaymentProvider::create(collect($default_provider)->toArray());
            }
        }*/

        $payment_providers = ServerCredentials::get();
		$enabled_provider_count = $payment_providers->filter(function ($value, $key) {
			return $value->is_enabled;
		})->count();
		
//		Setting::set('payments_enabled', ($enabled_provider_count > 0));
//		Setting::save();
		
        $data['payment_providers'] = $payment_providers;
        return view('panel::payment_providers.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create('Modules\Panel\Forms\PaymentForm', [
            'method' => 'POST',
            'url' => route('panel.payments.store')
        ]);
        #dd($form);

        return view('panel::payment_providers.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        $payment_provider = new PaymentProvider();
        $payment_provider->name = $request->input('name');
        $payment_provider->key = $request->input('key');
        $payment_provider->display_name = $request->input('display_name');
        $payment_provider->description = $request->input('description');
        $payment_provider->payment_instructions = $request->input('payment_instructions');
        $payment_provider->is_enabled = $request->has('is_enabled');
        $payment_provider->position = $request->input('position');
        $payment_provider->icon = $request->input('icon');
        $payment_provider->is_offline = $request->input('key') == 'offline';
        $payment_provider->save();


        return redirect()->route('panel.payments.index');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $data = [];
        $data['payment_provider'] = PaymentProvider::find($id);
        return view('panel::payment_providers.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id, FormBuilder $formBuilder)
    {
		$payment_provider = ServerCredentials::find($id);
		
		$data = [];
		$data['payment_provider'] = $payment_provider;
		$data['form'] = $formBuilder->create(\Modules\Panel\Forms\PaymentForm::class, [
			'method' => 'PUT',
			'url' => route('panel.payments.update', $payment_provider),
			'model' => $payment_provider
		]);			
		return view('panel::payment_providers.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $payment_provider = ServerCredentials::find($id);

		$payment_provider->username = $request->input('username');
		$payment_provider->password = $request->input('password');
        $payment_provider->host = $request->input('host');
        $payment_provider->port = $request->input('port');
        $payment_provider->save();

        return redirect()->route('panel.payments.index');
    }

    public function changeStatus($id){
        $record = ServerCredentials::find($id);
        $updateStatus = 0;
        if($record->is_enabled){
            $updateStatus = 0;
        }
        else {
            $updateStatus = 1;
        }
        ServerCredentials::find($id)->update(['is_enabled'=>$updateStatus]);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($listing)
    {
        $listing->delete();
        return redirect()->route('panel.listings.index');
    }
}
