<?php

namespace App\Models;

use App\Traits\LanguageTrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\MedicineType;
use App\Models\MedicinePeriod;
use App\Models\Day;
use App\Models\GeneralMedicineType;
use App\Models\Admin;

class AdminFcm extends Model
{
    // use SoftDeletes ;

    protected $table = 'admin_fcms';
    protected $fillable = ['admin_id', 'fcm' , 'session_id' , 'last_update_fcm'];


    public function admin() {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

}
