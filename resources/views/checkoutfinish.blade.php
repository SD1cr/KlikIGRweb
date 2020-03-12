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
    <link href="{{ url('../resources/assets/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>
    <link href="{{ url('../resources/assets/css/style.css') }}" rel="stylesheet"/>
    <link href="{{ url('../resources/assets/css/owl.carousel.css') }}" rel="stylesheet"/>
    <link href="{{ url('../resources/assets/css/owl.theme.css') }}" rel="stylesheet"/>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>

</head>
<body>
{{--@if (Auth::guest()) id="logindialog" @endif--}}
<nav class="navbar navbar-primary navbar-fixed-top container admin_view2 col-md-12" style="background-color: white;box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);padding-top: 0px; padding-bottom: 0px;z-index: 999;">
    {{--@if (\Auth::user('users_admin')->role == 1)--}}
        {{--<li><a href="{{ url('/dashboard') }}">Dashboard</a></li>--}}
        {{--<li><a href="{{ url('/members') }}">Manage Members</a></li>--}}
        {{--<li><a href="{{ url('/emails') }}">Manage Emails</a></li>--}}
    {{--@endif--}}
    {{--<div style="background-color: #c0392b; min-height: 8px;" class="col-lg-12"></div>--}}
    <a href="{{ url('/dashboard') }}"><img  class="col-lg-2" style="float: left" width="100px" src="{{ url('../resources/assets/img/logo.png') }}"/></a>
            <ul class="nav navbar-nav navbar-right" style="float: right; position: relative;z-index: 9999;margin-right: 100px;" >
                @if (!\Auth::user('users_admin'))
                    {{--<li><a href="{{ url('/admin') }}">Login</a></li>--}}
                    <li><a href="admin" style="color: black;">Login</a></li>
                @else
                    <li class="dropdown" style="margin-right: -100px;">
                        <a href="#" class="dropdown-toggle" id="userMenu" data-toggle="dropdown" role="button" aria-expanded="false" style="color: black">Selamat Datang, {{ \Auth::user('users_admin')->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            {{--<li><a href="{{ url('/logout_admin') }}"><i class="fa fa-sign-out" style="font-size:larger"></i> &nbsp; Logout</a></li>--}}
                            <li><a href="logout_admin"><i class="fa fa-sign-out" style="font-size:larger"></i> &nbsp; Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>

    <ul class="nav navbar-nav">
        @if (\Auth::user('users_admin')->role == 1 || \Auth::user('users_admin')->role == 2)
            <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
            <li><a href="{{ url('/emails') }}">Manage Emails</a></li>
            <li><a href="{{ url('/realisasi') }}">Realisasi Pesanan</a></li>
            <li><a href="{{ url('/member') }}">Manage Member</a></li> 
            @if (\Auth::user('users_admin')->role == 3)
                <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
            @endif
            @if (\Auth::user('users_admin')->role == 1)

            <li><a href="{{ url('/adminlist') }}">Manage Admin</a></li>
            @endif
        @endif
    </ul>

</nav>

@yield('content')


<div style="text-align: center; font-size:larger; color:black; margin-bottom: 10px">
    Indogrosir &copy; 2017
</div>
<!-- Scripts -->

<script type="text/javascript">
    var getProductDialogURL = '{{ url('getproductdialog') }}';
    var getCSVDownloadURL = '{{ url('downloadcsv') }}';
    var getCartDialogURL = '{{ url('getcartdialog') }}';
    var addCartURL = '{{ url('addcart') }}';
    var reloadCartURL = '{{ url('reloadcart') }}';
    var deleteCartURL = '{{ url('deletecart') }}';
    var updateCartURL = '{{ url('updatecart') }}';
    var getLoginMemberDialogURL = '{{ url('getlogindialog') }}';
    var getValidLoginUrl = '{{ url('loginajax') }}';
    var reloadLoginURL = '{{ url('reloadlogin') }}';
    var getOptionAddressDialogURL = '{{ url('getaddressdialog') }}';

</script>
{{--<script src="{{ url('../resources/assets/js/jquery-1.9.1.js') }}"></script>--}}
<script src="{{ url('../resources/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ url('../resources/assets/js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('../resources/assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ url('../resources/assets/js/accounting.min.js') }}"></script>
<script src="{{ url('../resources/assets/js/jquery.smartWizard.min.js') }}"></script>

<script src="{{ url('../resources/assets/js/dashboard.js') }}"></script>
<script src="{{ url('../resources/assets/js/product.js') }}"></script>
<script src="{{ url('../resources/assets/js/cart.js') }}"></script>
<script src="{{ url('../resources/assets/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ url('../resources/assets/js/bootstrap-hover-tabs.js') }}"></script>
<script src="{{ url('../resources/assets/js/login.js') }}"></script>
<script src="{{ url('../resources/assets/js/bootstrap-editable.min.js') }}"></script>


<script type="text/javascript" type="text/javascript">
    $(function () {
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

        $("#cartdialog").on('click', function () {
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

        $('.hengki').hover(function() {
            jQuery(this).find('.div').stop(true, true).delay(200).fadeIn();
        }, function() {
            jQuery(this).find('.div').stop(true, true).delay(200).fadeOut();
        });
    });


    $(document ).ready(function() {
        cartReload();
    });
</script>

@yield('scripts')

<style>
    *{
        font-size: 14px !important;
    }

    .login-page {
        width: 360px;
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
