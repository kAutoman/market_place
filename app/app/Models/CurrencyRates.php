<?php
/**
 * Created by PhpStorm.
 * User: faree
 * Date: 1/28/2020
 * Time: 3:17 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CurrencyRates extends Model
{

    protected $table = 'currency_rates';
    protected $fillable = ['currency_id', 'usd', 'eur', 'gbp', 'cad', 'aud', 'brl', 'dkk', 'nok', 'sek', 'try', 'cny', 'hkd', 'rub', 'inr', 'jpy'];

}