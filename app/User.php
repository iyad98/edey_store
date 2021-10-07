<?php

namespace App;

use App\Filters\UserFilter;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

use App\Models\NotificationAppUser;

// models
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Neighborhood;
use App\Models\WorkArea;
use App\Models\Ads;
use App\Models\Favorite;
use App\Models\UserShipping;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Package;
use App\Models\WalletLog;

use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\MailResetPasswordToken;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'first_name', 'last_name', 'phone', 'email', 'wallet', 'password', 'image', 'status', 'code', 'platform', 'api_token', 'fcm_token',
        'social_unique_id', 'social_type', 'gender', 'city_id', 'is_guest', 'device_id', 'lang', 'package_id',
        'country_id' , 'notification', 'lat', 'lng'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends =['points_count','points_price'];
    protected $filters = ['name', 'phone', 'status','points_count','points_price'];

    public function getImageAttribute($value)
    {
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        } else {
            return add_full_path($value, 'users');
        }

    }

    public function getPointsCountAttribute($value)
    {
        return  round($this->hasMany(WalletLog::class, 'user_id')->sum('points') ,round_digit());


    }

    public function getPointsPriceAttribute($value)
    {
        return  round( $this->hasMany(WalletLog::class, 'user_id')->sum('pricepoints'),round_digit());

    }


    /*  scopes   */
    public function scopeDateUser($query, $start_at, $end_at)
    {

        $query->where(DB::raw('date(created_at)'), '>=', $start_at)
            ->where(DB::raw('date(created_at)'), '<=', $end_at);
    }

    public function scopeDateRawUser($query, $start_at, $end_at)
    {

        $query->whereRaw("date(created_at) >= '$start_at' ")
            ->whereRaw("date(created_at) <= '$end_at' ");
    }

    public function scopeUserRegistered($query)
    {
        $query->where('is_guest', '=', 0);
    }

    public function scopeSearch($query, $value)
    {
        $query->where('name', 'LIKE', "%$value%");
    }
    public function scopeGetGuest($query , $device_id)
    {
        $query->where('device_id', '=' ,$device_id )->where('is_guest' ,'=' , 1);
    }

    public function scopeUserRate($query)
    {
        $query->withCount(['ads as user_rate' => function ($query) {
            $query->leftJoin('rates', 'rates.ads_id', '=', 'ads.id')
                ->select(DB::raw('round(avg(rates.rate),2)'));
        }]);
    }

   public function country() {
        return $this->belongsTo(Country::class , 'country_id')->withTrashed();
    }
    /*  relations */
    /*  public function country() {
          return $this->belongsTo(Country::class , 'country_id')->withTrashed();
      }
      public function state() {
          return $this->belongsTo(State::class , 'state_id')->withTrashed();
      }
      */

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');

    }

    public function cart()
    {
        return $this->hasOne(Cart::class, 'user_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id')->withTrashed();
    }

    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class, 'neighborhood_id')->withTrashed();
    }

    public function favorites()
    {
        return $this->belongsToMany(Product::class, 'favorites', 'user_id', 'product_id')
            ->select('*', 'favorites.created_at as favorite_date');
    }



    public function notifications()
    {
        return $this->hasMany(NotificationAppUser::class, 'user_id');
    }

    public function shipping_info()
    {

        return $this->hasOne(UserShipping::class, 'user_id')->where('is_default',1);
    }


    public function all_shipping_info()
    {
        return $this->hasMany(UserShipping::class, 'user_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
    public function orders_api_with_phone()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function orders_api()
    {
        return $this->hasMany(Order::class, 'user_id')->whereNotIn('status' ,[6,9,10]);
    }

    public function orders_api_return()
    {
        return $this->hasMany(Order::class, 'user_id')->whereIn('status' ,[6,9,10]);
    }

    public function wallet_log() {
        return $this->hasMany(WalletLog::class, 'user_id');
    }
    /*  filters */
    public function scopeFilter($builder, $filters)
    {
        return $this->apply_filters($builder, $filters);
    }

    public function apply_filters($builder, $get_filters)
    {
        $filters = [];
        $user_filter = new UserFilter($builder);

        foreach ($get_filters as $key => $value) {
            if (in_array($key, $this->filters)) {
                $get_method = $user_filter->get_filters()[$key];
                $filters[$key] = $user_filter->$get_method($value);
            }
        }
    }


    // token
    public function generate_token()
    {
        $this->api_token = Str::random(200) . time() . Str::random(200);
        $this->save();

        return $this->api_token;
    }

    /**
     * Send a password reset email to the user
     */
    public function sendPasswordResetNotification($token)
    {

        $this->notify(new MailResetPasswordToken($token));
    }

}
