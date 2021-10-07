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

class AdminOrderStatus extends Model
{

    protected $table = 'admin_order_statuses';
    protected $fillable = ['admin_id', 'key' , 'from' , 'to'];


    public function admin() {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

}
