<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{$title}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <style>
        body {
            font-size: 11px;
            font-weight: 500;
        }
    </style>
</head>
<body onload="window.print()">

<div >
    <div class="row">
        <div class="col-sm-5"></div>
        <div class="col-sm-4">
            <h2>{{$title}}</h2>
        </div>
        <div class="col-sm-4"></div>
    </div>
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-6">
            <h5>{{$sub_title}}</h5>
        </div>
        <div class="col-sm-2"></div>
    </div>


    <table class="table table-bordered">
        <thead>
        <tr>
            <th>{{trans('admin.date')}}</th>
            <th>{{trans('admin.user_name')}}</th>
            <th>{{trans('admin.order_number')}}</th>
            <th>{{trans('admin.shipping_policy')}}</th>
            <th>{{trans('admin.products_count')}}</th>
            <th>{{trans('admin.order_price_before_discount')}}</th>
            <th>{{trans('admin.total_discount_coupon')}}</th>
            <th>{{trans('admin.price_after_discount_coupon_')}}</th>
            <th>{{trans('admin.shipping')}}</th>
            <th>{{trans('admin.tax')}}</th>
            <th>{{trans('admin.receiving_fees')}}</th>
            <th>{{trans('admin.total_price')}}</th>
            <th>{{trans('admin.shipping_type')}}</th>
            <th>{{trans('admin.shipping_date')}}</th>
            <th>{{trans('admin.payment')}}</th>

        </tr>
        </thead>
        <tbody>
        @foreach($excel_orders as $excel_order)
            <tr>

                <td>{{$excel_order['created_at']}}</td>
                <td>{{$excel_order['user_name']}}</td>
                <td>{{$excel_order['id']}}</td>
                <td>{{$excel_order['shipping_policy']}}</td>
                <td>{{$excel_order['products_count']}}</td>
                <td>{{$excel_order['price_after']}}</td>
                <td>{{$excel_order['total_coupon_price']}}</td>
                <td>{{$excel_order['price_after_discount_coupon']}}</td>
                <td>{{$excel_order['shipping']}}</td>
                <td>{{$excel_order['tax']}}</td>
                <td>{{$excel_order['cash_fees']}}</td>
                <td>{{$excel_order['total_price']}}</td>
                <td>{{$excel_order['shipping_company_name']}}</td>
                <td>{{$excel_order['shipment_at']}}</td>
                <td>{{$excel_order['payment_name']}}</td>


            </tr>
        @endforeach


        </tbody>
    </table>
</div>

</body>
</html>
