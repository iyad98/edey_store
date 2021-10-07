<?php

namespace App\Services\Payment;

use GuzzleHttp\Client;

class PayTabs
{


    private $merchant_email;
    private $merchant_id;
    private $merchant_secretKey;

    private $pay_page_url;
    private $verify_payment_url;

    public function __construct()
    {

        $this->merchant_email = env('PAYTABS_EMAIL');
        $this->merchant_id = env('PAYTABS_MERCHANT_ID');
        $this->merchant_secretKey = env('PAYTABS_SECRET_KEY');

        $this->pay_page_url = "https://www.paytabs.com/apiv2/create_pay_page";
        $this->verify_payment_url = "https://www.paytabs.com/apiv2/verify_payment";

    }

    public function get_pay_page_data($order_data)
    {

        $ip = $_SERVER['REMOTE_ADDR'];

        $order = $order_data['order'];
        $order_user_shipping = $order_data['order_user_shipping'];
        $city = $order_data['city'];
        $products = $order_data['products'];
        $unit_price = $order_data['unit_price'];
        $quantity = $order_data['quantity'];
        $other_charges = $order_data['other_charges'];

        $fields = array(
            "merchant_email" => $this->merchant_email,
            "secret_key" => $this->merchant_secretKey,
            "site_url" => "www.raqshop.com",
            "return_url" => "http://67.205.147.150/paytabs/complete",
            "title" => $order_user_shipping['first_name']. " ".$order_user_shipping['last_name'],
            "cc_first_name" => $order_user_shipping['first_name'],
            "cc_last_name" => $order_user_shipping['last_name'],
            "cc_phone_number" => "00966",
            "phone_number" => $order_user_shipping['phone'],
            "email" => $order_user_shipping['email'],
            "products_per_title" => "$products",
            "unit_price" => "$unit_price",
            "quantity" => "$quantity",
            "other_charges" => "$other_charges",
            "amount" => $order['total_price'],
            "discount" => "0",
            "currency" => "SAR",
            "reference_no" => $order['order_number'],
            "ip_customer" => "$ip",
            "ip_merchant" => "$ip",
            "billing_address" => $order_user_shipping['address'] ? $order_user_shipping['address'] : "address",
            "city" => $city ,
            "state" => $city,
            "postal_code" => "00966",
            "country" => "SAU",
            "shipping_first_name" => $order_user_shipping['first_name'],
            "shipping_last_name" => $order_user_shipping['last_name'],
            "address_shipping" => $order_user_shipping['address']." ".$city,
            "state_shipping" => $city,
            "city_shipping" => $city,
            "postal_code_shipping" => "1234",
            "country_shipping" => "SAU",
            "msg_lang" => "Arabic",
            "cms_with_version" => "Laravel"
        );
        return $fields;
    }
    public function create_pay_page($order)
    {


        $client = new Client();
        $data = $this->get_pay_page_data($order);
        $res = $client->post($this->pay_page_url, [
            'form_params' => $data
        ]);

        $body = $res->getBody();
        return $this->handle_pay_page_response(json_decode($body , true));
    }
    public function verify_payment($payment_reference) {

        $data = [
            "merchant_email" => $this->merchant_email,
            "secret_key" => $this->merchant_secretKey,
            'payment_reference' => $payment_reference
        ];
        $client = new Client();

        $res = $client->post($this->verify_payment_url, [
            'form_params' => $data
        ]);
        $body = $res->getBody();
        return json_decode($body , true);
    }


    // helper methods
    public function handle_pay_page_response($data) {

        if($data['response_code'] == "4012") {
            $response = [
                'status' => true ,
                'message' => $data['result'],
                'response_code' => $data['response_code'],
                'payment_url' => $data['payment_url'],
                'payment_reference' => $data['p_id']
            ];
        }else if(array_key_exists("result" , $data)) {
            $response = [
                'status' => false ,
                'message' => $data['result'],
                'response_code' => $data['response_code'],
                'payment_url' => "",
                'payment_reference' => -1 ,
            ];
        }else if(array_key_exists("result" , $data)) {
            $response = [
                'status' => false ,
                'message' => $data['response_code'],
                'response_code' => $data['details'],
                'payment_url' => "",
                'payment_reference' => -1 ,
            ];
        }else {
            $response = [
                'status' => false ,
                'result' => "Error",
                'response_code' => $data['response_code'],
                'payment_url' => "",
                'payment_reference' => -1 ,
            ];
        }

        return $response;
    }
}