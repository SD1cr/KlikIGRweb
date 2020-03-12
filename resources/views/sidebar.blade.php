<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <title>Prototype</title>

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

</head>
<body>
{{--@if (Auth::guest()) id="logindialog" @endif--}}
<nav class="navbar navbar-primary navbar-fixed-top" style=" background-color: white;">
    <div style="background-color: #c0392b; min-height: 8px;" class="col-lg-12"></div>
    <div style="margin-top: 0px; vertical-align: middle" class="col-lg-12">
        <a href="{{ url('/product') }}"><img  class="col-lg-2" style="float: left" width="100px" src="{{ url('../resources/assets/img/logo.png') }}"/></a>

        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li style="background-color: #2980b9; min-height: 85px; width: 500px;"><a style="font-size:x-large !important; color: white" href="#">&nbsp; METODE PENGIRIMAN</a></li>
                <li style="background-color: white; min-height: 85px;  font-size:larger !important; width: 780px;"><a style="font-size:x-large !important;" href="#">&nbsp; KONFIRMASI PESANAN</a></li>
            </ul>
        </div>
    <div style="background-color: #2980b9; min-height: 8px;" class="col-lg-12"></div>

</nav>

@yield('content')

<div style="background-color: #C20000; min-height: 8px; margin-top: 20px;" class="col-xs-12"></div>
<div style="margin-top: 5px;" class="col-md-offset-2 col-lg-12">
    <a href="#" class="col-lg-2"  style="font-size: small; text-align:center; margin-top:20px; color:black;"><i class="fa fa-cc-discover"></i>&nbsp; Cicilan</a>
    <a href="#" class="col-lg-2" style="font-size: small; text-align:center; margin-top:20px; color:black;"><i class="fa fa-plane"></i>&nbsp; Gratis Pengiriman</a>
    <a href="#" class="col-lg-2" style="font-size: small; text-align:center; margin-top:20px; color:black;"><i class="fa fa-cc-paypal"></i>&nbsp; Cara Bayar</a>
    <a href="#" class="col-lg-2" style="font-size: small; text-align:center; margin-top:20px; color:black;"><i class="fa fa-apple"></i>&nbsp; Sponsor</a>
</div>
<div style="background-color: #9a9a9a; min-height: 3px; margin-top: 20px" class="col-md-offset-2 col-xs-8"></div>
        <!-- Scripts -->

<script type="text/javascript">
    var getProductDialogURL = '{{ url('getproductdialog') }}';
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
<script src="{{ url('../resources/assets/js/jquery-1.9.1.js') }}"></script>
<script src="{{ url('../resources/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ url('../resources/assets/js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('../resources/assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ url('../resources/assets/js/accounting.min.js') }}"></script>
<script src="{{ url('../resources/assets/js/jquery.smartWizard.min.js') }}"></script>

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

    $( document ).ready(function() {
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
