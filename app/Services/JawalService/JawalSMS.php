<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 10/8/2019
 * Time: 5:39 م
 */

namespace App\Services\JawalService;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Twilio\Rest\Client;

// functions
use App\Services\JawalService\Functions;

class JawalSMS
{


    public $functions;

    public $user_account ;
    public $pass_account ;
    public $sender ;

    public function __construct()
    {

        $this->functions = new Functions();
        $credentials = $this->functions->get_credentials(get_setting_messages()['sms']);

        $this->user_account = $credentials['user_account'];
        $this->pass_account = $credentials['user_pass'];
        $this->sender = $credentials['sender'];

    }


    public function send_sms($mobile , $msg) {
//        $Ucode = $this->functions->is_it_unicode($msg);
//        if ($Ucode == 'U') {
//            $msg = $this->functions->to_UTF($msg);
//        }

        // $theName = str_replace(' ', '_', $theName);

        $Ucode = "E";
        $msg = urlencode($msg);
        $GatewayURL = "http://www.jawalsms.net/httpSmsProvider.aspx";
        $url = $GatewayURL . "?username=" . $this->user_account . "&password=" . $this->pass_account . "&mobile=" . $mobile . "&sender=" . $this->sender . "&message=" . $msg . "&unicode=" . $Ucode;
        $result = $this->functions->get_data($url);
        @$result = (integer)str_replace(" ", "", @$result);

        $FainalResult = $result;
        if ($FainalResult == "0") {
            return "Thanks, Your Message has Sent successfully";
        } elseif ($FainalResult == "101") {
            return "Parameter are missing";
        } elseif ($FainalResult == "104") {
            return "Either user name or password are missing or your Account is on hold";
        } elseif ($FainalResult == "105") {
            return "Credit are not available";
        } elseif ($FainalResult == "106") {
            return "Wrong Unicode�";
        } elseif ($FainalResult == "107") {
            return "Blocked Aender Name";
        } elseif ($FainalResult == "108") {
            return "Missing sender name";
        } else {
            return "Error Unknown";
        }
    }
    public function get_balance()
    {
        $GatewayURL = "http://www.jawalsms.net/api/getBalance.aspx";
        $url = $GatewayURL . "?username=" . $this->user_account . "&password=" . $this->pass_account;
        $result = $this->functions->get_data($url);
        return $result;

    }
}