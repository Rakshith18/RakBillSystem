@extends('backend.layouts.master')
@section('title')
    Product Stock Update Page
@endsection
@section('css')

@endsection
<!-- page content -->
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Stock Management </h3>
                </div>
                <div class="title_right">
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right top_search">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group top_search" >
                            <div class="input-group">
                                 <form action="{{route('stock.clear',$product->id)}}" method="post">
                                    {{ csrf_field()}}
                                    <button type="submit" class="btn btn-danger" ><i class="fa fa-bolt"></i> Clear Stock</button>
                                 </form>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group top_search">
                            <div class="input-group">
                                <a href="{{route('product.list')}}" class="btn btn-success"><i class="fa fa-eye"></i> View Product</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           <div class="clearfix"></div>
            @if(Session::has('success_message'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert"> x </button>
                    {{ Session::get('success_message') }}
                </div>
            @endif
            @if(Session::has('error_message'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert"> x </button>
                    {{ Session::get('error_message') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Update Stock of Product</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Settings 1</a>
                                        </li>
                                        <li><a href="#">Settings 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <form action="{{route('stock.update',$product->id)}}" method="post">
                                {{ csrf_field()}}
                                 <div class="form-group">
                                    <label for="stock">Product Name</label>
                                    <input type="text" value="{{$product->name}}" class="form-control"  placeholder="" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="stock">Stock Already Available *</label>
                                    <input type="number" value="{{$product->stock}}" class="form-control"  placeholder="" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="stock">Stock To be Added *</label>
                                    <input type="number"  class="form-control" id="stock" name="stock" placeholder="Enter Stock to be Updated" min="1">
                                    <span class="error"><b>
                                         @if($errors->has('stock'))
                                                {{$errors->first('stock')}}
                                         @endif</b></span>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="submit" name="btnCreate" class="btn btn-primary" ><i class="fa fa-pencil"></i> Update Stock</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
@endsection

@section('script')

@endsection