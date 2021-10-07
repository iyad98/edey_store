<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\CategoryResourceDFT;
use App\Http\Resources\CategoryDataResourceDFT;
use App\Models\Category;
use App\Models\Setting;
use App\Models\PaymentMethod;
use App\Models\Country;
use App\Models\City;

use Carbon\Carbon;

function check_role($role) {
    $admin = auth()->guard('admin')->user();
    if ($admin->super_admin == 1) return true;
    return $admin->hasPermissions($role);
}
function getImage($folder ,$full_path = true, $default_image = "defullt.png") {
    return $full_path ? ($folder != '' ? env('AWS_ENDPOINT_BUCKET','https://q8store-space.fra1.digitaloceanspaces.com/')."uploads/$folder/$default_image"  : env('AWS_ENDPOINT_BUCKET','https://q8store-space.fra1.digitaloceanspaces.com/')."uploads/$default_image" ) : "$folder/".$default_image ;

//    return $full_path ? ($folder != '' ? url("uploads/$folder/$default_image")  : url("uploads/$default_image") ) : "$folder/".$default_image ;
}


function general_response($status, $auth, $success_msg, $error_msg, $errors, $data)
{
    $data = [
        'status' => $status,
        'auth' => $auth,
        'success_msg' => $success_msg,
        'error_msg' => $error_msg,
        'errors' => $errors,
        'data' => $data,
    ];
    return response()->json($data);
}

function response_api($status, $message, $data, $status_code = 200)
{
    $response['status'] = $status;
    $status_code_ = !$status && $status_code == 200 ? 422 : $status_code;
    $response['code'] = $status_code_;
    $response['message'] = $message;
    if ($status) {
        $response = $response + $data;
    }

    return response()->json($response, $status_code_);

}

function get_error_msg($rules, $errors)
{
    $errorMsg = '';
    foreach ($rules as $key => $msg) {
        if (isset($errors->get($key)[0])) {
            $errorMsg = $errors->get($key)[0];
            break;
        }
    }
    return $errorMsg;
}

function store_image($image, $pathImg)
{

    $ext = $image->getClientOriginalExtension();
    $imgContent = File::get($image);
    $file_name = str_random(40) . time() . "." . $ext;
    $fullPath = public_path() . "/uploads/" . $pathImg . "/" . $file_name;

    $path = $pathImg . $file_name;
    File::put($fullPath, $imgContent);
    return $file_name;
}

function add_full_path($path, $folder)
{
    return url('') . "/uploads/" . $folder . "/" . $path;
}

function add_path_for_excel( $folder , $path)
{
    return  public_path(). "/uploads/" . $folder . "/" . $path;
}

function re_arrange_phone_number($phone , $city_id) {
    $phone = $phone*1;
    $city = City::find($city_id);
    $country = $city ? $city->country : null;
    $country_phone_code = $country ? $country->phone_code : null;
    if($country_phone_code) {
        $phone = $country_phone_code."".$phone;
    }
    return $phone*1;
}
function is_verified_text($is_verified){
    if ($is_verified == 1){
        return trans('website.verified');
    }
    return trans('website.not_verified');

}
function generate_api_token()
{
    return Str::uuid()->toString() . Str::random(200) . Str::random(400) . time() . Str::random(200) . Str::uuid()->toString();
}

