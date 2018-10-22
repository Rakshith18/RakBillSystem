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
<p align="center">GST No: 603655986</p>
<hr>

    <p>Customer Name : {{$report[0]->customer_name}}&nbsp;{{$report[0]->customer_address}}</p>

    <p>GST Number : {{$report[0]->gst_number}}</p>

    <p>Invoice Number : 
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
        <td>{{$all->sale_quantity}}</td>
        <td>{{$all->sell_price}}
        <td>{{$all->tax}}</td>
        <td>{{$all->tax_amt}}</td>
        <td>{{$all->price}}</td>
    </tr>
    @endforeach
    
        <tr>
        <td colspan="7"><strong> Grand Total </strong> </td>
        <td>
            <?php $total=0;
                  $net_value=0;
                  $gst=0;
                  $cgst=0;
             ?>
            @if($report)
                @foreach($report as $s)
                    @php
                        $price = $s->price;
                        $total += $price;

                         $net_value += $s->sell_price * $s->sale_quantity;

                         $gst += $s->tax_amt;
                      
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
<p align="center">Net Value : Rs. {{$net_value}}</p>
<p align="center">CGST : Rs. {{$gst/2}}</p>
<p align="center">SGST : Rs. {{$gst/2}}</p>
<p align="center">IGST : -</p>
<p align="center">Total To Be Paid : Rs. {{$total}}</p>
<hr>
<p align="center">Thank You... Visit Again...</p>

</body></html>


