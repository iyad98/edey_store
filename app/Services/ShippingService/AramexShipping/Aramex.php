<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 10/8/2019
 * Time: 5:39 م
 */

namespace App\Services\ShippingService\AramexShipping;

use GuzzleHttp\Client;

use App\Models\Currency;
use Carbon\Carbon;

use App\Services\ShippingService\AddressShipping;

class Aramex
{
    use AddressShipping;

    public $url;
    public $username;
    public $password;
    public $account_number;
    public $pin_number;
    public $account_country_code;
    public $account_entity;

    public function __construct()
    {
        $this->url = env('ARAMEX_URL');
        $this->username = env('ARAMEX_USERNAME');
        $this->password = env('ARAMEX_PASSWORD');
        $this->account_number = env('ARAMEX_ACCOUNT_NUMBER');
        $this->pin_number = env('ARAMEX_PIN_NUMBER');
        $this->account_country_code = env('ARAMEX_ACCOUNT_COUNTRY_CODE');
        $this->account_entity = env('ARAMEX_ACCOUNT_ENTITY');


        $this->client = new Client();
    }

    public function add_shipment($order , $is_order_returned = false) {
        $total_price = $order->payment_method_id == 1 ? $order->total_price : 0;
        if($is_order_returned) {
            $total_price = 0;
        }
        $foreignHAWB = time().$order->id.mt_rand(10000000000,99999999999);
        $currency_data['exchange_rate'] = $order->exchange_rate;
        $currency = Currency::find($order->currency_id);
        $shipping_data = $order->order_user_shipping;
        $city = $shipping_data->shipping_city;
        $country = $city ? $city->country : null;
        $address = $shipping_data->city2." - ".$shipping_data->state." - ".$shipping_data->address;

        $getCompanyClientData = $this->getCompanyClientData($order , $is_order_returned);

        $client_info    = array(
            'AccountCountryCode'	=> $this->account_country_code,
            'AccountEntity'		 	=> $this->account_entity,
            'AccountNumber'		 	=> $this->account_number,
            'AccountPin'		 	=> $this->pin_number,
            'UserName'			 	=> $this->username,
            'Password'			 	=> $this->password,
            'Version'			 	=> '1.0'
        );
        $transaction    = array(
            'Reference1'			=> $order->id,
            'Reference2'			=> '',
            'Reference3'			=> '',
            'Reference4'			=> '',
            'Reference5'			=> '',
        );
        $label_info     =  array(
            'ReportID' 				=> 9201,
            'ReportType'			=> 'URL',
        );

        $party_address  = $getCompanyClientData['customer']['PartyAddress'];
        $contact        = $getCompanyClientData['customer']['Contact'];
        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        $soapClient = new \SoapClient($this->url.'?wsdl');
        $params = [
            'Transaction' 			=> $transaction,
            'LabelInfo'				=> $label_info,
            'ClientInfo'  			=>$client_info,
            'Shipments'             => array(
                'Shipment' => array(
                    'Shipper'	=> array(
                        'Reference1' 	=> $order->id,
                        'Reference2' 	=> '',
                        'AccountNumber' => $this->account_number,
                        'PartyAddress'	=> $getCompanyClientData['shipper']['PartyAddress'],
                        'Contact'		=> $getCompanyClientData['shipper']['Contact'] ,
                    ),

                    'Consignee'	=> array(
                        'Reference1'	=> 'Ref 333333',
                        'Reference2'	=> 'Ref 444444',
                        'AccountNumber' => '',
                        'PartyAddress'	=> $party_address,
                        'Contact'		=> $contact,
                    ),

                    'ThirdParty' => array(
                        'Reference1' 	=> '',
                        'Reference2' 	=> '',
                        'AccountNumber' => '',
                        'PartyAddress'	=> array(
                            'Line1'					=> '',
                            'Line2'					=> '',
                            'Line3'					=> '',
                            'City'					=> '',
                            'StateOrProvinceCode'	=> '',
                            'PostCode'				=> '',
                            'CountryCode'			=> ''
                        ),
                        'Contact'		=> array(
                            'Department'			=> '',
                            'PersonName'			=> '',
                            'Title'					=> '',
                            'CompanyName'			=> '',
                            'PhoneNumber1'			=> '',
                            'PhoneNumber1Ext'		=> '',
                            'PhoneNumber2'			=> '',
                            'PhoneNumber2Ext'		=> '',
                            'FaxNumber'				=> '',
                            'CellPhone'				=> '',
                            'EmailAddress'			=> '',
                            'Type'					=> ''
                        ),
                    ),

                    'Reference1' 				=> 12,
                    'Reference2' 				=> '',
                    'Reference3' 				=> '',
                    'ForeignHAWB'				=> $foreignHAWB,
                    'TransportType'				=> 0,
                    'ShippingDateTime' 			=> time(),
                    'DueDate'					=> time(),
                    'PickupLocation'			=> 'Reception',
                    'PickupGUID'				=> '',
                    'Comments'					=> 'Shpt',
                    'AccountingInstrcutions' 	=> '',
                    'OperationsInstructions'	=> '',

                    'Details' => array(
                        'Dimensions' => array(
                            'Length'				=> 10,
                            'Width'					=> 10,
                            'Height'				=> 10,
                            'Unit'					=> 'cm',

                        ),

                        'ActualWeight' => array(
                            'Value'					=> 0.5,
                            'Unit'					=> 'Kg'
                        ),

                        'ProductGroup' 			=> 'EXP',
                        'ProductType'			=> 'PDX',
                        'PaymentType'			=> 'P',
                        'PaymentOptions' 		=> '',
                        'Services'				=> '',
                        'NumberOfPieces'		=> $order->order_products()->count(),
                        'DescriptionOfGoods' 	=> 'Docs',
                        'GoodsOriginCountry' 	=> 'Jo',

                        'CashOnDeliveryAmount' 	=> array(
                            'Value'					=> reverse_convert_currency($order->cash_fees ,$currency_data),
                            'CurrencyCode'			=> $currency->code
                        ),

                        'InsuranceAmount'		=> array(
                            'Value'					=> 0,
                            'CurrencyCode'			=> ''
                        ),

                        'CollectAmount'			=> array(
                            'Value'					=> reverse_convert_currency($total_price, $currency_data),
                            'CurrencyCode'			=> $currency->code
                        ),

                        'CashAdditionalAmount'	=> array(
                            'Value'					=> 0,
                            'CurrencyCode'			=> ''
                        ),

                        'CashAdditionalAmountDescription' => '',

                        'CustomsValueAmount' => array(
                            'Value'					=> 0,
                            'CurrencyCode'			=> ''
                        ),

                        'Items' 				=> array(

                        )
                    ),
                ),
            ),
        ];
        try {

            $auth_call = $soapClient->CreateShipments($params);
            if($auth_call->HasErrors && isset($auth_call->Notifications->Notification)) return $this->show_error_message($auth_call);
            if($auth_call->Shipments->ProcessedShipment->HasErrors) {
                return $this->show_error_message($auth_call->Shipments->ProcessedShipment);
            }
            return ['status' => true , 'message' => '' , 'data' =>
                [
                    // 'pickup_id' => $auth_call->ProcessedPickup->ID,
                    // 'pickup_GUID' => $auth_call->ProcessedPickup->GUID,
                    'shipping_policy' => $auth_call->Shipments->ProcessedShipment->ID,
                    'foreignHAWB'    => $foreignHAWB
                ]];
        } catch (SoapFault $fault) {
            return ['status' => false , 'message' => $fault->faultstring, 'data' => []];
        }catch (\Exception $e) {
            return ['status' => false , 'message' => $e->getMessage(), 'data' => []];
        }catch (\Error $e) {
            return ['status' => false , 'message' => $e->getMessage(), 'data' => []];
        }
    }
    public function add_pickup($order,$pickup_date,$ready_time,$last_pickup_time,$closing_time)
    {
        $total_price = $order->payment_method_id == 1 ? $order->total_price : 0;

        $currency_data['exchange_rate'] = $order->exchange_rate;
        $currency = Currency::find($order->currency_id);
        $shipping_data = $order->order_user_shipping;
        $city = $shipping_data->shipping_city;
        $country = $city ? $city->country : null;
        $address = $shipping_data->city2." - ".$shipping_data->state." - ".$shipping_data->address;


        $client_info    = array(
            'AccountCountryCode'	=> $this->account_country_code,
            'AccountEntity'		 	=> $this->account_entity,
            'AccountNumber'		 	=> $this->account_number,
            'AccountPin'		 	=> $this->pin_number,
            'UserName'			 	=> $this->username,
            'Password'			 	=> $this->password,
            'Version'			 	=> '1.0'
        );
        $transaction    = array(
            'Reference1'			=> $order->id,
            'Reference2'			=> '',
            'Reference3'			=> '',
            'Reference4'			=> '',
            'Reference5'			=> '',
        );
        $label_info     =  array(
            'ReportID' 				=> 9201,
            'ReportType'			=> 'URL',
        );
        $party_address  = array(
            'Line1'					=> $address,
            'Line2' 				=> '',
            'Line3' 				=> '',
            'City'					=> $city->name_en,
            'StateOrProvinceCode'	=> '',
            'PostCode'				=> '',
            'CountryCode'			=> $country->iso2
        );
        $contact        = array(
            'Department'			=> '',
            'PersonName'			=> $order->user_name,
            'Title'					=> '',
            'CompanyName'			=> 'Aramex',
            'PhoneNumber1'			=> $order->user_phone,
            'PhoneNumber1Ext'		=> '',
            'PhoneNumber2'			=> '',
            'PhoneNumber2Ext'		=> '',
            'FaxNumber'				=> '',
            'CellPhone'				=> $order->user_phone,
            'EmailAddress'			=> $order->user_email,
            'Type'					=> ''
        );
        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        $soapClient = new \SoapClient($this->url.'?wsdl');
        // dd($soapClient->__getFunctions());
        $params = [
            'Transaction' 			=> $transaction,
            'LabelInfo'				=> $label_info,
            'ClientInfo'  			=>$client_info,
            'Pickup'                => array(
                'PickupAddress'	         => $party_address,
                'PickupContact'		     => $contact,
                'PickupLocation'         => 'Test',
                'PickupDate'             => $pickup_date->timestamp,
                'ReadyTime'              => $ready_time->timestamp,
                'LastPickupTime'         => $last_pickup_time->timestamp,
                'ClosingTime'            => $closing_time->timestamp,

                'Reference1'	         => $order->id,
                'Status'                 => 'Ready',
                'PickupItems'            => [
                    array(
                        'ProductGroup' 			=> 'EXP',
                        'ProductType'			=> 'PDX',
                        'Payment'			=> 'P',
                        'NumberOfShipments'     => 1,
                        'PackageType'           => '',
                        'ShipmentWeight'        => [
                            'Value'					=> 0,
                            'Unit'					=> 'Kg'
                        ],
                        'NumberOfPieces'		=> $order->order_products()->count(),
                        'CashAmount'	        => array(
                            'Value'					=> reverse_convert_currency($order->cash_fees ,$currency_data),
                            'CurrencyCode'			=> $currency->code
                        ),
                        'ExtraCharges'	        => array(
                            'Value'					=> 0,
                            'CurrencyCode'			=> ''
                        ),

                        'ShipmentDimensions'    => [
                            'Length'				=> 0,
                            'Width'					=> 0,
                            'Height'				=> 0,
                            'Unit'					=> 'cm',
                        ],
                        'comments'              => 'comments'
                    ),
                ],
//                'Shipments'             => array(
//                    'Shipment' => array(
//                        'Shipper'	=> array(
//                            'Reference1' 	=> $order->id,
//                            'Reference2' 	=> $order->id,
//                            'AccountNumber' => $this->account_number,
//                            'PartyAddress'	=> array(
//                                'Line1'					=> 'Mecca St',
//                                'Line2' 				=> '',
//                                'Line3' 				=> '',
//                                'City'					=> 'Riyadh',
//                                'StateOrProvinceCode'	=> '',
//                                'PostCode'				=> '',
//                                'CountryCode'			=> 'SA'
//                            ),
//                            'Contact'		=> array(
//                                'Department'			=> '',
//                                'PersonName'			=> 'Michael',
//                                'Title'					=> '',
//                                'CompanyName'			=> 'Aramex',
//                                'PhoneNumber1'			=> '5555555',
//                                'PhoneNumber1Ext'		=> '125',
//                                'PhoneNumber2'			=> '',
//                                'PhoneNumber2Ext'		=> '',
//                                'FaxNumber'				=> '',
//                                'CellPhone'				=> '07777777',
//                                'EmailAddress'			=> 'michael@aramex.com',
//                                'Type'					=> ''
//                            ),
//                        ),
//
//                        'Consignee'	=> array(
//                            'Reference1'	=> 'Ref 333333',
//                            'Reference2'	=> 'Ref 444444',
//                            'AccountNumber' => '',
//                            'PartyAddress'	=> $party_address,
//                            'Contact'		=> $contact,
//                        ),
//
//                        'ThirdParty' => array(
//                            'Reference1' 	=> '',
//                            'Reference2' 	=> '',
//                            'AccountNumber' => '',
//                            'PartyAddress'	=> array(
//                                'Line1'					=> '',
//                                'Line2'					=> '',
//                                'Line3'					=> '',
//                                'City'					=> '',
//                                'StateOrProvinceCode'	=> '',
//                                'PostCode'				=> '',
//                                'CountryCode'			=> ''
//                            ),
//                            'Contact'		=> array(
//                                'Department'			=> '',
//                                'PersonName'			=> '',
//                                'Title'					=> '',
//                                'CompanyName'			=> '',
//                                'PhoneNumber1'			=> '',
//                                'PhoneNumber1Ext'		=> '',
//                                'PhoneNumber2'			=> '',
//                                'PhoneNumber2Ext'		=> '',
//                                'FaxNumber'				=> '',
//                                'CellPhone'				=> '',
//                                'EmailAddress'			=> '',
//                                'Type'					=> ''
//                            ),
//                        ),
//
//                        'Reference1' 				=> $order->id,
//                        'Reference2' 				=> '',
//                        'Reference3' 				=> '',
//                        'ForeignHAWB'				=> 100228825522,
//                        'TransportType'				=> 0,
//                        'ShippingDateTime' 			=> time(),
//                        'DueDate'					=> time(),
//                        'PickupLocation'			=> 'Reception',
//                        'PickupGUID'				=> '',
//                        'Comments'					=> 'Shpt',
//                        'AccountingInstrcutions' 	=> '',
//                        'OperationsInstructions'	=> '',
//
//                        'Details' => array(
//                            'Dimensions' => array(
//                                'Length'				=> 10,
//                                'Width'					=> 10,
//                                'Height'				=> 10,
//                                'Unit'					=> 'cm',
//
//                            ),
//
//                            'ActualWeight' => array(
//                                'Value'					=> 0.5,
//                                'Unit'					=> 'Kg'
//                            ),
//
//                            'ProductGroup' 			=> 'EXP',
//                            'ProductType'			=> 'PDX',
//                            'PaymentType'			=> 'P',
//                            'PaymentOptions' 		=> '',
//                            'Services'				=> '',
//                            'NumberOfPieces'		=> $order->order_products()->count(),
//                            'DescriptionOfGoods' 	=> 'Docs',
//                            'GoodsOriginCountry' 	=> 'Jo',
//
//                            'CashOnDeliveryAmount' 	=> array(
//                                'Value'					=> reverse_convert_currency($order->cash_fees ,$currency_data),
//                                'CurrencyCode'			=> $currency->code
//                            ),
//
//                            'InsuranceAmount'		=> array(
//                                'Value'					=> 0,
//                                'CurrencyCode'			=> ''
//                            ),
//
//                            'CollectAmount'			=> array(
//                                'Value'					=> 0,
//                                'CurrencyCode'			=> ''
//                            ),
//
//                            'CashAdditionalAmount'	=> array(
//                                'Value'					=> 0,
//                                'CurrencyCode'			=> ''
//                            ),
//
//                            'CashAdditionalAmountDescription' => '',
//
//                            'CustomsValueAmount' => array(
//                                'Value'					=> reverse_convert_currency($total_price, $currency_data),
//                                'CurrencyCode'			=> $currency->code
//                            ),
//
//                            'Items' 				=> array(
//
//                            )
//                        ),
//                    ),
//                ),
            ),
        ];
        try {
            $auth_call = $soapClient->CreatePickup($params);
            if($auth_call->HasErrors) return $this->show_error_message($auth_call);
//            if($auth_call->ProcessedPickup->ProcessedShipments->ProcessedShipment->HasErrors) {
//                $this->cancel_order($auth_call->ProcessedPickup->GUID);
//                return $this->show_error_message($auth_call->ProcessedPickup->ProcessedShipments->ProcessedShipment);
//            }
            return ['status' => true , 'message' => '' , 'data' =>
                [
                    'pickup_id' => $auth_call->ProcessedPickup->ID,
                    'pickup_GUID' => $auth_call->ProcessedPickup->GUID,
                    //  'shipping_policy' => $auth_call->ProcessedPickup->ProcessedShipments->ProcessedShipment->ID,
                ]];
        } catch (SoapFault $fault) {
            return ['status' => false , 'message' => $fault->faultstring, 'data' => []];
        }catch (\Exception $e) {
            return ['status' => false , 'message' => $e->getMessage(), 'data' => []];
        }catch (\Error $e) {
            return ['status' => false , 'message' => $e->getMessage(), 'data' => []];
        }

    }
    public function cancel_order($pickup_GUID)
    {
        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        $soapClient = new \SoapClient($this->url.'?wsdl');
        //  dd($soapClient->__getFunctions());
        $params = array(
            'ClientInfo'  			=> array(
                'AccountCountryCode'	=> $this->account_country_code,
                'AccountEntity'		 	=> $this->account_entity,
                'AccountNumber'		 	=> $this->account_number,
                'AccountPin'		 	=> $this->pin_number,
                'UserName'			 	=> $this->username,
                'Password'			 	=> $this->password,
                'Version'			 	=> '1.0'
            ),
            'Transaction' 			=> array(
                'Reference1'			=> '001',
                'Reference2'			=> '',
                'Reference3'			=> '',
                'Reference4'			=> '',
                'Reference5'			=> '',
            ),
            'PickupGUID'		        => $pickup_GUID
        );
        try {
            $auth_call = $soapClient->CancelPickup($params);

            if($auth_call->HasErrors) {
                return $this->show_error_message($auth_call);
            }else {
                return ['status' => true , 'message' => $auth_call->Message, 'data' => []];
            }
        } catch (SoapFault $fault) {
            return ['status' => false , 'message' => $fault->faultstring, 'data' => []];
        }catch (\Exception $e) {
            return ['status' => false , 'message' => $e->getMessage(), 'data' => []];
        }catch (\Error $e) {
            return ['status' => false , 'message' => $e->getMessage(), 'data' => []];
        }
    }