function get_tax()
{
    try {
        $tax = Cache::get('cart_data_cache')['tax'];
    }catch (\Exception $e) {
        $tax = 5;
    }catch (\Error $e2) {
        $tax = 5;
    }

    return $tax;
}
function get_shipping()
{
    try {
        $shipping = Cache::get('cart_data_cache')['shipping'];
    }catch (\Exception $e) {
        $shipping = 20;
    }catch (\Error $e2) {
        $shipping = 20;
    }

    return $shipping;

}
function get_cash_value() {
    try {
        $cash = Cache::get('cart_data_cache')['cash'];
    }catch (\Exception $e) {
        $cash = 15;
    }catch (\Error $e2) {
        $cash = 15;
    }

    return $cash;
}
function get_first_order_discount_rate() {
    try {
        $first_order_discount = Cache::get('cart_data_cache')['first_order_discount'];
    }catch (\Exception $e) {
        $first_order_discount = 5;
    }catch (\Error $e2) {
        $first_order_discount = 5;
    }

    return $first_order_discount;
}
function get_package_discount_type() {
    try {
        $package_discount_type = Cache::get('cart_data_cache')['package_discount_type'];
    }catch (\Exception $e) {
        $package_discount_type = 5;
    }catch (\Error $e2) {
        $package_discount_type = 5;
    }
    return $package_discount_type;

}


function gte_payment_note() {
    $payment_note = PaymentMethod::all();
    return $payment_note;
}

function getSubQuerySql($subQuery, $alias = null)
{
    if ($alias == null) {
        $sql = DB::raw("(" . $subQuery->toSql() . ")");
    } else {
        $sql = DB::raw("(" . $subQuery->toSql() . ") as '$alias'");
    }
    return $sql;
}
function get_price_as_sar($column) {
    $sql = DB::raw("(round($column / orders.exchange_rate))");
    return $sql;
}

function get_slug($name) {
    return Str::slug($name);
    $str = strtolower($name);
    $slug = preg_replace('/\s+/', '-', $str);
    return $slug;
}



function has_children($rows,$id) {
    foreach ($rows as $row) {
        if ($row->parent == $id){
            return true;
        }

    }
    return false;
}
function build_menu($all_categories ,$category_name,$rows,$parent=0 , $selected_category=null)
{
    $url = LaravelLocalization::localizeUrl('shop');
    $result = '<ul class="sub-menu">';
    foreach ($rows as $row)
    {
        $slug = get_slug_data_by_lang(get_category_slug_data_from_id($all_categories ,$row->id ));
        $selected_category_class = !is_null($selected_category) && ($selected_category == $slug || $row->id == $selected_category) ? 'current-menu-item current_page_item':'' ;
        if ($row->parent == $parent){
            $result.= "<li class='menu-item $selected_category_class menu-item-type-taxonomy menu-item-object-product_cat menu-item-7270'>
          <a href='{$url}?category={$slug}'>{$row->$category_name}</a>";
            if (has_children($rows,$row->id))
                $result.= build_menu($all_categories ,$category_name,$rows,$row->id);
            $result.= "</li>";
        }
    }
    $result.= "</ul>";

    return $result;
}

function build_menu_new($all_categories ,$category_name,$rows,$parent=0 , $selected_category=null)
{
    $url = LaravelLocalization::localizeUrl('shop');

    $result = '<ul class="dropdown-menu">';
    foreach ($rows as $row)
    {
        $slug = get_slug_data_by_lang(get_category_slug_data_from_id($all_categories ,$row->id ));
        $selected_category_class = !is_null($selected_category) && ($selected_category == $slug || $row->id == $selected_category) ? 'active':'' ;
        if ($row->parent == $parent){
            $result.= "<li class=' $selected_category_class '>
          <a class='dropdown-item' href='{$url}?category={$row->id}'>{$row->$category_name}</a>";
//            if (has_children($rows,$row->id))
//                $result.= build_menu($all_categories ,$category_name,$rows,$row->id);
            $result.= "</li>";
        }
    }
    $result.= "</ul>";

    return $result;
}


function build_mobile_menu($all_categories ,$category_name,$rows,$parent=0)
{
    $url = LaravelLocalization::localizeUrl('shop');
    $result = '<ul class="sub-menu">';
    foreach ($rows as $row)
    {
        $slug = get_slug_data_by_lang(get_category_slug_data_from_id($all_categories ,$row->id ));
        $has_children = has_children($rows,$row->id);
        $sub_menu_class = $has_children ? 'submenu' : '';
        $href = $has_children ? '#' : $url."?category=$slug";

        if ($row->parent == $parent){
            $result.= "<li class='menu-item menu-item-type-taxonomy menu-item-object-product_cat $has_children menu-item-250'>
          <a href='$href'>{$row->$category_name}</a>";
            if (has_children($rows,$row->id))
                $result.= build_mobile_menu($all_categories ,$category_name,$rows,$row->id);
            $result.= "</li>";
        }
    }
    $result.= "</ul>";

    return $result;
}

