<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <title>KlikIndogrosir</title>    

    <link rel="stylesheet" type="text/css" href="{{ secure_url('css/font.css')}}" />
    <link rel='stylesheet' href="{{ secure_url('css/font.css')}}" type='text/css' />
    <link href="{{ secure_url('css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-MfvZlkHCEqatNoGiOXveE8FIwMzZg4W85qfrfIFBfYc= sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    {{--<link href="{{ secure_url('css/bootstrap.min.css') }}" rel="stylesheet"/>--}}
    <link href="{{ secure_url('css/bootstrap.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/bootstrap-select.min.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/bootstrap-editable.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/jasny-bootstrap.min.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/igr.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/profil.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/pace.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/slider.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/preloader.css') }}" rel="stylesheet"/>

    <link href="{{ secure_url('css/sidebar.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/tabs.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/reorder.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/style.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/owl.carousel.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/owl.theme.css') }}" rel="stylesheet"/>
    <link href="{{secure_url('css/select2.min.css')}}" rel="stylesheet">
    <link href="{{secure_url('css/overlay-bootstrap.css')}}" rel="stylesheet">
    <link href="{{secure_url('css/overlay-bootstrap.min.css')}}" rel="stylesheet">

    <link href="{{secure_url('css/build.css')}}" rel="stylesheet">
    <link href="{{secure_url('css/fileinput.min.css')}}" rel="stylesheet">
    <link href="{{secure_url('css/nouislider.min.css')}}" rel="stylesheet">
    {{--<link href="{{ secure_url('css/category.css')}}" rel="stylesheet" >--}}
    {{--<link href="{{ secure_url('css/style2.css')}}" rel="stylesheet" > <!-- CSS reset -->--}}

    <style type="text/css">
        @media screen and (max-width: 600px) {
            ul {
                list-style: none;
                padding: 0;
            }

            ul .inner {
                overflow: hidden;
                display: none;
            }

            ul li {
                margin: 0;
            }

            ul li a {
                text-decoration:none;
                height: 38px;
                font-size: 22px;
                font-family: Arial, metapronorm;
                width: 100%;
                display: block;
                background: white;
                color: #1E62C3;
                padding: .75em;
                transition: background .3s ease;
                background-repeat: no-repeat;
                background-position: center;
                border: 1px solid gray;
                border-radius: 0.15em;
                border-width: 0px 0px 1px 0px;
            }

            ul li a:hover{
                background-color:#f5f6fa;
            }

            ul li a span.toggle {
                background-size: 40px 40px;
                /*background-image: url("../img/uparrow.png");*/
            }

            #top {
                border-top: 1px solid gray;
            }


            /*
            ul li a.toggle:hover {
              background-color: #E9F9F9;
            } */

            ul.inner li>a {
                padding-left: 2em;
            }

            ul.inner .inner li>a {
                padding-left: 3em;
            }

            ul.inner .inner .inner li>a {
                padding-left: 4em;
            }

            ul li a.expanded {
                /*background-image: url("../img/downarrow.png");*/
                background-repeat: no-repeat;
                background-position: center;
                background-size: 40px 40px;
            }

        }
    </style>

    <style media="screen">
        #modalLogin{
            border-radius: 0px;
            font-family: "Arial", cursive, sans-serif, Bold;
            position: center;
        }
        .modal-content-login{
            border-radius: 0px;
            width: 300px;
            height: auto;
            position: center;
        }
        #modal_body_login{
            height: auto;
            padding-bottom: 40px;
            position: center
        }

    </style>
	
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-75927950-1', 'auto');
		ga('send', 'pageview');
</script>          
</head>
<body>
<div class="navbar navbar-primary navbar-fixed-top" style="background:#0079c2;min-height: 30px;">
    <a style="margin-left: 60px;float:left;padding-top:5px;" href="{{ url('/buy') }}"><i style='color:white' class="glyphicon glyphicon-map-marker"></i><span style="color:white; font-size: small !important;">&nbsp; Dikirim dari Indogrosir Kemayoran</span></a>
    <a style="margin-right: 60px;float:right;padding-top:5px;" href="{{ url('/buy') }}"><i style='color:white' class="glyphicon glyphicon-earphone"></i><span style="color:white; font-size: small !important;">&nbsp; 021-698-30063 &nbsp;|&nbsp;&nbsp;</span><i style='color:white' class="glyphicon glyphicon-envelope"></i><span style="color:white; font-size: small !important;">&nbsp; cs.klik@indogrosir.co.id</span></a>
