<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{asset('images/user.png')}}" rel="icon" type="image/x-icon"/>
    <link href="{{asset('images/user.png')}}" rel="shortcut icon" type="image/x-icon"/>
    <title>R2k System Admin | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
    <link rel="stylesheet" href="{{asset('backend/login/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('backend/login/css/bootstrap-responsive.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('backend/login/css/matrix-login.css')}}"/>
    <link href="{{asset('backend/login/font-awesome/css/font-awesome.css')}}" rel="stylesheet"/>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    <style type="text/css">
        .error {
            color: white;
        }
    </style>
</head>
<body style="background-color: rgba(220,247,255,0);">
<div id="loginbox">
    @if(Session::has('success_message'))
        <div class="alert alert-success alert-block">
             <button type="button" class="close" data-dismiss="alert"> x </button>
           <strong> {{ Session::get('success_message') }} </strong>
        </div>
    @endif
    @if(Session::has('error_message'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert"> x </button>
            {{ Session::get('error_message') }}
        </div>
    @endif
            <form id="loginform" class="form-vertical" method="post" action="{{route('user.check')}}">
                {!! csrf_field() !!}
                
                 <div class="control-group normal_text"> <h3><img src="{{asset('images/user.png')}}" height="100" width="100" alt="Logo"/></h3></div>

                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lg"><i class="icon-user"> </i></span>
                            <input type="text" placeholder="Username" name="username" required="" />
                        </div>
                        <span class="error">
                    @if($errors->has('username'))
                        {{$errors->first('username')}}
                    @endif
                </span>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                         <div class="main_input_box">
                            <span class="add-on bg_lr"><i class="icon-lock"> </i></span>
                            <input type="password" placeholder="Password" name="password" required="" />
                        </div>
                         <span class="error">
                    @if($errors->has('password'))
                        {{$errors->first('password')}}
                    @endif
                </span>
                    </div>
                </div>
                <div class="form-actions">
                    <span class="pull-left"><a href="{{route('reset.password')}}" class="flip-link btn btn-info" id="to-recover">Forgot password ?</a></span>
                    <span class="pull-right"><button type="submit" class="btn btn-success">Login
                    </button></span>
                </div>
            </form>
            <form id="recoverform" action="#" class="form-vertical">
                <p class="normal_text">Enter your e-mail address below and we will send you instructions how to recover a password.</p>
                
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lo"><i class="icon-envelope"></i></span><input type="text" placeholder="E-mail address" />
                        </div>
                    </div>
               
                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link btn btn-success" id="to-login">&laquo; Back to login</a></span>
                    <span class="pull-right"><a class="btn btn-info"/>Recover</a></span>
                </div>
            </form>
        </div>
        
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/matrix.login.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script> 
    </body>

</html>



















