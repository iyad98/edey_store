<?php

namespace App\Services\Payment;

use GuzzleHttp\Client;
use function GuzzleHttp\Psr7\str;

class Myfatoorah
{


    private $token;
    private $verify_payment_url;
    private $execute_payment;

    public function __construct()
    {

        $this->token = env('MyFatoorahToken');
        $this->execute_payment = "https://api.myfatoorah.com/v2/ExecutePayment";
        $this->verify_payment_url = "https://api.myfatoorah.com/v2/GetPaymentStatus";
        $this->refund_payment = "https://api.myfatoorah.com/v2/MakeRefund";

    }

    public function get_pay_page_data($order_data , $payment_method_id)
    {

        $order = $order_data['order'];


        $order_user_shipping = $order_data['order_user_shipping'];

        $city = $order_data['city'];
        $products = $order_data['products'];
        $unit_price = $order_data['unit_price'];
        $quantity = $order_data['quantity'];
        $other_charges = $order_data['other_charges'];

        $fields = array (
            'PaymentMethodId' => $payment_method_id,
            'CustomerName' => $order_user_shipping['first_name']." ".$order_user_shipping['last_name'],
            'DisplayCurrencyIso' => 'KWD',
            'MobileCountryCode' => '965',
            'CustomerMobile' => $order_user_shipping['phone'],
            'CustomerEmail' => $order_user_shipping['email'],
            'InvoiceValue' => $order['total_price'],
            'CallBackUrl' => 'https://www.q8store.co/my_fatoorah/complete',
            'ErrorUrl' => 'https://www.q8store.co/my_fatoorah/complete',
            'Language' => 'ar',
            'CustomerReference' => $order_user_shipping['first_name']." ".$order_user_shipping['last_name'] . " Order ID : ",
            'CustomerCivilId' => '123',
            'UserDefinedField' => $order['order_number'] ,
            'CustomerAddress' =>
                array (
                    'Block' => '',
                    'Street' => $order_user_shipping['street'],
                    'HouseBuildingNo' =>  $order_user_shipping['building_number'],
                    'Address' => $order_user_shipping['address'],
                    'AddressInstructions' => '',
                ),
            'ExpiryDate' => '2021-12-24T06:38:49.874Z',
            'SupplierCode' => 0,
            'SupplierValue' => 0,
            'ShippingConsignee' =>
                array (
                    'PersonName' => 'anas',
                    'Mobile' => '0594255556',
                    'EmailAddress' => 'anas.mahjub@gmail.com',
                    'LineAddress' => 'ABBASIYA alral',
                    'CityName' => 'ABBASIYA',
                    'PostalCode' => 'string',
                    'CountryCode' => 'KW',
                ),
            'SourceInfo' => '3',
        );

        return $fields;
    }
    public function get_direct_pay_page_data($request){
        $fields =   array (
            'paymentType' => 'card',
            'card' =>
                array (
                    'CardHolderName' => $request->card_name,
                    'Number' =>  $request->card_number,
                    'expiryMonth' => $request->card_month,
                    'expiryYear' => $request->card_year,
                    'securityCode' => $request->card_cvv,
                ),
            'saveToken' => false,
        );

        return $fields;
    }

