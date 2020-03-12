<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <title>Klikindogrosir</title>

    <link href="{{ url('../resources/assets/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ url('../resources/assets/css/bootstrap.min.css') }}" rel="stylesheet"/>
    <link href="{{ url('../resources/assets/css/bootstrap.css') }}" rel="stylesheet"/>
    <link href="{{ url('../resources/assets/css/bootstrap-select.min.css') }}" rel="stylesheet"/>
    <link href="{{ url('../resources/assets/css/bootstrap-editable.css') }}" rel="stylesheet"/>
    <link href="{{ url('../resources/assets/css/igr.css') }}" rel="stylesheet"/>
    <link href="{{ url('../resources/assets/css/style.css') }}" rel="stylesheet"/>
    <link href="{{ url('../resources/assets/css/owl.carousel.css') }}" rel="stylesheet"/>
    <link href="{{ url('../resources/assets/css/owl.theme.css') }}" rel="stylesheet"/>

</head>
<body>
<nav class="navbar navbar-default" style="background-color: #F6F6F6;">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
                <a class="navbar-brand" href="#">Prototype</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest()) <?php //<li><a href="{{ url('/auth/register') }}">Register</a></li> ?>
                <li><a href="{{ url('/auth/login') }}">Login</a></li>
                @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" id="userMenu" data-toggle="dropdown" role="button" aria-expanded="false">Selamat Datang, {{ Auth::user()->name }} <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('/chpass') }}"><i class="fa fa-key" style="font-size:larger"></i> &nbsp; Ganti Kata Sandi</a></li>
                        <li><a href="{{ url('/auth/logout') }}"><i class="fa fa-sign-out" style="font-size:larger"></i> &nbsp; Logout</a></li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

@yield('content')
<div class="navbar-nav"></div>

<div style="text-align: center; font-size:larger; color:black; margin-bottom: 10px">
    Indogrosir &copy; 2016
</div>

<script type="text/javascript">
</script>

<script src="{{ url('../resources/assets/js/jquery-1.9.1.js') }}"></script>
<script src="{{ url('../resources/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ url('../resources/assets/js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('../resources/assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ url('../resources/assets/js/product.js') }}"></script>
<script src="{{ url('../resources/assets/js/cart.js') }}"></script>
<script src="{{ url('../resources/assets/js/bootstrap-editable.min.js') }}"></script>

</body>
</html>