    public function print_awb($order_id, $awb)
    {
        $result = $this->get_print_data($order_id, $awb);
        if($result['status']) {
            return redirect()->to($result['data']);
        }else {
            return $result;
        }

    }
    public function get_print_data($order_id, $awb) {
        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        $soapClient = new \SoapClient($this->url.'?wsdl');
        //  dd($soapClient->__getFunctions());
        $params = array(
            'ClientInfo'  			=> array(
                'AccountCountryCode'	=> $this->account_country_code,
                'AccountEntity'		 	=> $this->account_entity,
                'AccountNumber'		 	=> $this->account_number,
                'AccountPin'		 	=> $this->pin_number,
                'UserName'			 	=> $this->username,
                'Password'			 	=> $this->password,
                'Version'			 	=> '1.0'
            ),
            'Transaction' 			=> array(
                'Reference1'			=> '001',
                'Reference2'			=> '',
                'Reference3'			=> '',
                'Reference4'			=> '',
                'Reference5'			=> '',
            ),
            'ShipmentNumber'		=> $awb,
            'ProductGroup'		    => '',
            'OriginEntity'	     	=> '',
            'LabelInfo'             => array(
                'ReportID' 				=> 9729,
                'ReportType'			=> 'URL',
            ),

        );
        try {
            $auth_call = $soapClient->PrintLabel($params);
            if($auth_call->HasErrors) return $this->show_error_message($auth_call);
            return ['status' => true ,'message' => '' , 'data' => $auth_call->ShipmentLabel->LabelURL];
        } catch (SoapFault $fault) {
            return ['status' => false , 'message' => $fault->faultstring, 'data' => []];
        }
    }



