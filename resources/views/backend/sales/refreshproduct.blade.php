<option value="" selected>-- Select Product --</option>
@foreach($product as $m)
    <option value="{{$m->id}}">Code : {{$m->code}} {{$m->name}} Stock : {{$m->stock}} &nbsp;  Price:{{$m->sell_price}}</option>
@endforeach