</div>
<nav class="navbar navbar-primary navbar-fixed-top" style="background-color: white;box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);padding-top: 0px; padding-bottom: 0px;margin-top: 30px;min-height: 60px">
    {{--<div id="navbarCollapse" class="collapse navbar-collapse" style="margin-top: 5px;">--}}      
    <ul class="hidden-xs col-sm-6 col-lg-3 nav navbar-nav navbar-left col-md-4" style="padding-left: 60px;">
        <li class="active"><a style="padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;" href="{{ secure_url('/product') }}"><img  src="{{ url('img/logo.png') }}"/></a></li>
        <li class="hidden-xs col-sm-6 col-lg-2">
            <a id="dLabel" role="button" data-toggle="dropdown" style="margin-top:0px; color: #c0392b;">
                <i class="fa fa-bars" style="font-size:25px !important; right: 10px;"></i>
            </a>
            <ul class="dropdown-menu multi-level div" role="menu" aria-labelledby="dropdownMenu" style="padding-top: 0px;padding-bottom: 0px;">
                {!! $divdeptkat !!}
            </ul>
        </li>

    </ul>

    <nav id="myNavmenu" class="navmenu navmenu-default navmenu-fixed-left offcanvas" role="navigation">
        @if (Auth::guest())
            <a href="{{ url('/login') }}" style="background-color: #337AB7; padding-top: 15px;padding-bottom: 20px;margin-top: 0px;margin-bottom: 0px;" class="navmenu-brand"><i style='color:white; font-size: large !important;' class="fa fa-user"></i><span style="color:white; font-size: large !important;font-weight: bold">&nbsp; Login / Daftar</span></a>
            {!! $divdeptkatmobile !!}
            <a href="{{ url('/buy') }}"><i style='color:black' class="fa fa-shopping-cart"></i><span style="color:black; font-size: small !important;">&nbsp; Cara Belanja</span></a>
            <a href="{{ url('/reg') }}"><i style='color:black' class="fa fa-registered"></i><span style="color:black; font-size: small !important;">&nbsp; Cara Pendaftaran</span></a>
            <a href="{{ url('/info') }}"><i style='color:black' class="fa fa-phone"></i><span style="color:black; font-size: small !important;">&nbsp; Hubungi Kami</span></a>

        @else
            <?php
            $mem = Auth::user()->nama;
            $arr = explode(' ',trim($mem));
            ?>
            <a style="background-color: #337AB7; padding-top: 15px;padding-bottom: 15px;margin-top: 0px;margin-bottom: 0px;" class="navmenu-brand"><span style="color:white; font-size: large !important;font-weight: bold">&nbsp;  Selamat Datang, {{ ucfirst(strtolower($arr[0])) }} !</span></a>
            <ul class="nav navmenu-nav">
                {{--<li class="active"><a href="#">Home</a></li>--}}
                {{--<li><a href="#">Link</a></li>--}}
                {{--<li><a href="#">Link</a></li>--}}
                {!! $divdeptkatmobile !!}
                <li class="divider navbar-login-session-bg"></li>
                <li><a href="{{ url('/profile') }}"><i style='color:black' class="fa fa-user"></i>&nbsp; Profil User</a></li>
                <li class="divider"></li>
                <li><a href="{{ url('/bukualamat') }}"><i style='color:black' class="fa fa-file"></i>&nbsp; Buku Alamat</a></li>
                <li class="divider"></li>
                <li><a href="{{ url('/history') }}"><i style='color:black' class="fa fa-history"></i>&nbsp; History Pesanan</a></li>
                <li class="divider"></li>
                {{--@if (\Auth::User()->type_id == 1)--}}
                    <li><a href="{{ url('/uploadorder') }}"><i style='color:black' class="fa fa-list"></i>&nbsp; Upload Order</a></li>
                    <li class="divider"></li>
                {{--@endif--}}        
                <li><a href="{{ url('/logout') }}"><i style='color:black' class="fa fa-sign-out"></i>&nbsp; Sign Out</a></li>
            </ul>
        @endif


    </nav>
    <div class="visible-xs col-sm-6 col-lg-3 navbar navbar-default" style="background-color: #ffffff">       
        <button type="button" class="navbar-toggle" style="float:left" data-toggle="offcanvas" data-target="#myNavmenu" data-canvas="body">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="{{ url('/product') }}"><img style='width:50%;' src="{{ url('img/logo.png') }}"/></a>   

        @if (Auth::guest())
            <td>
                <a href="#" class="cartdialog kigr-hover"><img height="46px" style="padding:1%;" src="{{ url('img/cart1.png') }}"/><label style="padding-right: 10px; padding-top:1%;height:100%;width:100%;" class="cart-bar label label-danger"></label></a>
            </td>
        @else
            <td>
                <a href="#"  class="cartdialog kigr-hover"><img height="50px" style="padding:1%;" src="{{ url('img/cart1.png') }}"/><label style="padding-right: 10px; padding-top:1%;height:100%;width:100%;" class="cart-bar label label-danger"></label></a>
            </td>
        @endif
    </div>

    <ul class="nav navbar-nav col-lg-5" style="padding-top: 10px;padding-right: 25px;padding-left: 45px;margin-left: 0px;margin-right: 0px;">
        <form class="nav navbar-nav col-lg-12" method="get" action="{{ url('/list') }}">
            <div class="row">
                <div class="input-group" style="width:100%;">
                    <input type="hidden" name ="ord" value="@if(isset($_GET['ord'])){{$_GET['ord']}}@endif"/>
                    <input type="text" name ="key" id="key" class="form-control" placeholder="Cari Produk ..." value="@if(!empty($_GET['key'])){{$_GET['key']}}@endif">
                <span class="input-group-btn flat">
                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
                </span>
                </div>
            </div>
        </form>
    </ul>
    <ul class="hidden-xs col-sm-6 col-lg-3 nav navbar-nav navbar-right" style="margin-right: 0px;margin-top: 15px;">
        @if (Auth::guest())     
            {{--<td>--}}
                {{--<a style="color: black" href="#" id="div_modal_login" data-toggle="modal" data-target="#modalLogin1"><i style="color: white" class="fa fa-user"></i></a>--}}
            {{--</td>--}}
            {{--<td>--}}
                {{--<a href="#" class="cartdialog kigr-hover"><img height="46px" style="padding:1%;" src="{{ url('img/cart1.png') }}"/><label style="padding-right: 10px; padding-top:1%;height:100%;width:100%;" class="cart-bar label label-danger"></label></a>--}}
                {{--<a href="#" id="hallo"></a>--}}
            {{--</td>--}}
            {{--<td>--}}
                {{--<a style="color: black" href="#" id="div_modal_login" data-toggle="modal" data-target="#modalLogin"><img height="50px" style="padding:2%;" src="{{ url('img/user3.png') }}"/>Masuk</a>--}}
            {{--</td>--}}
            {{--<td>--}}
                {{--<a style="color: black" href="{{ url('/register') }}"><img height="50px" style="padding:2%;" src="{{ url('img/register.png') }}"/>Daftar</a>--}}
            {{--</td>--}}
            <td>
                <a href="#" id="hallo" style='margin-top: 12px;'></a>
                <a href="#" class="cartdialog kigr-hover" style='margin-right: 30px;'><label style="padding-right: 10px; padding-top:1%;height:100%;width:100%;" class="cart-bar label label-danger"></label><i style='color:#0079c2;font-size: large!important;' class="glyphicon glyphicon-shopping-cart"></i><span style="color:#0079c2;">&nbsp; Keranjang</span></a>
            </td>
            <td>
                <a type="button" id="div_modal_login" type=button data-toggle="modal" data-target="#modalLogin" style='border-color: #00a0df;margin-right: 15px;' class="btn btn-default"><span style="color:#0079c2">Masuk</span></a>
            </td>
            <td>
                <a type="button" href="{{ url('/register') }}" style='' class="btn btn-primary">Daftar</a>
            </td>
        @else
            <td>
                <a href="#" class="cartdialog kigr-hover" style='margin-right: 30px;'><label style="padding-right: 10px; padding-top:1%;height:100%;width:100%;" class="cart-bar label label-danger"></label><i style='color:#0079c2;font-size: large!important;' class="glyphicon glyphicon-shopping-cart"></i><span style="color:#0079c2;">&nbsp; Keranjang</span></a>
            </td>
            <td>
                <?php
                $mem = Auth::user()->nama;
                $arr = explode(' ',trim($mem));
                ?>
                <li class="dropdown" style="
                margin-right: 10px;
                ">
                    <a href="#" class="dropdown-toggle" id="userMenu" data-toggle="dropdown" role="button" aria-expanded="false" style="color: black; padding-top: 0px;padding-bottom: 0px;padding-left: 0px;padding-right: 0px;"></label><i style='color:#0079c2;font-size: large!important;' class="glyphicon glyphicon-user"></i><span style="color:#0079c2;">Hallo!, {{ ucfirst(strtolower($arr[0])) }}</span><span style='color:black' class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="navbar-login">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <a class="text-center" style="color:#0079c2;">
                                            <span style="color:#0079c2;">Selamat Datang, {{ ucfirst(strtolower($arr[0])) }} !</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="divider navbar-login-session-bg"></li>
                        @if (\Auth::User()->flag_verif == 1)
                            <li><a href="{{ url('/profile') }}"><i style='color:black' class="fa fa-user"></i>&nbsp; Profil User</a></li>
                        @else
                            <li><a href="{{ url('/profile') }}"><i style='color:black' class="fa fa-user"></i>&nbsp; Profil User<span style="float:right" class="badge badge-light">1</span></a></li>
                        @endif

                        <li class="divider"></li>
                        <li><a href="{{ url('/bukualamat') }}"><i style='color:black' class="fa fa-file"></i>&nbsp; Buku Alamat</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ url('/history') }}"><i style='color:black' class="fa fa-history"></i>&nbsp; History Pesanan</a></li>
                        <li class="divider"></li>
                        {{--@if (\Auth::User()->type_id == 1)--}}
                            <li><a href="{{ url('/uploadorder') }}"><i style='color:black' class="fa fa-list"></i>&nbsp; Upload Order</a></li>
                            <li class="divider"></li>
                        {{--@endif--}}
                        <li><a href="{{ url('/logout') }}"><i style='color:black' class="fa fa-sign-out"></i>&nbsp; Sign Out</a></li>
                    </ul>
                </li>
            </td>
        @endif
    </ul>

    {{--</div>--}}
