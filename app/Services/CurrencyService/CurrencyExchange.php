<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 9/8/2019
 * Time: 11:36 م
 */

namespace App\Services\CurrencyService;


use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
// models
use App\Models\Currency;

class CurrencyExchange
{

    public $url ;
    public $key;

    public function __construct()
    {
        $this->url = env('FIXER_URL');
        $this->key = env('FIXER_KEY');
    }

    public function update_currency_exchange() {
        $url = $this->url."?access_key=".$this->key."&base=SAR";
        $client =  new \GuzzleHttp\Client();
        $res = $client->get($url);
        $body = json_decode($res->getBody());
        $rates = $body->rates;
        $arr = [];
        foreach ($rates as $key=>$rate) {
            Currency::where('code' , '=' , $key)->update([
                'exchange_rate' => $rate
            ]);
        }
        update_currencies_cache();
       // return $arr;

    }

    public function get_currency_exchange() {
        $url = $this->url."?access_key=".$this->key."&base=SAR";
        $client =  new \GuzzleHttp\Client();
        $res = $client->get($url);
        $body = json_decode($res->getBody());
        return response()->json($body);
    }

}