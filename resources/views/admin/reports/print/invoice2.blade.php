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
            <th>DocEntry</th>
            <th>DocType</th>
            <th>Handwrtten</th>
            <th>DocDate</th>
            <th>DocDueDate</th>
            <th>CardCode</th>
            <th>DocTotal</th>
            <th>DocCur</th>
            <th>Ref1</th>
            <th>Ref2</th>
            <th>Comments</th>
            <th>JrnlMemo</th>
            <th>SlpCode</th>
            <th>DiscPrcnt</th>
        </tr>
        </thead>
        <tbody>
        @foreach($excel_orders as $excel_order)
            <tr>

                <td>{{$excel_order['DocNum']}}</td>
                <td>{{$excel_order['DocEntry']}}</td>
                <td>{{$excel_order['DocType']}}</td>
                <td>{{$excel_order['Handwrtten']}}</td>
                <td>{{$excel_order['DocDate']}}</td>
                <td>{{$excel_order['DocDueDate']}}</td>
                <td>{{$excel_order['CardCode']}}</td>
                <td>{{$excel_order['DocTotal']}}</td>
                <td>{{$excel_order['DocCur']}}</td>
                <td>{{$excel_order['Ref1']}}</td>
                <td>{{$excel_order['Ref2']}}</td>
                <td>{{$excel_order['Comments']}}</td>
                <td>{{$excel_order['JrnlMemo']}}</td>
                <td>{{$excel_order['SlpCode']}}</td>
                <td>{{$excel_order['DiscPrcnt']}}</td>


            </tr>
        @endforeach


        </tbody>
    </table>
</div>

</body>
</html>