</nav>

@yield('content')
<div class="modal fade-scale" id="modalLogin" role="dialog">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content" id="modal-content-login">
            <div class="modal-header" style="border-bottom-width: 0px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="modal_body_login">
                <div hidden class="alert alert-danger" id="alert_danger_login">
                    <p>Username or Password is false</p>
                </div>
                <div hidden class="alert alert-warning" id="alert_warning_login">
                    <p>Please insert username or password</p>
                </div>
                <div hidden class="alert alert-warning" id="alert_activ_login">
                    <p>Silakan Aktivasi Akun ada, cek email Anda !</p>
                </div>
                <form class="form-horizontal" role="form" method="post">
                    <input id="token" type="hidden" name="_token" value="csrf_token()">
                    <div class="panel-heading">
                        <img style="display: block; margin-left: auto; margin-right: auto" width="50%" src="{{ secure_url('img/logo.png') }}"/>
                    </div>
                    <div class="panel-heading" style="text-align: center">
                        <span style="font-size: large !important; font-weight: 500">Masuk ke Akun</span>
                    </div>
                    {{--<div style="text-align: center" class="alert alert-danger">--}}
                        {{--<span style="text-align: center">Mohon maaf untuk sementara website tidak bisa untuk melakukan transaksi, <br>Dikarenakan sedang dalam perbaikan</span>--}}
                    {{--</div>--}}
                    <div class="login-page">
                        <input type="text" id="email" name="email" placeholder="Email" required="">
                        <input type="password" name="password" id="password" placeholder="Password" autocomplete="off" onkeypress="handle(event)">
                        <input type="button" id="btn_login" class='btn btn-primary flat' style='height: 100%; margin-top: 10px;' value="MASUK">
                        <a href="{{ secure_url('/password/email') }}" class="btn btn-danger flat" style='height: 100%; margin-top: 10px;'>Lupa Kata Sandi ?</a>
                        <p class="message">Belum punya akun? <a href="{{ secure_url('/register') }}">Daftar disini</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<footer id="myFooter" style="margin-top: 20px;background:#0079c2;">
    <div class="hidden-xs container" style="margin-bottom: 20px;">
        {{--<div class="row">--}}
        <div class="col-sm-3">
            <h5 style="margin-bottom: 15px;">Bantuan</h5>
            <ul>
                <li><a style="color:white" href="{{ url('/term') }}">Syarat & Ketentuan</a></li>
                <li><a style="color:white" href="{{ url('/buy') }}">Cara Belanja</a></li>
                <li><a style="color:white" href="{{ url('/reg') }}">Cara Pendaftaran</a></li>
                <li><a style="color:white" href="{{ url('/policy') }}">Kebijakan</a></li>
                <li><a style="color:white" href="{{ url('/faq') }}">FAQ</a></li>
            </ul>
        </div>
        <div class="col-sm-3">
            <h5 style="margin-bottom: 15px;">Info Indogrosir</h5>
            <ul>
                <li><a style="color:white" href="{{ url('/info') }}">Tentang Klik Indogrosir</a></li>
                <li><a style="color:white" href="{{ url('/location') }}">Lokasi Gerai</a></li>
            </ul>
        </div>
        <div class="col-sm-3">
            <h5 style="margin-bottom: 15px;">Hubungi Kami</h5>
            <ul>
                <p style="color:white">Kantor Pusat<br />
                    Jl. Ancol Barat I No.9-10,&nbsp; Ancol&nbsp; Pademangan - Jakarta Utara 14430&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
                    T. 698-30063 , F. 691-8240
                    <br/> Email:  cs.klik@indogrosir.co.id
                </p>
            </ul>
        </div>
        {{--</div>--}}
    </div>
    <div class="second-bar" style="background: #173d5d;">
        <div class="container">
            <h2 class="logo"><a href="#">Copyright © 2017 KlikIndogrosir </a></h2>
            <div class="social-icons">
                <a href="http://facebook.com/indogrosir.mitrausahaterpercaya/" class="facebook"><i class="fa fa-facebook" style="font-size: 24px !important;"></i></a>
                <a href="http://indogrosir.co.id/" class="google"><i class="fa fa-info-circle" style="font-size: 24px !important;"></i></a>
            </div>
        </div>
    </div>
