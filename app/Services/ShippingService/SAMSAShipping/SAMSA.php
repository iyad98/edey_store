<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 10/8/2019
 * Time: 5:39 م
 */

namespace App\Services\ShippingService\SAMSAShipping;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Twilio\Rest\Client;

// functions
use App\Services\ShippingService\SAMSAShipping\Functions;

class SAMSA
{


    public $url;
    public $functions;
    public function __construct()
    {
        $this->url = "http://track.smsaexpress.com/SeCom/SMSAwebService.asmx";
        $this->functions = new Functions();
    }


    public function send_xml_request( $soap_action , $xml) {
        $headers = array(
            "Content-type: text/xml",
            "Content-length: " . strlen($xml),
            "Connection: close",
          //  "SOAPAction : $soap_action"
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        return $response;
    }



    // services
    public function add_shipment($data = []) {
        $get_data = $this->functions->get_data($data)['add_shipment'];
        return $this->send_xml_request($get_data['soap_action'] ,$get_data['xml']);
    }
}