    public function create_myfatoorah_page($order , $payment_method_id )
    {

        $client = new Client();
        $data = $this->get_pay_page_data($order , $payment_method_id);
        $res = $client->post($this->execute_payment, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization'=>'bearer wcUinmiNGhdpwKHa1SZWdsAhiQHEyI9TnedqkwriYhcbEK0O8EeQdcRt-nMsJ388ohE1NX0V_-eZXrk3CPXPHrCx9H4cBbpZXJJ1cSo3zqCm8rHH_OPomObuzov9UK6-lB55yzhELf1ff8QVnRIyYlKUSNrdMJrA003Uei0fGcUGxwudzupNSVqCtMpe3JTIcjCz2UvbxZaA_pctGacfnUYQ_V-QJz9xZboy8UalPtn3uw2KaCnZ_srEfFs6_C9QGht91gbpsA3hvi69azDzw0Rm3ttgat8-LncosezkQhFzzUOXP7NzhdpigYlBymnuhcvHSnmR_ELLd4IVIZzDLSZlmSLziTtrk2Z5qzLEW8mYTR2eYkZo88EUJja_CHGtR9vS1Ys41SWPFxin5M7lsILk3XD1Rc6Otbek9M4LecKuz4WCXhJVrE8rEZIvGeWMdJbWoO1o4uG-Z1YfJbRrCTAUTKVAWdmek6bofwg36t6RKbF8ia2AfO0z4yra2scV98WWYe3mHGOOwPNS4LlZRTL3XoPtrqUTOpO9CklAcljidLszwUivz1Wl06rztlrYVibr4zhZfz5Lzr7kxkxm1AbsPtEwRmHFLE6qp6rvTYAXwrede-k-jRQDFpj99a5Ul56JVNSZElWUJFaPsEH1U-qoK-6KuTtkk3JnBfMMBlyZ6OPfGbYqlmiGiGZc_hYaa4qmlQ'
            ],
            'body'=> json_encode($data) ,
        ]);

        $body = $res->getBody();


        return $this->handle_pay_page_response(json_decode($body , true));
    }
    public function create_myfatoorah_direct_payment_url( $url , $request )
    {

        $client = new Client();
        $data = $this->get_direct_pay_page_data($request);

        $res = $client->post($url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization'=>'bearer wcUinmiNGhdpwKHa1SZWdsAhiQHEyI9TnedqkwriYhcbEK0O8EeQdcRt-nMsJ388ohE1NX0V_-eZXrk3CPXPHrCx9H4cBbpZXJJ1cSo3zqCm8rHH_OPomObuzov9UK6-lB55yzhELf1ff8QVnRIyYlKUSNrdMJrA003Uei0fGcUGxwudzupNSVqCtMpe3JTIcjCz2UvbxZaA_pctGacfnUYQ_V-QJz9xZboy8UalPtn3uw2KaCnZ_srEfFs6_C9QGht91gbpsA3hvi69azDzw0Rm3ttgat8-LncosezkQhFzzUOXP7NzhdpigYlBymnuhcvHSnmR_ELLd4IVIZzDLSZlmSLziTtrk2Z5qzLEW8mYTR2eYkZo88EUJja_CHGtR9vS1Ys41SWPFxin5M7lsILk3XD1Rc6Otbek9M4LecKuz4WCXhJVrE8rEZIvGeWMdJbWoO1o4uG-Z1YfJbRrCTAUTKVAWdmek6bofwg36t6RKbF8ia2AfO0z4yra2scV98WWYe3mHGOOwPNS4LlZRTL3XoPtrqUTOpO9CklAcljidLszwUivz1Wl06rztlrYVibr4zhZfz5Lzr7kxkxm1AbsPtEwRmHFLE6qp6rvTYAXwrede-k-jRQDFpj99a5Ul56JVNSZElWUJFaPsEH1U-qoK-6KuTtkk3JnBfMMBlyZ6OPfGbYqlmiGiGZc_hYaa4qmlQ'
            ],
            'body'=> json_encode($data) ,
        ]);

        $body = $res->getBody();

        return $this->handle_direct_pay_page_response(json_decode($body , true));
    }

    public function verify_payment($key , $key_type) {

        $data = [
            "Key" => $key,
            "KeyType" => $key_type,
        ];
        $client = new Client();

        $res = $client->post($this->verify_payment_url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization'=>'bearer wcUinmiNGhdpwKHa1SZWdsAhiQHEyI9TnedqkwriYhcbEK0O8EeQdcRt-nMsJ388ohE1NX0V_-eZXrk3CPXPHrCx9H4cBbpZXJJ1cSo3zqCm8rHH_OPomObuzov9UK6-lB55yzhELf1ff8QVnRIyYlKUSNrdMJrA003Uei0fGcUGxwudzupNSVqCtMpe3JTIcjCz2UvbxZaA_pctGacfnUYQ_V-QJz9xZboy8UalPtn3uw2KaCnZ_srEfFs6_C9QGht91gbpsA3hvi69azDzw0Rm3ttgat8-LncosezkQhFzzUOXP7NzhdpigYlBymnuhcvHSnmR_ELLd4IVIZzDLSZlmSLziTtrk2Z5qzLEW8mYTR2eYkZo88EUJja_CHGtR9vS1Ys41SWPFxin5M7lsILk3XD1Rc6Otbek9M4LecKuz4WCXhJVrE8rEZIvGeWMdJbWoO1o4uG-Z1YfJbRrCTAUTKVAWdmek6bofwg36t6RKbF8ia2AfO0z4yra2scV98WWYe3mHGOOwPNS4LlZRTL3XoPtrqUTOpO9CklAcljidLszwUivz1Wl06rztlrYVibr4zhZfz5Lzr7kxkxm1AbsPtEwRmHFLE6qp6rvTYAXwrede-k-jRQDFpj99a5Ul56JVNSZElWUJFaPsEH1U-qoK-6KuTtkk3JnBfMMBlyZ6OPfGbYqlmiGiGZc_hYaa4qmlQ'
            ],
            'body'=> json_encode($data) ,
        ]);


        $body = $res->getBody();
        return json_decode($body , true);
    }

    public function refund( $key_type, $key , $ammount){

        $data = array (
            'KeyType' => $key_type,
            'Key' => $key,
            'RefundChargeOnCustomer' => true,
            'ServiceChargeOnCustomer' => true,
            'Amount' => $ammount,
            'Comment' => 'refund',
        );

        $client = new Client();

        $res = $client->post($this->refund_payment, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization'=>'bearer wcUinmiNGhdpwKHa1SZWdsAhiQHEyI9TnedqkwriYhcbEK0O8EeQdcRt-nMsJ388ohE1NX0V_-eZXrk3CPXPHrCx9H4cBbpZXJJ1cSo3zqCm8rHH_OPomObuzov9UK6-lB55yzhELf1ff8QVnRIyYlKUSNrdMJrA003Uei0fGcUGxwudzupNSVqCtMpe3JTIcjCz2UvbxZaA_pctGacfnUYQ_V-QJz9xZboy8UalPtn3uw2KaCnZ_srEfFs6_C9QGht91gbpsA3hvi69azDzw0Rm3ttgat8-LncosezkQhFzzUOXP7NzhdpigYlBymnuhcvHSnmR_ELLd4IVIZzDLSZlmSLziTtrk2Z5qzLEW8mYTR2eYkZo88EUJja_CHGtR9vS1Ys41SWPFxin5M7lsILk3XD1Rc6Otbek9M4LecKuz4WCXhJVrE8rEZIvGeWMdJbWoO1o4uG-Z1YfJbRrCTAUTKVAWdmek6bofwg36t6RKbF8ia2AfO0z4yra2scV98WWYe3mHGOOwPNS4LlZRTL3XoPtrqUTOpO9CklAcljidLszwUivz1Wl06rztlrYVibr4zhZfz5Lzr7kxkxm1AbsPtEwRmHFLE6qp6rvTYAXwrede-k-jRQDFpj99a5Ul56JVNSZElWUJFaPsEH1U-qoK-6KuTtkk3JnBfMMBlyZ6OPfGbYqlmiGiGZc_hYaa4qmlQ'
            ],
            'body'=> json_encode($data) ,
        ]);


        $body = $res->getBody();

        return json_decode($body , true);
    }


    // helper methods
    public function handle_pay_page_response($data) {

        if($data['IsSuccess']) {
            $response = [
                'status' => true ,
                'invoice_id' => $data['Data']['InvoiceId'],
                'is_direct_payment' => $data['Data']['IsDirectPayment'],
                'payment_url' => $data['Data']['PaymentURL'],
                'customer_reference' => $data['Data']['CustomerReference'],
                'user_defined_field' => $data['Data']['UserDefinedField'],

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

    public function handle_direct_pay_page_response($data) {

        $response = [
            'status' => $data['Data']['Status'],
            'error_message' => $data['Data']['ErrorMessage'],
            'payment_id' => $data['Data']['PaymentId'],

        ];
        return $response;
    }

}