/***********************************************/
function get_country_code_from_lat_lng($lat , $lng) {
    $google_key = env('GOOGLE_API_KEY');
    $result = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&language=ar&key=$google_key");
    $country_code = null;
    try {
        $get_data = json_decode($result , true);
        $result_0 = $get_data['results'][0];
        $address_components = $result_0['address_components'];
        foreach ($address_components as $address_component) {
            if(in_array("country" , $address_component['types'])) {
                $country_code = $address_component['short_name'];
                break;
            }
        }
    }catch (\Exception $e) {
        $country_code = null;
    }catch (\Error $e) {
        $country_code = null;
    }

    return $country_code;
}

// messages
function get_list_of_banks($banks) {
    $list_banks = "";
    foreach ($banks as $bank) {
        $list_banks .= trans('api.bank_')." : ".$bank->name."<br>";
        $list_banks .= trans('api.account_number')." : ".$bank->account_number."<br>";
        $list_banks .= trans('api.iban')." : ".$bank->iban."<br>";

        $list_banks .= "<br>";
    }
    return $list_banks;
}
function get_list_html_of_banks($banks) {

    $list_banks = "</br>";
    foreach ($banks as $bank) {
        $list_banks .= "<ul>";

        $bank_ = trans('api.bank_')." : ".$bank->name;
        $account_number = trans('api.account_number')." : ".$bank->account_number;
        $iban = trans('api.iban')." : ".$bank->iban;

        $list_banks .= "</br>$bank_</br>";
        $list_banks .= "$account_number</br>";
        $list_banks .= "$iban</br>";

        $list_banks .= "</ul>";
    }
    return $list_banks;
}
function get_list_html_ul_of_banks($banks) {

    $list_banks = "";
    $direction = app()->getLocale() == 'ar' ?  'rtl' : 'ltr';
    foreach ($banks as $bank) {
        $list_banks .= "<ul dir='$direction' >";

        $bank_ = trans('api.bank_')." : ".$bank->name;
        $account_number = trans('api.account_number')." : ".$bank->account_number;
        $iban = trans('api.iban')." : ".$bank->iban;

        $list_banks .= "<li>$bank_</li>";
        $list_banks .= "<li>$account_number</li>";
        $list_banks .= "<li>$iban</li>";
        $list_banks .= "</ul>";
        $list_banks .= "<br>";
    }

    return $list_banks;
}
function get_order_number() {
    $today = time();
    $rand = strtoupper(substr(uniqid(sha1(time())),0,4));
    $unique = Str::uuid()."-".$today . $rand;
    return $unique;
}
function get_confirm_cod() {
    return Str::random(5).time().Str::random(5);
}
function get_remain_replace_time($order) {

    $can_replace = false;
    $remain_replace_hours = $order->package  ? $order->package->replace_hours : 0;
    $default_remain_replace_time = "00 00:00:00";
    if($order->status == order_status()['delivered']) {
        $now_time = Carbon::parse();
        $time_can_replace_order = Carbon::parse($order->finished_at)->addHours($remain_replace_hours);

        if($time_can_replace_order > $now_time) {
            $time_diff = $time_can_replace_order->diff($now_time);
            $remain_replace_time = $time_diff->format("%D %H:%I:%S");
            $can_replace = true;
        }else {
            $remain_replace_time = $default_remain_replace_time;
        }

    }else {
        $remain_replace_time = $default_remain_replace_time;
    }
    return [
        'remain_replace_time' => $remain_replace_time ,
        'can_replace' => $can_replace ,
    ];
}
function get_session_key() {
    return session()->get('_token');
//    return session()->getId();
}

