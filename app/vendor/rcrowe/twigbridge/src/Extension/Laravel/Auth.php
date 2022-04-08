<?php

/**
 * This file is part of the TwigBridge package.
 *
 * @copyright Robert Crowe <hello@vivalacrowe.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TwigBridge\Extension\Laravel;

use Twig_Extension;
use Twig_SimpleFunction;
use Illuminate\Auth\AuthManager;
use App\Models\CurrencyRates;
/**
 * Access Laravels auth class in your Twig templates.
 */
class Auth extends Twig_Extension
{
    /**
     * @var \Illuminate\Auth\AuthManager
     */
    protected $auth;

    // rates

    protected $btc_rates;
    protected $ltc_rates;
    protected $xmr_rates;
    protected $exchange_rates;
    /**
     * Create a new auth extension.
     *
     * @param \Illuminate\Auth\AuthManager
     */
    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
        $rates = new CurrencyRates();
        $this->btc_rates = $rates->where("currency_id",1)->first();
        $this->ltc_rates = $rates->where("currency_id",2)->first();
        $this->xmr_rates = $rates->where("currency_id",3)->first();
        if(isset($this->auth->user()->currency)){
            // $this->exchange_rates = json_decode(file_get_contents("https://api.exchangeratesapi.io/latest?access_key=5a0b94c1fe245e126a2ea85d0f42cb39&base=".strtoupper($this->GetCurrency())));
            $this->exchange_rates = json_decode(file_get_contents("http://api.exchangeratesapi.io/latest?access_key=5a0b94c1fe245e126a2ea85d0f42cb39"));
            $this->exchange_rates = (array) $this->exchange_rates->rates;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'TwigBridge_Extension_Laravel_Auth';
    }

    // Currencies

    public function GetBTCPrice($amount,$currency = "usd" ,$listing = "no"){
            $currency = strtolower($currency);
            if($listing == "no"){
                $price = $this->btc_rates->$currency * $amount;
                return number_format($price,2);
            }else{
                $price = $amount / $this->btc_rates->$currency;
                return number_format($price,5);
            }

    }

    public function GetLTCPrice($amount,$currency = "usd" ,$listing = "no"){
            $currency = strtolower($currency);
            if($listing == "no"){
                $price = $this->ltc_rates->$currency * $amount;
                return number_format($price,2);
            }else{
                $price = $amount / $this->ltc_rates->$currency;
                return number_format($price,5);
            }

    }

    public function GetXMRPrice($amount,$currency = "usd" ,$listing = "no"){
            $currency = strtolower($currency);
            if($listing == "no"){
                $price = $this->xmr_rates->$currency * $amount;
                return number_format($price,2);
            }else{
                $price = $amount / $this->xmr_rates->$currency;
                return number_format($price,5);
            }

    }

    public function ToUserCurrency($amount,$currency){
            $currency=strtoupper($currency);
            if($currency != strtoupper($this->GetCurrency())){
            $rate = $this->exchange_rates[$currency];
            $value = $amount / $rate;
            return number_format($value,2);
            }else{
                return number_format($amount,2);
            }
    }

    public function GetCurrency(){
        $currency="USD";
        if(session()->has("exchange")){
            $currency = session()->get("exchange");
        }elseif ($this->auth->user()){
            $currency = $this->auth->user()->currency;
        }
        return $currency;
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('auth_check', [$this->auth, 'check']),
            new Twig_SimpleFunction('auth_guest', [$this->auth, 'guest']),
            new Twig_SimpleFunction('auth_user', [$this->auth, 'user']),
            new Twig_SimpleFunction('auth_guard', [$this->auth, 'guard']),
            new Twig_SimpleFunction('GetBTCPrice', [$this, 'GetBTCPrice']),
            new Twig_SimpleFunction('GetLTCPrice', [$this, 'GetLTCPrice']),
            new Twig_SimpleFunction('GetXMRPrice', [$this, 'GetXMRPrice']),
            new Twig_SimpleFunction('ToUserCurrency', [$this, 'ToUserCurrency']),
            new Twig_SimpleFunction('GetCurrency', [$this, 'GetCurrency']),
        ];
    }
}
