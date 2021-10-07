<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 10/8/2019
 * Time: 5:39 م
 */

namespace App\Services\MobilyService;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Twilio\Rest\Client;

include  "Results.php";

class Functions
{


    public function __construct()
    {

    }


    public function printStringResult($apiResult, $arrayMsgs, $printType = 'Alpha')
    {
        global $undefinedResult;
        $undefinedResult = "نتيجة العملية غير معرفه، الرجاء المحاول مجددا";


        switch ($printType)
        {
            case 'Alpha':
            {
                if(array_key_exists($apiResult, $arrayMsgs))
                    return $arrayMsgs[$apiResult];
                else
                    return $arrayMsgs[0];
            }
                break;

            case 'Balance':
            {
                if(array_key_exists($apiResult, $arrayMsgs))
                    return $arrayMsgs[$apiResult];
                else
                {
                    list($originalAccount, $currentAccount) = explode("/", $apiResult);
                    if(!empty($originalAccount) && !empty($currentAccount))
                    {
                        return sprintf($arrayMsgs[3], $currentAccount, $originalAccount);
                    }
                    else
                        return $arrayMsgs[0];
                }
            }
                break;

            case 'Senders':
            {
                $apiResult = str_replace('[pending]', '[pending]<br>', $apiResult);
                $apiResult = str_replace('[active]', '<br>[active]<br>', $apiResult);
                $apiResult = str_replace('[notActive]', '<br>[notActive]<br>', $apiResult);
                return $apiResult;
            }
                break;

            case 'Normal':
                if($apiResult{0} != '#')
                    return $arrayMsgs[$apiResult];
                else
                    return $apiResult;
                break;
        }
    }


    public function get_credentials($sms_data) {
        $user_account = $sms_data->where('key' , '=' , 'sms_user_account')->first();
        $user_pass = $sms_data->where('key' , '=' , 'sms_user_pass')->first();
        $sender = $sms_data->where('key' , '=' , 'sms_sender')->first();

        return [
            'user_account' => $user_account ? $user_account->value : '',
            'user_pass' => $user_pass ? $user_pass->value : '',
            'sender' => $sender ? $sender->value : '',

        ];
    }
}