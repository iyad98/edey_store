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

// functions
use App\Services\MobilyService\Functions;
use App\Services\MobilyService\Results;

class MobilySMS
{


    public $functions;
    public $results;

    public $user_account ;
    public $pass_account ;
    public $sender ;

    public function __construct()
    {

        $this->functions = new Functions();
        $this->results = new Results();
        $credentials = $this->functions->get_credentials(get_setting_messages()['sms']);


        $this->user_account = $credentials['user_account'];
        $this->pass_account = $credentials['user_pass'];
        $this->sender = $credentials['sender'];

    }


    public function send_sms( $numbers, $msg , $viewResult = 1)
    {
        /*************** public data************************/
        $userAccount = $this->user_account;
        $passAccount = $this->pass_account;
        $sender = $this->sender;
        /**************************************/

        $arraySendMsg = $this->results->result_send_sms();;

        $url = "https://api-server3.com/api/send.aspx?";
        $applicationType = "68";
        $sender = urlencode($sender);

        //        $domainName = "127.0.0.1";

        $stringToPost =
            "username=" . $userAccount .
            "&password=" . $passAccount .
            "&sender=" . $sender .
            "&mobile=" . $numbers .
            "&message=" . $msg .
            "&language=2";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $stringToPost);
        $result = curl_exec($ch);


        if ($viewResult)
            $result = $this->functions->printStringResult(trim($result), $arraySendMsg);
        return $result;

    }
    public function balance_sms($viewResult = 1) {

        /*************** public data************************/
        $userAccount = $this->user_account;
        $passAccount = $this->pass_account;
        $sender = $this->sender;
        /**************************************/
        $arrayBalance = $this->results->result_balance_sms();;

        $url = "https://api-server3.com/api/balance.aspx?";
        $stringToPost = "username=".$userAccount."&password=".$passAccount;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $stringToPost);
        $result = curl_exec($ch);


        return $result;
    }
}