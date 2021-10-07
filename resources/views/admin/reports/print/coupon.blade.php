<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{trans('admin.coupon')}}</title>
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
            <th>{{trans('admin.coupon_code')}}</th>
            <th>{{trans('admin.discount_rate')}}</th>
            <th>{{trans('admin.user_famous_rate')}}</th>
            <th>{{trans('admin.total_orders')}}</th>
            <th>{{trans('admin.coupon_checked_count')}}</th>
            <th>{{trans('admin.total_discounts')}}</th>
            <th>{{trans('admin.pending_orders')}}</th>
            <th>{{trans('admin.pending_orders_price')}}</th>
            <th>{{trans('admin.confirm_orders')}}</th>
            <th>{{trans('admin.confirm_orders_price')}}</th>
            <th>{{trans('admin.user_famous_total_price')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($excel_coupons as $excel_coupon)
            <tr>

                <td>{{$excel_coupon['coupon_code']}}</td>
                <td>{{$excel_coupon['discount_rate']}}</td>
                <td>{{$excel_coupon['user_famous_rate']}}</td>
                <td>{{$excel_coupon['total_orders']}}</td>
                <td>{{$excel_coupon['checked_count']}}</td>
                <td>{{$excel_coupon['total_discounts']}}</td>
                <td>{{$excel_coupon['pending_orders']}}</td>
                <td>{{$excel_coupon['pending_orders_price']}}</td>
                <td>{{$excel_coupon['confirm_orders']}}</td>
                <td>{{$excel_coupon['confirm_orders_price']}}</td>
                <td>{{$excel_coupon['user_famous_total_price']}}</td>


            </tr>
        @endforeach


        </tbody>
    </table>
</div>

</body>
</html>
