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

use App\Models\ActionLog;
use Illuminate\Support\Facades\Auth;

trait ActionLogTrait
{

    public function add_action($type, $model , $data) {
        ActionLog::create([
            'admin_id' => Auth::guard('admin')->user()->admin_id ,
            'type'     => $type ,
            'model'    => $model,
            'data'     => $data
        ]);
    }

    public function getDescription($action_log) {

        $attrs = [];
        $text = "";
        $params = [];
        $data = json_decode($action_log->data , true);
        switch ($action_log->type) {
            case "add_brand" :
                $text = 'logs.add_brand';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "update_brand" :
                $text = 'logs.update_brand';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "delete_brand" :
                $text = 'logs.delete_brand';
                $params['name_ar'] = $data['name_ar'];
                break;

            case "add_store" :
                $text = 'logs.add_store';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "update_store" :
                $text = 'logs.update_store';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "delete_store" :
                $text = 'logs.delete_store';
                $params['name_ar'] = $data['name_ar'];
                break;

            case "add_category" :
                $text = 'logs.add_category';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "update_category" :
                $text = 'logs.update_category';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "delete_category" :
                $text = 'logs.delete_category';
                $params['name_ar'] = $data['name_ar'];
                break;

            case "add_attribute" :
                $text = 'logs.add_attribute';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "update_attribute" :
                $text = 'logs.update_attribute';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "delete_attribute" :
                $text = 'logs.delete_attribute';
                $params['name_ar'] = $data['name_ar'];
                break;

            case "add_attribute_value" :
                $text = 'logs.add_attribute_value';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "update_attribute_value" :
                $text = 'logs.update_attribute_value';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "delete_attribute_value" :
                $text = 'logs.delete_attribute_value';
                $params['name_ar'] = $data['name_ar'];
                break;

            case "add_coupon" :
                $text = 'logs.add_coupon';
                $params['coupon'] = $data['coupon'];
                break;
            case "update_coupon" :
                $text = 'logs.update_coupon';
                $params['coupon'] = $data['coupon'];
                break;
            case "delete_coupon" :
                $text = 'logs.delete_coupon';
                $params['coupon'] = $data['coupon'];
                break;

            case "approve_bank_transfer" :
                $text = 'logs.approve_bank_transfer';
                $params = ['id' => $data['id'], 'order_id' => $data['order_id']];
                break;
            case "reject_bank_transfer" :
                $text = 'logs.reject_bank_transfer';
                $params = ['id' => $data['id'], 'order_id' => $data['order_id']];
                break;

            case "add_shipping_company" :
                $text = 'logs.add_shipping_company';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "update_shipping_company" :
                $text = 'logs.update_shipping_company';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "delete_shipping_company" :
                $text = 'logs.delete_shipping_company';
                $params['name_ar'] = $data['name_ar'];
                break;

            case "add_shipping_company_city" :
                $text = 'logs.add_shipping_company_city';
                $params = ['company_name_ar' => $data['company_name_ar'] ,'cities' => $data['cities'] ];
                break;
            case "update_shipping_company_city" :
                $text = 'logs.update_shipping_company_city';
                $params = ['company_name_ar' => $data['company_name_ar'] ,'cities' => $data['cities'] ];
                break;
            case "delete_shipping_company_city" :
                $text = 'logs.delete_shipping_company_city';
                $params = ['company_name_ar' => $data['company_name_ar'] ,'cities' => $data['cities'] ];
                break;

            case "add_banner" :
                $text = 'logs.add_banner';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "update_banner" :
                $text = 'logs.update_banner';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "delete_banner" :
                $text = 'logs.delete_banner';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "change_status_banner" :
                $text = 'logs.change_status_banner';
                $params =['name_ar' => $data['name_ar'] , 'from_status' => $data['from_status'] , 'to_status' => $data['to_status']];
                break;

            case "add_banner_value" :
                $text = 'logs.add_banner_value';
                $params =['name_ar' => $data['name_ar'] , 'parent_ar' =>$data['parent']['name_ar']];
                break;
            case "update_banner_value" :
                $text = 'logs.update_banner_value';
                $params =['name_ar' => $data['name_ar'] , 'parent_ar' =>$data['parent']['name_ar']];
                break;
            case "delete_banner_value" :
                $text = 'logs.delete_banner_value';
                $params =['name_ar' => $data['name_ar'] , 'parent_ar' =>$data['parent']['name_ar']];
                break;
            case "change_status_banner_value" :
                $text = 'logs.change_status_banner_value';
                $params =[
                    'name_ar' => $data['name_ar'] , 'from_status' => $data['from_status'] ,
                    'to_status' => $data['to_status'] , 'parent_ar' => $data['parent']['name_ar']
                ];
                break;

            case "add_user" :
                $text = 'logs.add_user';
                $params = [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email'],
                ];
                break;
            case "update_user" :
                $text = 'logs.update_user';
                $params = [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email'],
                ];
                break;
            case "delete_user" :
                $text = 'logs.delete_user';
                $params = [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email'],
                ];
                break;
            case "change_status_user" :
                $text = 'logs.change_status_user';
                $params = [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email'],
                    'from_status' => $data['from_status'],
                    'to_status' => $data['to_status']
                ];
                break;

            case "update_advertisement" :
                $text = 'logs.update_advertisement';
                $params = [];
                break;
            case "update_app_category" :
                $text = 'logs.update_app_category';
                $params = [];
                break;
            case "update_app_sidebar_category" :
                $text = 'logs.update_app_sidebar_category';
                $params = [];
                break;

            case "add_slider" :
                $text = 'logs.add_slider';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "update_slider" :
                $text = 'logs.update_slider';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "delete_slider" :
                $text = 'logs.delete_slider';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "change_status_slider" :
                $text = 'logs.change_status_slider';
                $params =['name_ar' => $data['name_ar'] , 'from_status' => $data['from_status'] , 'to_status' => $data['to_status']];
                break;

            case "add_app_notification" :
                $text = 'logs.add_app_notification';
                break;

            case "update_website_note" :
                $text = 'logs.update_website_note';
                break;
            case "update_website_category" :
                $text = 'logs.update_website_category';
                break;
            case "update_sidebar_website_category" :
                $text = 'logs.update_sidebar_website_category';
                break;

            case "update_setting" :
                $text = 'logs.update_setting';
                break;
            case "update_message_setting" :
                $text = 'logs.update_message_setting';
                break;

            case "add_city" :
                $text = 'logs.add_city';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "update_city" :
                $text = 'logs.update_city';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "delete_city" :
                $text = 'logs.delete_city';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "change_status_city" :
                $text = 'logs.change_status_city';
                $params = [
                    'cities' => $data['cities'],
                    'to_status' => $data['to_status']
                ];
                break;

            case "update_country" :
                $text = 'logs.update_country';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "change_status_country" :
                $text = 'logs.change_status_country';
                $params = [
                    'countries' => $data['countries'],
                    'to_status' => $data['to_status']
                ];
                break;

            case "add_bank" :
                $text = 'logs.add_bank';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "update_bank" :
                $text = 'logs.update_bank';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "delete_bank" :
                $text = 'logs.delete_bank';
                $params['name_ar'] = $data['name_ar'];
                break;

            case "update_payment_method" :
                $text = 'logs.update_payment_method';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "change_status_payment_method" :
                $text = 'logs.change_status_payment_method';
                $params = [
                    'name_ar' => $data['name_ar'],
                    'to_status' => $data['to_status'],
                    'from_status' => $data['from_status']
                ];
                break;

            case "add_product" :
                $text = 'logs.add_product';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "update_product" :
                $text = 'logs.update_product';
                $params['name_ar'] = $data['name_ar'];
                break;
            case "delete_product" :
                $text = 'logs.delete_product';
                $params['name_ar'] = $data['name_ar'];
                break;

            case "add_products_to_order" :
                $text = 'logs.add_products_to_order';
                $params = ['products' => $data['products'] , 'order_id' => $data['order']['id']];
                break;
            case "update_product_in_order" :
                $text = 'logs.update_product_in_order';
                $params = ['product' => $data['product'] , 'order_id' => $data['order']['id']];
                break;
            case "delete_product_to_order" :
                $text = 'logs.delete_product_to_order';
                $params = ['product' => $data['product'] , 'order_id' => $data['order']['id']];
                break;

            case "add_shipping_policy" :
                $text = 'logs.add_shipping_policy';
                $params = ['shipping_policy' => $data['shipping_policy'] , 'order_id' => $data['id']];
                break;
            case "add_shipping_policy_return" :
                $text = 'logs.add_shipping_policy_return';
                $params = ['shipping_policy' => $data['shipping_policy'] , 'order_id' => $data['id']];
                break;

            case "print_shipping_policy" :
                $text = 'logs.print_shipping_policy';
                $params = ['shipping_policy' => $data['shipping_policy'] , 'order_id' => $data['id']];
                break;
            case "print_shipping_policy_return" :
                $text = 'logs.print_shipping_policy_return';
                $params = ['shipping_policy' => $data['shipping_policy'] , 'order_id' => $data['id']];
                break;
            case "cancel_shipping_policy" :
                $text = 'logs.cancel_shipping_policy';
                $params = ['order_id' => $data['id']];
                break;
            case "cancel_shipping_policy_return" :
                $text = 'logs.cancel_shipping_policy_return';
                $params = ['order_id' => $data['id']];
                break;

            case "add_invoice_number" :
                $text = 'logs.add_invoice_number';
                $params = ['invoice_number' => $data['invoice_number'] , 'order_id' => $data['id']];
                break;

            case "update_order_data" :
                $text = 'logs.update_order_data';
                $params = ['order_id' => $data['id']];
                break;

            case "change_order_status" :
                $text = 'logs.change_order_status';
                $params = ['order_id' => $data['order']['id'] , 'from_status' => $data['from_status'],'to_status' => $data['to_status']];
                break;

            case "print_order" :
                $text = 'logs.print_order';
                $params = ['order_id' => $data['id']];
                break;

            case "export_store_statistics" :
                $text = 'logs.export_store_statistics';
                $params = [];
                break;
            case "print_store_statistics" :
                $text = 'logs.print_store_statistics';
                $params = [];
                break;

            case "export_store_bill" :
                $text = 'logs.export_store_bill';
                $params = [];
                break;
            case "print_store_bill" :
                $text = 'logs.print_store_bill';
                $params = [];
                break;

            case "export_product_report" :
                $text = 'logs.export_product_report';
                $params = [];
                break;
            case "print_product_report" :
                $text = 'logs.print_product_report';
                $params = [];
                break;

            case "export_product_report_sku" :
                $text = 'logs.export_product_report_sku';
                $params = [];
                break;
            case "print_product_report_sku" :
                $text = 'logs.print_product_report_sku';
                $params = [];
                break;

            case "export_coupon_bill" :
                $text = 'logs.export_coupon_bill';
                $params = [];
                break;
            case "print_coupon_bill" :
                $text = 'logs.print_coupon_bill';
                $params = [];
                break;

            case "approve_order_return" :
                $text = 'logs.approve_order_return';
                $params = ['order_id' => $data['id']];
                break;
            case "reject_order_return" :
                $text = 'logs.reject_order_return';
                $params = ['order_id' => $data['id']];
                break;
        }
        $new_text = trans($text, $params);
        $key_words = array_values($params);
        $replaces = [];

        $key_words = collect($key_words)->sortBy(function($string) {
            return mb_strlen($string);
        })->toArray();
        $key_words = array_reverse($key_words);
        foreach ($key_words as $key_word) {
            $replaces[] = "<span style='color: blue'> {$key_word}</span>";
        }
        return str_replace($key_words, $replaces, $new_text);
    }

    function sort($a,$b){
        return strlen($b)-strlen($a);
    }

}