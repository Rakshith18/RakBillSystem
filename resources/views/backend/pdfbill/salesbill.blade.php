<!doctype html>    

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

<!-- <link href="{{asset('backend/vendors/bootstrap-4.1.3/dist/css/bootstrap.min.css')}}" rel="stylesheet"> -->
</head>
<body>
<p align="center"><strong>R2k Grocery System (RGS)</strong></p>
<p align="center">MG Road, Mangaluru - 575001</p>
<p align="center">Phone No: +91  </p>
<p align="center">PAN No: 603655986</p>
<hr>

<p>Date : <?php
date_default_timezone_set('Asia/Kolkata');
echo date("d-m-Y h:i:s");?></p> <p style="align:right;">Bill No :</p>

<hr>
<table border="0" align="center">
    <thead>
    <tr>
        <th>Sl.No.</th>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Tax %</th>
        <th>Price</th>
    </tr>
    </thead><tr></tr>
    <tbody>
    <?php $i=1 ?>
    @foreach($report as $all)
    <tr>
        <td>{{$i++}}</td>
        <td>{{$all->name}}</td>
        <td>{{$all->quantity}}</td>
        <td>{{$all->tax}}</td>
        <td>{{$all->price}}</td>
    </tr>
    @endforeach
    
        <tr><td></td>
        <td colspan="3"><strong> Grand Total </strong> </td>
        <td>
            <?php $total=0 ?>
            @if($report)
                @foreach($report as $s)
                    @php
                        $price = $s->price;
                        $total += $price;
                    @endphp
                @endforeach
                Rs. {{$total}}
            @endif
        </td>
    </tr>
    </tbody>
</table>
<br>

<hr>
<p align="center">Thank You... Visit Again...</p>

</body></html>


