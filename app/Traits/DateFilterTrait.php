<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 04/08/19
 * Time: 10:08 ص
 */

namespace App\Traits;

use App\Facades\FileFacade;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

trait DateFilterTrait
{

    public function get_date_filter($date_from, $date_to)
    {
        if (!empty($date_from) && !empty($date_to) && $date_from != -1 && $date_to != -1) {
            try {
                $date_from = Carbon::parse($date_from)->format('Y-m-d');
                $date_to = Carbon::parse($date_to)->format('Y-m-d');
            } catch (\Exception $e) {
                $date_from = -1;
                $date_to = -1;
            }
        }else {
            $date_from = -1 ;
            $date_to = -1 ;
        }
        $data = [
            'date_from' => $date_from ,
            'date_to' => $date_to
        ];
        return $data;
    }
}