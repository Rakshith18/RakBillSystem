
<table width="100%" class="table table-striped table-bordered table-hover" id="categorytable">
    <thead>
    <tr>
        <th>Sl.No.</th>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Tax % </th>
        <th>Total Price</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php $i=1 ?>
    @foreach($sales as $pc)
        <tr>
            <th> {{$i++}}</th>
            <td class="col-xs-3">{{$pc->name}} </td>
            <td > {{$pc->quantity}}</td>
            <td >{{$pc->tax}}</td>
            <td >{{$pc->price}} </td>
            <td>
                {{--<form action="{{route('salescart.delete' ,[$pc->id,$pc->product_id])}}" method="post">
                    <input type="hidden" name="_method" value="DELETE">
                    {{ csrf_field()}}
                    <button type="submit" class="btn btn-info" ><i class="fa fa-pencil"></i></button></td>
                    <td><button type="submit" class="btn btn-danger" onclick="return confirm('are you sure to delete?')" ><i class="fa fa-trash-o"></i></button></td>
                </form>--}}
             <div class="row">
                <div class="col-md-5">
                    <a href="" class="btn btn-info"><i class="fa fa-pencil"></i></a>
                </div>
                <div class="col-md-5">
                    <form action="{{route('salescart.delete',[$pc->id,$pc->product_id])}}" method="post">
                    <input type="hidden" name="_method" value="DELETE">
                        {{ csrf_field()}}
                        <button type="submit" class="btn btn-danger" id="btnDel" onclick="return confirm('are you sure to delete?')" ><i class="fa fa-trash-o"></i></button>
                    </form>
                </div>
               
            </div></td>
        </tr>
    @endforeach
  
     <tr>
        <td colspan="4"><strong>Grand Total</strong></td>
        <td colspan="2"><strong>
            <?php $total=0 ?>
                @if($sales)
                    @foreach($sales as $s)
                        @php
                        $price = $s->price;
                        $total += $price;
                        @endphp
                    @endforeach
                    {{$total}}
                @endif</strong>
        </td>
       
    </tr>

    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function () {

    $('#btnDel').on('submit', function (e) {
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
                        // readname();
                        ajaxform();
                        var m = "<div class='alert alert-info alert-block'> <button type='button' class='close' data-dismiss='alert'> x </button>" + data.success_message + "</div>";
                        // alert(data.success_message);
                        $('.resp').html(m);

                        document.getElementById("btnDel").reset();
                    }

                });
            });
        });
</script>