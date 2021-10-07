<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 10/8/2019
 * Time: 5:39 م
 */

namespace App\Services\ShippingService\SAMSAShipping;

use \Alhoqbani\SmsaWebService\Smsa;
use \Alhoqbani\SmsaWebService\Models\Shipment;
use \Alhoqbani\SmsaWebService\Models\Customer;
use \Alhoqbani\SmsaWebService\Models\Shipper;

use App\Services\ShippingService\AddressShipping;

class SAMSALibrary
{
    use AddressShipping;

    public $smsa;
    public $pass_key;

    public function __construct()
    {
        $this->pass_key = env('SAMSA_PASS_KEY');
        $this->smsa = new Smsa($this->pass_key);
    }


    public function add_shipment($order , $is_order_returned = false)
    {

        $shipping_data = $order->order_user_shipping;
        $total_price = $order->payment_method_id == 1 ? $order->total_price : 0;
        if($is_order_returned) {
            $total_price = 0;
        }
        $this->smsa->shouldUseExceptions = false;
        $get_company_client_data = $this->getCompanyClientData($order , $is_order_returned);
        $customer = $get_company_client_data['customer'];
        $shipper = $get_company_client_data['shipper'];

        $shipment = new Shipment(
            time(), // Refrence number
            $customer, // Customer object
            Shipment::TYPE_DLV // Shipment type.
        );
        $shipment->setCashOnDelivery($total_price);
        $shipment->setShipper($shipper);
        $awb = $this->smsa->createShipment($shipment);
        return [
            'status' => $awb->success,
            'message' => $awb->error,
            'data' => ['shipping_policy' => $awb->data],
        ];


    }

    public function cancel_order($awd)
    {
        $this->smsa->shouldUseExceptions = false;
        $result = $this->smsa->cancel($awd , 'cancel');
       // $result = $result->jsonSerialize();
        return [
            'status' => $result->success,
            'message' => $result->error,
            'data' => $result->data,
        ];
    }

    public function print_awb($order_id, $awb)
    {
        // $awb = 290107607274;
        $result = $this->get_print_data($order_id, $awb);
        if($result['status']) {
            $file_name = "awb_order_id_" . $order_id . ".pdf";
            header('Content-type: application/octet-stream');
            header('Content-disposition: attachment;filename=' . $file_name);
            echo $result['data'];
            die();
        }else {
            return general_response(false, true, "",$result['message'], "", []);
        }

    }
    public function get_print_data($order_id, $awb){
        try {
            $pdf = $this->smsa->awbPDF($awb);
            if(!is_null($pdf->data)) {
                return ['status' => true , 'message' => '', 'data' =>  $pdf->data];
            }else {
                return ['status' => false , 'message' => 'Shipping Number Wrong', 'data' => []];
            }

        } catch (\Alhoqbani\SmsaWebService\Exceptions\RequestError $e) {
            return ['status' => false , 'message' =>$e->getMessage()->smsaResponse , 'data' => [] ];
        }catch (\Error $e) {
            return ['status' => false , 'message' =>$e->getMessage() , 'data' => [] ];
        }

    }


    // help function
    public function getCompanyClientData($order , $is_order_returned = false) {
        $company_address = $this->getCompanyAddress();
        $client_address = $this->getClientAddress($order);

        if($is_order_returned) {
            $customer = new Customer(
                $company_address['name'],
                $company_address['phone'],
                $company_address['place'],
                $company_address['city'],
                $company_address['country_code']
            );
            $customer->setEmail($company_address['email']);

            $shipper = new Shipper(
                $client_address['name'], // shipper name
                $client_address['name'], // contact name
                $client_address['place'], // address line 1
                $client_address['city'], // city
                $client_address['country'], // country
                $client_address['phone'] // phone
            );
            $shipper->setAddressLine2("");
        }else {
            $customer = new Customer(
                $client_address['name'],
                $client_address['phone'],
                $client_address['place'],
                $client_address['city'],
                $client_address['country_code']
            );
            $customer->setEmail($client_address['email']);

            $shipper = new Shipper(
                $company_address['name'], // shipper name
                $company_address['name'], // contact name
                $company_address['place'], // address line 1
                $company_address['city'], // city
                $company_address['country'], // country
                $company_address['phone'] // phone
            );
            $shipper->setAddressLine2("");
        }
        return [
            'customer' => $customer,
            'shipper' => $shipper
        ];
    }
}
