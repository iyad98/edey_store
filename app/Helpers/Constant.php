<?php
use App\Models\Setting;

function round_digit() {
    return 3;
}
function role() {
    return [
        'admin_role' => 1 ,
        'pharmacy_role' => 2
    ];
}

function getUploadsPath($path = "") {
    return public_path()."/uploads/".$path;
}
function getUploadsThumbPath($path = "") {
    return public_path()."/uploads/thumbs/".$path;
}


function get_currency()
{
    return trans('api.currency');
}

function get_effective_value_unit()
{
    return "mg";
}



function get_path_default_image()
{
    return url('') . "/uploads/users/defullt.png";
}

function get_general_path_default_image($path)
{
    return url('') . "/uploads/$path/defullt.png";
}

function get_default_image()
{
    return "defullt.png";
}

function status_user()
{
    $status = [
        1 => ['title' => trans('admin.active'), 'class' => 'm-badge--success'],
        0 => ['title' => trans('admin.not_active'), 'class' => 'm-badge--danger']
    ];
    return $status;
}

function status_coupon()
{
    $status = [
        1 => ['title' => trans('admin.active_coupon'), 'class' => 'm-badge--success'],
        0 => ['title' => trans('admin.not_active_coupon'), 'class' => 'm-badge--danger']
    ];
    return $status;
}

function stock_status()
{
    $status = [
        1 => ['title' => trans('admin.stock_available'), 'class' => 'm-badge--success'],
        0 => ['title' => trans('admin.not_stock_available'), 'class' => 'm-badge--danger']
    ];
    return $status;
}


function trans_role_admin()
{
    $status = [
        1 => ['title' => trans('admin.admin_role', [], app()->getLocale()), 'class' => 'm-badge--success'],
        2 => ['title' => trans('admin.pharmacy_role', [], app()->getLocale()), 'class' => 'm-badge--info'],
    ];
    return $status;
}

function trans_category_type()
{
    $status = [
        1 => ['title' => trans('admin.medicine_type', [], app()->getLocale()), 'class' => 'm-badge--success'],
        2 => ['title' => trans('admin.cosmetics_type', [], app()->getLocale()), 'class' => 'm-badge--info'],
    ];
    return $status;
}

function company_type()
{
    $status = [
        1 => ['title' => trans('admin.local'), 'class' => 'm-badge--success'],
        2 => ['title' => trans('admin.import'), 'class' => 'm-badge--danger']
    ];
    return $status;
}

function is_stripe_type()
{
    $status = [
        1 => ['title' => trans('admin.yes'), 'class' => 'm-badge--success'],
        0 => ['title' => trans('admin.no'), 'class' => 'm-badge--danger']
    ];
    return $status;
}



function notification_status() {
    return [
        'orders' => 1 ,
        'approve_bank_transfer' => 2,
        'reject_bank_transfer' => 3,
        'notify_admin' => 4 ,
        'approve_return_order' => 5 ,
        'reject_return_order' => 6 ,
    ];
}

function order_status_class()
{
    return [
        0 => "status-pending",
        1 => "status-processing",
        2 => "status-awaiting-shipment",
        3 => "status-on-hold",
        4 => "status-completed",
        5 => "status-cancelled",
        6 => "status-refunded",
        7 => "status-failed",
        8 => "status-refunded",
        9 => "status-refunded",
        10 => "status-refunded",
    ];
}


function order_status()
{
    return [
        'in_manufacturing' => 0,
        'charged_up' => 1,
        'charged_at_sea' => 2,
        'at_the_harbour' => 3,
        'in_the_warehouse' => 4,
        'delivered' => 5,

    ];
}

function trans_order_status()
{
    return [
        0 => trans('api.in_manufacturing'),
        1 => trans('api.charged_up'),
        2 => trans('api.charged_at_sea'),
        3 => trans('api.at_the_harbour'),
        4 => trans('api.in_the_warehouse'),
        5 => trans('api.delivered'),
    ];
}


function get_date_note_orignal_order_status()
{
    return [
        0 => "note_in_manufacturing",
        1 => "note_charged_up",
        2 => "note_charged_at_sea",
        3 => "note_at_the_harbour",
        4 => "note_in_the_warehouse",
        5 => "note_delivered",


    ];
}

function trans_orignal_order_status()
{
    return [
        0 => trans('api.new'),
        1 => trans('api.processing'),
        2 => trans('api.finished'),
        3 => trans('api.failed'),
        4 => trans('api.canceled')
    ];
}

function orignal_order_status()
{
    return [
        'new' => 0,
        'processing' => 1,
        'finished' => 2,
        'failed' => 3,
        'canceled'=>4,
    ];
}

function get_date_orignal_order_status()
{
    return [
        0 => "new",
        1 => "processing",
        2 => "finished",
        3 => "failed",
        4 => "canceled",


    ];
}

function get_date_order_status()
{
    return [
        0 => "in_manufacturing",
        1 => "charged_up",
        2 => "charged_at_sea",
        3 => "at_the_harbour",
        4 => "in_the_warehouse",
        5 => "delivered",

    ];
}

function wallet_log_status() {
    return [
        'order_point' => 1 ,
        'buy_order' => 2 ,
        'failed_order' => 3,
        'update_order_up' => 4 ,
        'update_order_down' => 5 ,
        'change_order_to_lock_status' => 6 ,
        'change_order_to_active_status' => 7 ,
    ];
}
function notification_admin_status() {
    return [
        'new_order' => 1 ,
    ];
}


function get_list_excepts_url_device_id() {
    $excepts_url_device_id = [url('api/user/register') , url('api/user/login') , url('api/user/update') ,
        url('api/user/info') ,url('api/user/products') ];

    return $excepts_url_device_id;
}

function month2str($id){
    switch ($id){
        case 1: return trans('month.january');
        case 2: return trans('month.february');
        case 3: return trans('month.march');
        case 4: return trans('month.april');
        case 5: return trans('month.may');
        case 6: return trans('month.june');
        case 7: return trans('month.july');
        case 8: return trans('month.august');
        case 9: return trans('month.september');
        case 10: return trans('month.october');
        case 11: return trans('month.november');
        case 12: return trans('month.december');
    }

}