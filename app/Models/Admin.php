<?php

namespace App\Models;

use App\Filters\AdminFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\Pharmacy;
use App\Models\AdminFcm;
use App\Models\Permission;
use App\Models\AdminOrderStatus;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = "admins";
    protected $primaryKey = "admin_id";
    const CREATED_AT = "admin_created_at";
    const UPDATED_AT = "admin_updated_at";
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $filters = ['name' , 'status' , 'role'];

    public function getAdminImageAttribute($value) {
        return add_full_path($value , 'admins');
    }

    public function scopeSearch($query , $value) {
        $query->where('admin_name' , 'LIKE' , "%$value%");
    }

    /*  scopes*/


    public function scopeAdminPharmacy($query) {
        $query->where('admin_role' , '=' , role()['pharmacy_role']);
    }

    /*  relations */


    public function fcms() {
        return $this->hasMany(AdminFcm::class , 'admin_id');
    }
    public function order_statuses() {
        return $this->hasMany(AdminOrderStatus::class , 'admin_id');
    }
    public function notification_admin() {
        return $this->hasMany(NotificationAdmin::class , 'admin_id');
    }




    /*  filters */
    public function scopeFilter($builder ,$filters) {
        return $this->apply_filters($builder ,$filters );
    }
    public function apply_filters($builder ,$get_filters) {
        $filters = [];
        $user_filter = new AdminFilter($builder);

        foreach ($get_filters as $key=>$value) {
            if(in_array($key , $this->filters)) {
                $get_method =  $user_filter->get_filters()[$key];
                $filters[$key] = $user_filter->$get_method($value);
            }
        }
    }


    /*  role  */
    public function is_admin() {
        $admin = auth()->guard('admin')->user();
        if($admin->admin_role == role()['admin_role']) {
            return true;
        }else {
            return false;
        }
    }


    public function permissions() {
        return $this->belongsToMany(Permission::class , 'admin_permissions' , 'admin_id' , 'permission_id');
    }

    public function hasPermissions($permissions) {
        $role_admin_arr = $this->permissions()->pluck('key')->toArray();
        $role_arr = explode('|' , $permissions);
        return count(array_intersect($role_admin_arr , $role_arr)) > 0 ? True : False;
    }

    /************************************************/

}
