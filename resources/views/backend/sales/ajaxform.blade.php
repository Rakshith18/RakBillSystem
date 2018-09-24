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
                <input type="hidden" name="quantity[{{$i}}]" value="{{$sc->quantity}}">
                <input type="hidden" name="price[{{$i}}]" value="{{$sc->price}}">
                <input type="hidden" name="tax[{{$i}}]" value="{{$sc->tax}}">
                <input type="hidden" name="customer_name[{{$i}}]" value="{{$sc->customer_name}}">
                <input type="hidden" name="customer_address[{{$i}}]" value="{{$sc->customer_address}}">
                <input type="hidden" name="sales_status[{{$i}}]" value="{{$sc->sales_status}}">
                @php($i++)
            @endforeach
            <input type="hidden" name="total_product" value="{{$i}}">
            <button type="submit"  class="btn btn-success" target="_blank" onclick="return confirm('Do You Print Out The Bill ?')"><i class="fa fa-pen"></i> Update Sales Bucket</button>
        </form>
    </div>
    <div class="col-md-4">
       
        <a class="btn btn-danger" id="clearbucket" onclick="return confirm('Do You want to Clear Out The Bucket ?')" href="{{route('salescart.clearbucket')}}"><i class="fa fa-bolt"></i> Clear Sales Bucket</a>
          
    </div>
</div>

<!-- <script type="text/javascript">
    $(document).ready(function () {

        $('#clearbucket').on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('action');
                var post = $(this).attr('method');
                var data = $(this).serialize();
                $.ajax({
                    url: url,
                    type: post,
                    data: data,
                    success: function (data) {
                        refreshproduct();
                        readsales();
                        ajaxform();
                        var m = "<div class='alert alert-info alert-block'> <button type='button' class='close' data-dismiss='alert'> x </button>" + data.success_message + "</div>";
                        // alert(data.success_message);
                        $('.resp').html(m);
                        document.getElementById("#clearbucket").reset();
                    }
                });
            });
    });

</script> -->
