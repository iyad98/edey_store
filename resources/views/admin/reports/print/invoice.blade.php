<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{trans('admin.invoice')}}</title>
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
            <th>DocNum</th>
            <th>LineNum</th>
            <th>ItemCode</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Currency</th>
            <th>DiscPrcnt</th>
            <th>WhsCode</th>
            <th>UseBaseUn</th>
            <th>VatGroup</th>
            <th>UnitMsr</th>
            <th>NumPerMsr</th>
            <th>LineTotal</th>
            <th>CogsAcct</th>
            <th>OcrCode2</th>
        </tr>
        </thead>
        <tbody>
        @foreach($excel_orders as $excel_order)
            <tr>

                <td>{{$excel_order['DocNum']}}</td>
                <td>{{$excel_order['LineNum']}}</td>
                <td>{{$excel_order['ItemCode']}}</td>
                <td>{{$excel_order['Description']}}</td>
                <td>{{$excel_order['Quantity']}}</td>
                <td>{{$excel_order['price']}}</td>
                <td>{{$excel_order['Currency']}}</td>
                <td>{{$excel_order['DiscPrcnt']}}</td>
                <td>{{$excel_order['WhsCode']}}</td>
                <td>{{$excel_order['UseBaseUn']}}</td>
                <td>{{$excel_order['VatGroup']}}</td>
                <td>{{$excel_order['UnitMsr']}}</td>
                <td>{{$excel_order['NumPerMsr']}}</td>
                <td>{{$excel_order['LineTotal']}}</td>
                <td>{{$excel_order['CogsAcct']}}</td>
                <td>{{$excel_order['OcrCode2']}}</td>


            </tr>
        @endforeach


        </tbody>
    </table>
</div>

</body>
</html>
