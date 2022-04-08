<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\PGP_2FA;
use Illuminate\Http\Request;
use App\Models\Securimage;
use App\Models\Securimage_Color;
use App\Rules\CaptchaCheck;
use Illuminate\Support\Str;
use MetaTag;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['guest'])->except('logout','mnemonicPage','mnemonicPost','captcha');
    }


    public function validateLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
            // 'captcha' => ['required', new CaptchaCheck]
        ]); 
    }

    
    /**
     * Overrides method of username @Auth
     *a
     *
     */
    public function username()
    {
        return 'username';
    }

    protected function redirectTo()
    {
        return $this->redirectTo;
    }

    public function pGP2FACheckP() {  

        MetaTag::set('title', __("Two Factor Authentication"));


        if(auth()->user() != null || session()->get('pgp-secret-hash') == null ) {
            return redirect()->route('browse');
        }


        return view('auth.2fa');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->forget(['from']);
        $request->session()->invalidate();

        return back();
    }

    public function showLoginForm(Request $request)
    {
        MetaTag::set('title', __("Login"));
        if(!session()->has('from')){
            session()->put('from', url()->previous());
        }

        return view('auth.login');
    }

    public function mnemonicPage()
    {
        MetaTag::set('title', __("Verify your Mnemonic"));

        if(auth()->user() != null) {
            if(auth()->user()->verified == 0) {
            return view('auth.mnemonic');
            }
        }
     return redirect()->route('browse');
    }

    public function mnemonicPost(Request $request)
    {
        MetaTag::set('title', __("Verify your Mnemonic"));
        if(auth()->user() != null) {
            if(auth()->user()->verified == 0) {
              $user =  User::Find(auth()->user()->id);
                if(($user->mnemonic == $request->input('mnemonic')) && ($user->withdrawpin == $request->input('withdrawpin')) ) {
                    $user->verified = 1;
                    $user->save();
                    return redirect()->route('browse');
                } else {
                   return back()->withErrors(['field_name' => ['Your custom message here.']]);
                  }

            }
        }
     return redirect()->route('browse');
    }
    


    public function authenticated($request, $user)
    {
        if($user->username === 'admin'){
            $user->assignRole('admin');
        }

        if($user->username === 'adam'){
            $user->assignRole('moderator');
        }
    
        if (auth()->user()->otp == 1) {
            return self::startTwoFactorAuthProcess($request, $user);
        }
    
        $redirect_to = session()->pull('from', $this->redirectTo);

        return redirect($redirect_to);
    }

    public function PGPauthenticated($request, $user)
    {
        $redirect_to = session()->pull('from', $this->redirectTo);

        return redirect($redirect_to);
    }

    private function startTwoFactorAuthProcess(Request $request, $user)
    {
        // Logout user, but remember user id
        auth()->logout();
        $request->session()->put(
            'userid', array_merge(['id' => $user->id])
        );

        $pgp_message = $this->generate2FACode($user->pgp_key);

        session()->put('suckmynuts', $pgp_message);

        return redirect()->route('2fa_factor');
    
    }

    public function generate2FACode($pgp_key) {

        $pgp_2fa = new PGP_2FA();

      $pgp_2fa->generateSecret();  
      $message = $pgp_2fa->encryptSecret($pgp_key);
     
        return $message;
    }

    public function verifyTwoFactorAuth(Request $request) {
        $user = User::findOrFail($request->session()->get('userid')['id']);

        $pgp_2fa = new PGP_2FA();

        if($pgp_2fa->compare($request->input('code'),$request->session()->get('pgp-secret-hash'))) {

            $request->session()->regenerate();
            $request->session()->forget('suckmynuts');
            $request->session()->forget('pgp-secret-hash');
            $request->session()->forget('userid');

            auth()->login($user); 

            return $this->PGPauthenticated($request, $user);
        } else {
            return back()->withErrors(['field_name' => ['Invalid code']]);
        }
    }


    public function captcha() {
        $captcha = new Securimage();

        $captcha->image_signature = "http://".env('APP_URL');
        $captcha->image_height = "100";
        $captcha->image_width = "350";
        $captcha->image_bg_color = new Securimage_Color('#F9F9F9');
        $captcha->text_color = new Securimage_Color("#2D3C4D");
        $captcha->line_color = new Securimage_Color("#707070");
        $captcha->noise_color = new Securimage_Color("red");
        $captcha->num_lines=0;
        $captcha->use_random_boxes = true;
        
        $captcha->show();

        return view('auth.captcha', $captcha);
    }

}