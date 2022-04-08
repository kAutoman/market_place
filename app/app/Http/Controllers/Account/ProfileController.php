<?php

namespace App\Http\Controllers\Account;

use App\Bitcoin\Bitcoin;
use App\Litecoin\Litecoin;
use App\Models\UserAddresses;
use App\Monero\Monero;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PGP_2FA;
use MetaTag;
use Validator;
use App\Models\ServerCredentials;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        MetaTag::set('title', "Account");
        MetaTag::set('id', "1");

		return view('account.profile');
    }


    public function feedbacks()
    {
        if(auth()->user()->trader_type != "individual") {
            abort(404);
        }
        
        MetaTag::set('title', "Feedbacks");
        MetaTag::set('vendor_id', 3);
        MetaTag::set('id', "2");
    
		return view('account.feedbacks');
    }

    public function edit() {
        MetaTag::set('id', "1");
        MetaTag::set('normal_id', "2");
        MetaTag::set('title', "Edit profile");


        return view('account.edit_profile');
    }

    public function pgp_key() {
        MetaTag::set('id', "1");
        MetaTag::set('title', "Edit PGP");
        MetaTag::set('normal_id', "3");

        return view('account.edit_pgp');
    }

   


    public function generate2FACode($pgp_key) {

        $pgp_2fa = new PGP_2FA();

      $pgp_2fa->generateSecret();  
      $message = $pgp_2fa->encryptSecret($pgp_key);
     
        return $message;
    }


    public function pgpUpdate(Request $request) {

        if(!$request->input('pgp_key')) {
            return redirect()->back()->with('error','Invalid PGP Key');
        }
        
         $pgp_message = $this->generate2FACode($request->input('pgp_key'));


        session()->put('suckmynuts', $pgp_message);
        session()->put('pgp_key', $request->input('pgp_key'));


        return redirect('/account/verify_pgp');
    }


    public function pgpVerifyPage() {
        MetaTag::set('id', "1");
        MetaTag::set('title', "Edit PGP");
        MetaTag::set('normal_id', "3");

        if(session()->get('pgp-secret-hash') == null ) {
            return redirect('/account/change_pgp');
        }

        return view('account.verify_pgp');
    }


    public function verifyPGP(Request $request) {
        $user = User::findOrFail(auth()->user()->id);

        $pgp_2fa = new PGP_2FA();

        if($pgp_2fa->compare($request->input('code'),$request->session()->get('pgp-secret-hash'))) {

            $user->pgp_key = $request->session()->get('pgp_key');
            $user->save();

            $request->session()->forget('suckmynuts');
            $request->session()->forget('pgp-secret-hash');
            $request->session()->forget('pgp_key');

           return redirect('/account/change_pgp')->with('message','The PGP Key has succesfull been updated.');
        } else {
            return back()->withErrors(['field_name' => ['Invalid code']]);
        }
    }


    public function multisig() {

        MetaTag::set('id', "1");
        MetaTag::set('normal_id', "4");
        MetaTag::set('title', "Bitcoin Multisig");


        return view('account.multisig');
    }

    public function multisigUpdate(Request $request) {
        $validator = Validator::make($request->all(), [
            'btcmultisig' => 'required',
            'btcrefund' => 'required',
            'btcsales' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $user = User::find(auth()->user()->id);

        if(strlen($request->input('btcmultisig')) != 32 && $request->input('btcmultisig') == ""){
            return redirect()->back()->with('error','Invalid public key.');
        }

        if(strlen($request->input("btcrefund")) < 25 || strlen($request->input("btcrefund")) > 35 &&  $request->input('btcrefund') == ""){
            return redirect()->back()->with('error','Invalid BTC address.');
        }

        if(strlen($request->input("btcsales")) < 25 || strlen($request->input("btcsales")) > 35 &&  $request->input('btcsales') == ""){
            return redirect()->back()->with('error','Invalid BTC address.');
        }

        $user->multisig_key_pub = $request->input('btcmultisig');
        $user->address_refunds = $request->input('btcrefund');
        $user->address_sales = $request->input('btcsales');
        $user->save();

        return redirect()->back()->with('message','The store has succesfull been updated.');
    }


    public function GenerateAddresses($id){

      return  $btc_credentials = ServerCredentials::where("currency",1)->first();
        $bitcoin = new Bitcoin($btc_credentials->username,$btc_credentials->password,$btc_credentials->host,$btc_credentials->port);
        $ltc_credentials = ServerCredentials::where("currency",2)->first();
        $litetcoin = new Litecoin($ltc_credentials->username,$ltc_credentials->password,$ltc_credentials->host,$ltc_credentials->port);
        $xmr_credentials = ServerCredentials::where("currency",3)->first();
        $monero = new Monero($xmr_credentials->username,$xmr_credentials->password,$xmr_credentials->host,$xmr_credentials->port);

        $btc_address = $bitcoin->getnewaddress();
        $ltc_address = $litetcoin->getnewaddress();
        $xmr_address = $monero->create_address();
     return   $values = ["user_id" => $id,"btc_address"=>$btc_address->result,"ltc_address"=>$ltc_address->result,"xmr_address"=>$xmr_address->result['address']];
        print_r($values);
        UserAddresses::updateOrCreate(["user_id"=>$id],$values);

    }

    public function GetUserAddresses($id){

        $user_addresses = UserAddresses::where("user_id",$id)->first();

        return $user_addresses;
    }

    public function vendor_settings() {
        if(auth()->user()->trader_type != "individual") {
            abort(404);
        }

        MetaTag::set('title', "Vendor Settings");
        MetaTag::set('vendor_id', "1");
        MetaTag::set('id', "2");

        return view('account.vendor_settings');
    }
    
    public function updateStore(Request $request) {
        if(auth()->user()->trader_type != "individual") {
            abort(404);
        }

        $user = User::Find(auth()->user()->id);
        if($request->input('terms')) {
            $user->terms_conditions = $request->input('terms');
        }
        

        switch($request->input('holiday')) {
            case 0:
            foreach($user->listings as $listing) {
                $listing->is_published = 1;
                $listing->save();
            }
            $user->on_vacation =0;
            break;
            case 1:
                foreach($user->listings as $listing) {
                    $listing->is_published = 0;
                    $listing->save();

                }
            $user->on_vacation=1;
            break;
        }

        $user->support_bitcoin = $request->input('bitcoin') == 1 ? 1 : 0;
        $user->support_monero = $request->input('monero') == 1 ? 1 : 0;
        $user->support_litecoin = $request->input('litecoin') == 1 ? 1 : 0;
 
        $user->save();


        return redirect()->back()->with('message','The store has succesfull been updated.');
    }


    public function storeProfile(Request $request)
    {
        $user = User::Find(auth()->user()->id);

        if ($request->hasFile('avatar_img')){
        	$size = $request->file('avatar_img')->getSize();
        	if(($size/1024) > 512) return redirect()->back()->withInput()->with('error','The size of image 1 must to less than or equal to 512Kb');
        }

        if ($request->hasFile('avatar_background_img')){
        	$size = $request->file('avatar_background_img')->getSize();
        	if(($size/1024) > 912) return redirect()->back()->withInput()->with('error','The size of image 1 must to less than or equal to 512Kb');
        }

        $avatar_img = public_path().'/uploads/avatar_heads/';

        if ($request->hasFile('avatar_img')){
           $file = $request->file('avatar_img');

           $filename_ = str_random(25);
           $filename = preg_replace("/[^a-zA-Z0-9\.]/", "", strtolower($file->getClientOriginalName()));

           $file_uploaded=$filename_.'_'.$filename;

           $upload_success  = $file->move($avatar_img, $file_uploaded); 
       
           if( $upload_success ) {
               $user->avatar =  '/uploads/avatar_heads/'.$file_uploaded;
           }
       }

       $avatar_bg = public_path().'/uploads/avatar_backgrounds/';
       if ($request->hasFile('avatar_background_img')){
        $file = $request->file('avatar_background_img');

        $filename_ = str_random(25);
        $filename = preg_replace("/[^a-zA-Z0-9\.]/", "", strtolower($file->getClientOriginalName()));

        $file_uploaded=$filename_.'_'.$filename;

        $upload_success  = $file->move($avatar_bg, $file_uploaded); 
    
        if( $upload_success ) {
            $user->avatar_background =  '/uploads/avatar_backgrounds/'.$file_uploaded;
        }
     }

       $user->bio = $request->input('bio');

       $user->save();                                            
		
        return redirect()->back()->with('message','Successfully saved!');
    }


    public function applyVendor() {
        MetaTag::set('title', "Apply for Vendor");

        return view('account.vendor');
    }

    public function payVendor(Request $request) {
        MetaTag::set('title', "Apply for Vendor");

        $validator = Validator::make($request->all(), [
            'terms' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $user = auth()->user();
       
        // if(auth()->user()->pgp_key == null) {
        //     return redirect()->back()->with('error','Please add a PGP key to your profile via <a href="/account/change_pgp">here</a>.');
        // }

        if($request->input('paybtc')) {
            if(auth()->user()->btcBalance(10)) {
                $user->trader_type= "individual";
                $user->save();
                return redirect('/account/vendor_settings')->with('message','You are succesfull vendor.');
                } else {
                return redirect()->back()->with('error','You don\'t have enough Bitcoin balance. Please deposit first');
                }
        }

        if($request->input('payltc')) {
            if(auth()->user()->ltcBalance(10)) {
                $user->trader_type= "individual";
                $user->save();
                return redirect('/account/vendor_settings')->with('message','You are succesfull vendor.');
                } else {
                return redirect()->back()->with('error','You don\'t have enough Litecoin balance. Please deposit first');
                }
        }

        if($request->input('payxmr')) {
            if(auth()->user()->xmrBalance(10)) {
                $user->trader_type= "individual";
                $user->save();
                return redirect('/account/vendor_settings')->with('message','You are succesfull vendor.');
                } else {
                return redirect()->back()->with('error','You don\'t have enough Monero balance. Please deposit first');
                }
        }

        return view('account.vendor');
    }


}
