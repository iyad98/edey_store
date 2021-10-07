<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class NotificationAdmin extends Model
{
    use Uuids ;

    protected $table = 'notification_admins';
    public $incrementing = false;
    protected $fillable = ['admin_id' ,'type', 'data' ,'order_id'];



}