    public function show_error_message($auth_call) {
        return ['status' => false , 'message' =>$auth_call->Notifications->Notification->Message , 'data' => []];
    }

    // help function
    public function getCompanyClientData($order , $is_order_returned = false) {
        $company_address = $this->getCompanyAddress();
        $client_address = $this->getClientAddress($order);

        if($is_order_returned) {
            $shipper = [
                'PartyAddress'	=> array(
                    'Line1'					=> $client_address['place'],
                    'Line2' 				=> '',
                    'Line3' 				=> '',
                    'City'					=> $client_address['city'],
                    'StateOrProvinceCode'	=> '',
                    'PostCode'				=> '',
                    'CountryCode'			=> $client_address['country_code']
                ),
                'Contact'		=> array(
                    'Department'			=> '',
                    'PersonName'			=> $client_address['name'],
                    'Title'					=> '',
                    'CompanyName'			=> 'Aramex',
                    'PhoneNumber1'			=> $client_address['phone'],
                    'PhoneNumber1Ext'		=> '125',
                    'PhoneNumber2'			=> '',
                    'PhoneNumber2Ext'		=> '',
                    'FaxNumber'				=> '',
                    'CellPhone'				=> $client_address['phone'],
                    'EmailAddress'			=> $client_address['email'],
                    'Type'					=> ''
                ),
            ];
            $customer = [
                'PartyAddress'	=> array(
                    'Line1'					=> $company_address['place'],
                    'Line2' 				=> '',
                    'Line3' 				=> '',
                    'City'					=> $company_address['city'],
                    'StateOrProvinceCode'	=> '',
                    'PostCode'				=> '',
                    'CountryCode'			=> $company_address['country_code']
                ),
                'Contact'		=> array(
                    'Department'			=> '',
                    'PersonName'			=> $company_address['name'],
                    'Title'					=> '',
                    'CompanyName'			=> 'Aramex',
                    'PhoneNumber1'			=> $company_address['phone'],
                    'PhoneNumber1Ext'		=> '125',
                    'PhoneNumber2'			=> '',
                    'PhoneNumber2Ext'		=> '',
                    'FaxNumber'				=> '',
                    'CellPhone'				=> $company_address['phone'],
                    'EmailAddress'			=> $company_address['email'],
                    'Type'					=> ''
                ),
            ];

        }else {
            $shipper = [
                'PartyAddress'	=> array(
                    'Line1'					=> $company_address['place'],
                    'Line2' 				=> '',
                    'Line3' 				=> '',
                    'City'					=> $company_address['city'],
                    'StateOrProvinceCode'	=> '',
                    'PostCode'				=> '',
                    'CountryCode'			=> $company_address['country_code']
                ),
                'Contact'		=> array(
                    'Department'			=> '',
                    'PersonName'			=> $company_address['name'],
                    'Title'					=> '',
                    'CompanyName'			=> 'Aramex',
                    'PhoneNumber1'			=> $company_address['phone'],
                    'PhoneNumber1Ext'		=> '125',
                    'PhoneNumber2'			=> '',
                    'PhoneNumber2Ext'		=> '',
                    'FaxNumber'				=> '',
                    'CellPhone'				=> $company_address['phone'],
                    'EmailAddress'			=> $company_address['email'],
                    'Type'					=> ''
                ),
            ];
            $customer = [
                'PartyAddress'	=> array(
                    'Line1'					=> $client_address['place'],
                    'Line2' 				=> '',
                    'Line3' 				=> '',
                    'City'					=> $client_address['city'],
                    'StateOrProvinceCode'	=> '',
                    'PostCode'				=> '',
                    'CountryCode'			=> $client_address['country_code']
                ),
                'Contact'		=> array(
                    'Department'			=> '',
                    'PersonName'			=> $client_address['name'],
                    'Title'					=> '',
                    'CompanyName'			=> 'Aramex',
                    'PhoneNumber1'			=> $client_address['phone'],
                    'PhoneNumber1Ext'		=> '125',
                    'PhoneNumber2'			=> '',
                    'PhoneNumber2Ext'		=> '',
                    'FaxNumber'				=> '',
                    'CellPhone'				=> $client_address['phone'],
                    'EmailAddress'			=> $client_address['email'],
                    'Type'					=> ''
                ),
            ];

        }
        return [
            'customer' => $customer,
            'shipper' => $shipper
        ];
    }
}
