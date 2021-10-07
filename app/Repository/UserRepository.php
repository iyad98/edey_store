<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 9/8/2019
 * Time: 11:29 م
 */

namespace App\Repository;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

// models
use App\Models\UserShipping;
use App\Models\Package;

use App\Notifications\SendConfirmCodeNotification;
use Illuminate\Support\Facades\Notification;
class UserRepository
{

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function __call($name, $arguments)
    {
        return $this->user->$name(...$arguments);
    }

    public function add_user($get_data)
    {
        $data = array_only($get_data ,$this->user->getFillable() );
        $data['api_token'] = generate_api_token();
        $data['image'] = array_key_exists('image',$data) ? $data['image'] :get_default_image();
        $data['password'] = array_key_exists('password' , $data) ? bcrypt($data['password']) : "";
        $user = $this->user->create($data);
        $user->shipping_info()->create([
            'user_id' => $user->id,
            'is_default' => 1,
            'phone'=>$user->phone,
            'country'=>$user->country_id,
            'email'=>$user->email,
            'code'=>1234,
        ]);
        return $this->user->find($user->id);
    }

    public function update_shipping($user , $get_data) {
        $user_shipping = new UserShipping();
        $data = array_only($get_data ,$user_shipping->getFillable() );
        $user->shipping_info()->update($data);

    }

    public function store_shipping($user , $get_data) {
        $user_shipping = new UserShipping();
        $data = array_only($get_data ,$user_shipping->getFillable() );
       return $user->shipping_info()->create($data);

    }

    public function update_user($obj, $f_name, $l_name, $email, $phone, $password, $path)
    {
        $obj->first_name = $f_name;
        $obj->last_name = $l_name;
        $obj->email = $email;
       // $obj->phone = $phone;
        if (!is_null($password)) {
            $obj->password = bcrypt($password);
        }
        $obj->image = $path;
        $obj->update();

        return $obj;
    }

    public function change_status($obj)
    {

        if ($obj->status == 0) {
            $obj->status = 1;
        } else {
            $obj->status = 0;
        }
        $obj->update();

        return $obj;
    }
    public function delete_user($obj)
    {

        $obj->delete();
        return $obj;
    }
    public function get_users($status = -1)
    {
        $query = $this;
        if ($status != -1) {
            $query = $query->where('status', '=', $status);
        }
        return $query->select('*');


    }


    public function get_default_package() {
        $package = Package::where('price_from' , '=' , 0)->first();
        return optional($package)->id;
    }

    public function send_code( $address){

         $phone = re_arrange_phone_number($address->phone , $address->city);

        $code = $address->code;
        Notification::route('test', 'test')->notify(new SendConfirmCodeNotification($phone ,$code ) );

    }
    
    /*  code user */
    public function get_phone_code( ) {
        return "1234";

    }
    public  function generate_code() {

        $digits = 4;
        return str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
    }

}