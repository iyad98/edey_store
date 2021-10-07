<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use phpDocumentor\Reflection\Types\Self_;

use Auth;
use  App\Traits\FileTrait;
use App\Traits\ActionLogTrait;

class HomeController extends Controller
{
    use FileTrait , ActionLogTrait;

    public static $data = [];
    public function __construct()
    {
        self::$data['active_menu'] = '';
        self::$data['active_sub_menu'] = '';


    }
}
