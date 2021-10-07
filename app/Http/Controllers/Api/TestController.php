<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

// models
use App\Models\Offer;
use App\Models\NotificationAppUser;

use App\Services\Firebase;
use App\Models\Order;
use DB;
class TestController extends Controller
{

    public function test(Request $request) {

        return $this->get_test(['aa'=> 6555] , 'sas');
    }

    public function get_test(...$a) {
        return $a;
    }
}
