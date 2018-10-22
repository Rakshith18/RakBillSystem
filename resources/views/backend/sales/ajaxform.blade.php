<div class="row">
    <div class="col-md-4">
        <a onclick="printorder()" type="submit" class="btn btn-info" target="_blank"><i class="fa fa-print"></i> Print Bill</a>
    </div>
    
    <div class="col-md-4">
        <form action="{{route('save.sales')}}" method="post">
            {{csrf_field()}}
            @php($i = 0)
            @foreach($salescart as $sc)
                <input type="hidden" name="product_id[{{$i}}]" value="{{$sc->product_id}}">
                <input type="hidden" name="customer_id[{{$i}}]" value="{{$sc->customer_id}}">
                <input type="hidden" name="sale_quantity[{{$i}}]" value="{{$sc->sale_quantity}}">
                <input type="hidden" name="price[{{$i}}]" value="{{$sc->price}}">
                <input type="hidden" name="tax_amt[{{$i}}]" value="{{$sc->tax_amt}}">
                <input type="hidden" name="sales_status[{{$i}}]" value="{{$sc->sales_status}}">
                @php($i++)
            @endforeach
            <input type="hidden" name="total_product" value="{{$i}}">
            <button type="submit" id="upb" class="btn btn-success" target="_blank" onclick="return confirm('Do You Print Out The Bill ?')"><i class="fa fa-pen"></i> Update Sales Bucket</button>
        </form>
    </div>
    <div class="col-md-4">
       
        <a class="btn btn-danger" id="clearbucket" onclick="return confirm('Do You want to Clear Out The Bucket ?')" href="{{route('salescart.clearbucket')}}"><i class="fa fa-bolt"></i> Clear Sales Bucket</a>
          
    </div>
</div>

<!-- <script type="text/javascript">
    $(document).ready(function () {

        $('#upb').on('submit', function (e) {
                e.preventDefault();
                var url = $(this).attr('action');
                var post = $(this).attr('method');
                var data = $(this).serialize();
                $.ajax({
                    url: url,
                    type: post,
                    data: data,
                    success: function (data) {
                        printorder();
                                             
                        document.getElementById("btnSave").reset();
                    }

                });
                
                $("#customer_name").attr('readonly','true');
                $("#customer_address").attr('readonly','true');

            });
    });

</script>  -->