</footer>
<!-- Scripts -->


<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.js"></script>

{{--<script src="{{ secure_url('js/bootstrap.min.js') }}"></script>--}}
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
<script src="{{ secure_url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/jasny-bootstrap.min.js') }}"></script>
<script src="{{ url('js/expandcollapse.js') }}"></script>
<script src="{{ secure_url('js/owl.carousel.min.js') }}"></script>
<script src="{{ secure_url('js/accounting.min.js') }}"></script>
<script src="{{ secure_url('js/jquery.smartWizard.min.js') }}"></script>
<script src="{{ secure_url('js/jquery.preloader.min.js') }}"></script>

<script type="text/javascript">

    if(typeof jQuery!=='undefined'){  
        console.log('jQuery Loaded');
    }
    else{
        console.log('not loaded yet');
    }

    var getProductDialogURL = '{{ secure_url('getproductdialog') }}';
    var getCartDialogURL = '{{ secure_url('getcartdialog') }}';
    var addCartURL = '{{ secure_url('addcart') }}';
    var reloadCartURL = '{{ secure_url('reloadcart') }}';
    var deleteCartURL= '{{ secure_url('deletecart') }}';
    var deleteALLCartURL = '{{ secure_url('deleteallcart') }}';
    var updateCartURL = '{{ secure_url('updatecart') }}';
    var getLoginMemberDialogURL = '{{ secure_url('getlogindialog') }}';
    var getValidLoginUrl = '{{ secure_url('loginajax') }}';
    var reloadLoginURL = '{{ secure_url('reloadlogin') }}';
    var getOptionAddressDialogURL = '{{ secure_url('getaddressdialog') }}';
    var getHistoryDialogURL = '{{ secure_url('gethistorydialog') }}';
