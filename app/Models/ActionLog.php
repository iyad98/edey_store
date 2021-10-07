<?php

namespace App\Models;

use App\Traits\LanguageTrait;
use App\Traits\ActionLogTrait;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Admin;

class ActionLog extends Model
{
    use SoftDeletes , ActionLogTrait;

    protected $table = 'action_logs';
    protected $fillable = ['admin_id','type','model','data' ];

    public $appends = ['description'];

    // relation
    public function admin() {
        return $this->belongsTo(Admin::class , 'admin_id');
    }

    // attribute
    public function getDescriptionAttribute() {
        return $this->getDescription($this);
    }
}
