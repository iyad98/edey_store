<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 10/8/2019
 * Time: 5:39 م
 */

namespace App\Services\ShippingService\SAMSAShipping;


class Functions
{

    public function __construct()
    {

    }

    public function get_data($data) {
        return [
            'add_shipment' => [
                'soap_action' => 'addShipment',
                'xml' => $this->add_shipment($data),
            ],

        ];
    }

    public function add_shipment($data) {

        $xml = '<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <addShipment xmlns="http://track.smsaexpress.com/secom/">
      <passKey>Testing0</passKey>
      <refNo>277108589099525</refNo>
      <idNo>1234567890</idNo>
      <cName>Syed Amer</cName>
      <cntry>saudi arabia</cntry>
      <cCity>riyadh</cCity>
      <cZip>966</cZip>
      <cMobile>972598149450</cMobile>
      <cAddr1>Test</cAddr1>
      <cAddr2>Test</cAddr2>
      <shipType>DLV</shipType>
      <cEmail>mohamg1995@gmail.com</cEmail>
      <weight>1</weight>
      <custVal>0</custVal>
      <custCurr>SAR</custCurr>
      <itemDesc>Docs</itemDesc>
    </addShipment>
  </soap:Body>
</soap:Envelope>';

        return $xml;
    }
}