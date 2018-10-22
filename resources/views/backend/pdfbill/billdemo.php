<!doctype html>

<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{asset('images/user.png')}}" rel="icon" type="image/x-icon"/>
    <link href="{{asset('images/user.png')}}" rel="shortcut icon" type="image/x-icon"/>
    <title>@Yield('title')</title>

    <!-- Bootstrap -->
    <link href="{{asset('backend/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
   <!--  <link href="{{asset('backend/vendors/bootstrap-4.1.3/dist/css/bootstrap.min.css')}}" rel="stylesheet"> -->
    <!-- Font Awesome -->
    <link href="{{asset('backend/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{asset('backend/build/css/custom.min.css')}}" rel="stylesheet">
  
    <style type="text/css">
        .error {
            color: red;
        }
        .selector-for-some-widget {
             box-sizing: content-box;
        }
    </style>
    @Yield('css')
</head>

<body>
<div class="container body">

<p align="center"><strong>R2k Grocery System (RGS)</strong></p>
<p align="center">MG Road, Mangaluru - 575001</p>
<p align="center">Phone No: +91  </p>
<p align="center">GST No: 603655986</p>
<hr>

    <p>Customer Name : {{$report[0]->customer_name}}&nbsp;{{$report[0]->customer_address}}</p>

    <p> <div class="form-group">
                                <label for="gst">GST Number :</label>
                                <input type="number" class="form-control" id="gst" name="gst" placeholder="GST Number">
                                <span class="error"><b>
                                         @if($errors->has('gst'))
                                            {{$errors->first('gst')}}
                                         @endif</b></span>
                            </div></p>

    <p>Invoice Number : </p>
    <p>Date : <?php
        date_default_timezone_set('Asia/Kolkata');
        echo date("d-m-Y h:i:s");?></p> 
   
<hr>

<table border="0" align="center">
    <thead>
    <tr>
        <th>Sl.No.</th>
        <th>HSN Code</th>
        <th>Particulars</th>
        <th>Quantity</th>
        <th>Price per Unit</th>
        <th>Tax Rate %</th>
        <th>Tax Value</th>
        <th>Total Price</th>
    </tr>
    </thead><tr></tr>
    <tbody>
    <tr>
         <?php $i=1 ?>
        @foreach($report as $all)

        <td>{{$i++}}</td>
        <td>{{$all->product_id}}</td>
        <td>{{$all->name}}</td>
        <td>{{$all->quantity}}</td>
        <td>{{$all->sell_price}}</td>
        <td>{{$all->tax}}</td>
        <td>{{$all->price}}</td>
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
<p align="center">Net Value : </p>
<p align="center">CGST : </p>
<p align="center">SGST : </p>
<p align="center">IGST : </p>
<p align="center">Total To Be Paid : </p>
<hr>
<p align="center">Thank You... Visit Again...</p>
</div>
</body>