</script>



<script src="{{ secure_url('js/product.js') }}"></script>
<script src="{{ secure_url('js/cart.js') }}"></script>
<script src="{{ secure_url('js/history.js') }}"></script>
<script src="{{ secure_url('js/notify.js') }}"></script> 
<script src="{{ secure_url('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ secure_url('js/bootstrap-slider.js') }}"></script>
<script src="{{ secure_url('js/bukuAlamat.js') }}"></script>
<script src="{{ secure_url('js/fileinput.min.js') }}"></script>
<script src="{{ secure_url('js/login.js') }}"></script>
<script src="{{ secure_url('js/bootstrap-editable.min.js') }}"></script>
<script src="{{ secure_url('js/select2.min.js')}}"></script>
<script src="{{ secure_url('js/pace.min.js') }}"></script>
<script src="{{ secure_url('js/bootstrap-number-input.js')}}"></script>
<script src="{{ secure_url('js/nouislider.min.js')}}"></script>



<script type="text/javascript" type="text/javascript">




    $(function () {
        @if(Request::is('bukualamat'))
            REinit();
        @endif
        $('#myModal').modal({
            keyboard: true,
            backdrop: "static",
            show: false,
            toggle: true
        }).on('show', function () {
        });
        $(".productdialog").on('click', function () {
            $('#myModal').modal('show');
            getProductDetail($(this).data('id'));
        });

        $(".cartdialog").on('click', function () {
            $('#myModal').modal('show');
            getCartDetail();
        });

        $(".logindialog").on('click', function () {
            $('#myModal').modal('show');
            getLoginMember();
        });

        $("#addressdialog").on('click', function () {
            $('#myModal').modal('show');
            getOptAddress();
        });

        $(".TrHeader").find('a[data-id]').on('click', function () {
            $('#myModal').modal('show');
            getHistoryDetail($(this).data('id'));
        });

        $(".ReOrder").find('a[data-id]').on('click', function () {
            $('#myModal').modal('show');
            getHistoryReorder($(this).data('id'));
        });

//        $('#after').bootstrapNumber();

        $('.content').click(function(){
            $(this).find('input[type=radio]').prop('checked', true);
        });

        $('.hengki').hover(function() {
            jQuery(this).find('.div').stop(true, true).delay(200).fadeIn();
        }, function() {
            jQuery(this).find('.div').stop(true, true).delay(200).fadeOut();
        });
    });

    $("img").lazyload({
        effect : "fadeIn"
    });
       
    $( document ).ready(function() {
        cartReload();
    });

    $("#ex2").slider({});

    $('.someBlock').preloader({
    });

    //    $('.form-control').on('focus blur', function (e) {
    //        $(this).parents('.form-group').toggleClass('focused', (e.type === 'focus' || this.value.length > 0));
    //    }).trigger('blur');

    $(document).ready(function(){
        $("a").on('click', function(event) {

            if (this.hash !== "") {
                event.preventDefault();
                var hash = this.hash;

                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 800, function(){

                    window.location.hash = hash;
                });
            }
        });
    });




