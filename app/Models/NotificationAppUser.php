<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class NotificationAppUser extends Model
{
    use Uuids ;

    protected $table = 'notification_app_users';
    public $incrementing = false;
    protected $fillable = ['user_id' ,'from_user_id','type', 'status', 'data' ,'order_id' ];



}
