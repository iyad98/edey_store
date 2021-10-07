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
            <th>{{trans('admin.sku')}}</th>
            <th>{{trans('admin.product_name')}}</th>
            <th>{{trans('admin.order_number')}}</th>
            <th>{{trans('admin.quantity')}}</th>
            <th>{{trans('admin.order_status')}}</th>
            <th>{{trans('admin.date')}}</th>
            <th>{{trans('admin.payment_method_')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($excel_orders as $excel_order)
            <tr>

                <td>{{$excel_order['sku']}}</td>
                <td>{{$excel_order['product_name']}}</td>
                <td>{{$excel_order['order_id']}}</td>
                <td>{{$excel_order['quantity']}}</td>
                <td>{{$excel_order['order_status']}}</td>
                <td>{{$excel_order['date']}}</td>
                <td>{{$excel_order['payment_name']}}</td>


            </tr>
        @endforeach


        </tbody>
    </table>
</div>

</body>
</html>