</script>

@if (session('opencart'))
    <script>
        $(function () {
            $('#myModal').modal('show');
            getCartDetail();
        });
    </script>
@endif

@yield('scripts')

<style>
    *{
        font-size: 14px !important;
    }

    .login-page {
        /*width: 360px;*/  
        padding: 0 0 0;
        margin: auto;
    }

</style>

<style type="text/css">
    @media screen and (min-width: 992px) {
        .modal-dialog {
            width: 700px; /* New width for default modal */
        }
        .modal-sm {
            width: 450px; /* New width for small modal */
        }
        .modal-xs {
            width: 350px; /* New width for small modal */
        }
    }
    .fade-scale {
        transform: scale(0);
        opacity: 0;
        -webkit-transition: all .20s linear;
        -o-transition: all .20s linear;
        transition: all .20s linear;
    }

    .fade-scale.in {
        opacity: 1;
        transform: scale(1);
    }

    @media screen and (min-width: 992px) {
        .modal-lg {
            width: 1024px; /* New width for large modal */
        }
    }
</style>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content flat">
            <div class="modal-header">
                <div id="modal-error"></div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 style="margin-bottom:0px" id="myModalLabel" class="font-14"></h4>
            </div>
            <div id="modal-core" class="modal-body" style='text-align: center'></div>
            <div id="modal-error" class="modal-footer"><br/></div>
        </div>
    </div>
</div>

</body>
</html>