/****************************************************/

function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}

// currencies
function get_default_currency_data() {
    $default_data =  [
        'id' => 60,
        'symbol' => get_currency(),
        'exchange_rate' => 1 ,
    ];
    return $default_data;
}
function get_country_code($request , $user , $website = false) {
    if($website) {
        $country_code = $user && $user->country ? $user->country->iso2 : $request->country_code_session;
    }else {
        $country_code = $user && $user->country ? $user->country->iso2 : $request->country_code;
    }
    if(is_null($country_code)) {
        $country_code =  ip_info($request->ip())['country_code'];
        $country = Country::where('iso2' ,'=' ,$country_code)->first();
        if($user && $country && is_null($user->country)) {
            $user->country_id = $country->id;
            $user->update();
        }
    }
    if(!Country::where('iso2' , '=' , $country_code)->active()->exists()) {
        $country_code = "KW";
        if($user) {
            $user->country_id = 120;
            $user->update();
        }
    }
    return $country_code;
}
function get_currency_data($country_code , $currency_id = null) {
    $default_data = get_default_currency_data();
    return $default_data;
    if(is_null($currency_id)) {
        $country = Country::where('iso2' , '=' , $country_code)->first();
        if($country) {
            $currency_id = $country->currency_id;
        }else {
            $currency_id = null;
        }
    }


    $currency_data =  get_currencies_cache()->where('id' ,$currency_id )->first();
    if($currency_data) {
        $response = [
            'id' => $currency_data->id ,
            'symbol' => app()->getLocale() == 'ar' ? $currency_data->symbol_ar : $currency_data->symbol_en ,
            'exchange_rate' => $currency_data->exchange_rate ,
        ];
    }else {
        $response = $default_data;
    }
    return $response;
}
function convert_currency($price , $currency_data =null) {
    if(isset($currency_data) && !is_null($currency_data)) {
        return round($price*$currency_data['exchange_rate'] , round_digit());
    }else {
        return round($price , round_digit());
    }
}
function reverse_convert_currency($price , $currency_data =null) {
    return "".$price;
    if(isset($currency_data) && !is_null($currency_data)) {
        return $price * $currency_data['exchange_rate'];
    }else {
        return $price;
    }
}
function reverse_convert_currency_2($price , $currency_data =null) {
    if(isset($currency_data) && !is_null($currency_data)) {
        return round($price / $currency_data['exchange_rate'] , round_digit());
    }else {
        return round($price , round_digit());
    }
}

/////////////////////////////////////////////////////
// show title
function show_website_title($title) {
    return isset($title) ? $title . " - ".trans('website.site_name') : trans('website.site_name');
}

/*********  socail media******************************/
function get_social_medial_urls() {

    $social_medial = Setting::whereIn('key' ,['facebook' , 'twitter' , 'youtube' , 'email' ,
        'snapchat' ,'instagram' , 'phone' , 'place','telegram'])->get();
    $facebook= optional($social_medial->where('key' , 'facebook')->first())->value;
    $twitter= optional($social_medial->where('key' , 'twitter')->first())->value;
    $youtube= optional($social_medial->where('key' , 'youtube')->first())->value;
    $email= optional($social_medial->where('key' , 'email')->first())->value;
    $snapchat= optional($social_medial->where('key' , 'snapchat')->first())->value;
    $instagram= optional($social_medial->where('key' , 'instagram')->first())->value;
    $telegram= optional($social_medial->where('key' , 'telegram')->first())->value;

    $phone = optional($social_medial->where('key' , 'phone')->first())->value;
    $place = optional($social_medial->where('key' , 'place')->first())->value;

    return [
        'facebook' => $facebook ,
        'twitter' => $twitter ,
        'youtube' => $youtube ,
        'email' => $email ,
        'snapchat' => $snapchat ,
        'instagram' => $instagram,
        'telegram'=>$telegram,

        'phone' => $phone ,
        'place' => $place

    ];
}



