<?php

namespace App\Http\Controllers\Auth;

use App\Events\EmailVerified;
use App\Http\Controllers\Account\ProfileController;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use \FurqanSiddiqui\BIP39\BIP39;
use Illuminate\Http\Request;
use App\Rules\CaptchaCheck;
use MetaTag;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/mnemonic';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function registered(Request $request, $user)
    {
        return redirect('mnemonic');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|string|max:30|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'withdrawpin' => 'required|string|min:6|max:6',
            // 'captcha' => ['required', new CaptchaCheck]
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'withdrawpin' => $data['withdrawpin'],
            'password' => Hash::make($data['password']),
            'support_bitcoin' => 1 ,
            'support_monero' => 1,
            'support_litecoin' => 1,
        ]);
    }

    public function showRegistrationForm()
    {
        MetaTag::set('title', __("Register"));

        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        $mnemonic = BIP39::Generate(12);
        $user->mnemonic= implode(" ", $mnemonic->words);
        $user->verified = 0;
        $user->trader_type = "buyer";
        // $user->save();
        $profile = new ProfileController();
        $profile->GenerateAddresses($user->id);

        $this->guard()->login($user);

        return $this->registered($request, $user);
    }
}
