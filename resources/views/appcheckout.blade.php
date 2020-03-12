<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <title>KlikIndogrosir</title>   

    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Lato" />
    <link rel='stylesheet' href='//fonts.googleapis.com/css?family=Lato' type='text/css' />
    <link href="{{ secure_url('css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ secure_url('css/bootstrap.min.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/bootstrap.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/bootstrap-select.min.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/jquery.pinlogin.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/bootstrap-editable.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/igr.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/style.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/owl.carousel.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/owl.theme.css') }}" rel="stylesheet"/>

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
{{--@if (Auth::guest()) id="logindialog" @endif--}}
<nav class="navbar navbar-primary navbar-fixed-top" style="background-color: white;box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);padding-top: 0px; padding-bottom: 0px;z-index: 999;">
    {{--<div style="background-color: #c0392b; min-height: 8px;" class="col-lg-12"></div>--}}
    {{--<div style="margin-top: 5px;margin-bottom:5px; padding-left: 0px;padding-right: 0px; vertical-align: middle" class="col-lg-12">--}}
        {{--<a href="{{ url('/product') }}"><img  class="col-xs-6 col-lg-2" style="float: left" width="50%" src="{{ secure_url('img/logo.png') }}"/></a>--}}
    {{--</div>    --}}
    <ul class="col-sm-6 col-lg-3 nav navbar-nav navbar-left col-md-4" style="padding-left: 60px;">
        <li class="active"><a style="padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;" href="{{ secure_url('/product') }}"><img  src="{{ url('img/logo.png') }}"/></a></li>
    </ul>
</nav>

@yield('content')

<footer id="myFooter" style="margin-top: 20px;background:#0079c2;">
    <div class="container" style="margin-bottom: 20px;">
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
    var getAddressChangeDialog = '{{ url('changeaddress') }}';

</script>
<script src="{{ secure_url('js/jquery-1.9.1.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.js"></script>     

<script src="{{ secure_url('js/bootstrap.min.js') }}"></script>
<script src="{{ secure_url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ secure_url('js/owl.carousel.min.js') }}"></script>
<script src="{{ secure_url('js/accounting.min.js') }}"></script>
<script src="{{ secure_url('js/jquery.smartWizard.min.js') }}"></script>
<script src="{{ secure_url('js/jquery.pinlogin.js') }}"></script>

<script src="{{ secure_url('js/dashboard.js') }}"></script>
<script src="{{ secure_url('js/product.js') }}"></script>
<script src="{{ secure_url('js/cart.js') }}"></script>
<script src="{{ secure_url('js/bukuAlamat.js') }}"></script>
<script src="{{ secure_url('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ secure_url('js/bootstrap-hover-tabs.js') }}"></script>
<script src="{{ secure_url('js/login.js') }}"></script>
<script src="{{ secure_url('js/bootstrap-editable.min.js') }}"></script>


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

        $("#changeaddressdialog").on('click', function () {
            $('#myModal').modal('show');
            getChangeAddress();
        });

        $("#contactChoice1").on('click', function () {
            $('#diantar').css({'display':'none'});
            $('#diambil').css({'display':''});

        });

        $("#contactChoice2").on('click', function () {
            $('#diambil').css({'display':'none'});
            $('#diantar').css({'display':''});
        });

        $('.hengki').hover(function() {
            jQuery(this).find('.div').stop(true, true).delay(200).fadeIn();
        }, function() {
            jQuery(this).find('.div').stop(true, true).delay(200).fadeOut();
        });

        $('.txtref').keypress(function(e){
            const regex = RegExp('[A-Za-z0-9_/-]+'); 
            if (!regex.test(e.key) && e.key != 'backspace') {
                e.preventDefault();
            }
        });

    });

    $( document ).ready(function() {
        cartReload();
    });

    $("img").lazyload({
        effect : "fadeIn"
    });

    //    $(".confirm-create").on('show.bs.modal', function(e) {
//        alert("HENGKI SAYANG OLA");
//        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href') + '?nomorpo=' + $("#nomorpo").val());
//    });

</script>


@if (session('opencart'))
    <script>
        $(function () {
            $('#myModalVerif').modal('show');

//            getCartDetail();
        });
    </script>
@endif

@yield('scripts')

<style>
    *{
        font-size: 14px;
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
    @media screen and (min-width: 992px) {
        .modal-lg {
            width: 1024px; /* New width for large modal */
        }
    }
</style>

<div class="modal fade confirm-create" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Konfirmasi Pemesanan</h4>
            </div>

            <div class="modal-body">
                <p>Apakah anda Yakin Untuk Melakukan Checkout ?</p>
            </div>

            <div class="modal-footer">
                {{--<a href="{{ url('/checkout') }}" class="btn btn-primary btn-ok"><i class="fa fa-check-square-o"></i> Checkout</a>--}}
                <button id = "btn_checkout" class="btn btn-primary btn-ok"><i class="fa fa-check-square-o"></i> Checkout</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
    
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

{{--<div id="myModal" class="modal fade" role="dialog">--}}
    {{--<div class="modal-dialog modal-lg">--}}
        {{--<div class="modal-content flat">--}}
            {{--<div class="modal-header">--}}
                {{--<div id="modal-error"></div>--}}
                {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                {{--<h4 style="margin-bottom:0px" id="myModalLabel" class="font-14"></h4>--}}
            {{--</div>--}}
            {{--<div id="modal-core" class="modal-body" style='text-align: center'></div>--}}
            {{--<div id="modal-error" class="modal-footer"><br/></div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}

</body>

<script text="javascript">
    $("#btn_checkout").click(function(){   
        var no_po = $("#nomorpo").val();
        var ongkir = $(".kirim:checked").val();
        if(no_po == null || no_po == ""){
            var no_po = 0;
            no_po=no_po+1;
            window.location.href = "{{url('checkout')}}" + "/blank" + "/" + ongkir;
        }else{
            window.location.href = "{{url('checkout')}}" + "/" + no_po + "/" + ongkir;
        }
    });
    $(document).on('click', '.btn-ok', function(e) {
        $(this).attr("disabled", true).removeClass("btn-ok");
//        $("#confirm-form").submit();
    });
 
    $(document).on('click', '#btnreloadotp', function(){
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
            type: "POST",
            url: "ResendOTP",
            success:function(msg){
                if(msg == 0){
                    $("#alert_max5").show();
                    $("#btnreload").hide();
                    $("#alert_failed").hide();
                }else{
                    $("#alert_failed").hide();
                    $("#btnreload").hide();
                    var pincode =  $('.loginpin').pinlogin();
                    pincode.enable();
                    var timeleft = 300;
                    var downloadTimer = setInterval(function(){
                        var m = Math.floor(timeleft / 60);
                        var s = timeleft % 60;

                        m = m < 10 ? '0' + m : m;
                        s = s < 10 ? '0' + s : s;
                        document.getElementById('countdown').innerHTML = m + ':' + s;

                        timeleft -= 1;
                        if(timeleft >= 0){
                            var pincode = $('.loginpin').pinlogin({
                                fields : 6,
                                hideinput : false,
                                complete : function(pin){
                                    $.ajax({
                                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                                        url:'cekotp',
                                        type : 'POST',
                                        data: {
                                            'pincode' : pin
                                        },
                                        success:function(msg){
                                            if (msg == 0) {
                                                $("#alert_failed").show();
                                            } else {
                                                $("#alert_success").show();
                                                $("#myModalVerif").hide().removeClass('hide');
                                                window.location.href = "product";
                                            }
                                        }
                                    });
                                }
                            });
                        }else{
                            $("#btnreload").show();
                            clearInterval(downloadTimer);
                            document.getElementById("countdown").innerHTML = "Waktu Habis";
                            var pincode =  $('.loginpin').pinlogin();
                            pincode.disable();
                        }
                    }, 1000);
                }
            }

        });

    });


    //    var timeleft = 10;

    var timeleft = 300;
    var downloadTimer = setInterval(function(){
        var m = Math.floor(timeleft / 60);
        var s = timeleft % 60;

        m = m < 10 ? '0' + m : m;
        s = s < 10 ? '0' + s : s;
        document.getElementById('countdown').innerHTML = m + ':' + s;
        timeleft -= 1;

//        document.getElementById("countdown").innerHTML = timeleft + " seconds remaining";
//        timeleft -= 1;
        if(timeleft >= 0){
            var pincode = $('.loginpin').pinlogin({
                fields : 6,
                hideinput : false,
                complete : function(pin){
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                        url:'cekotp',
                        type : 'POST',
                        data: {
                            'pincode' : pin
                        },
                        success:function(msg){
                            if (msg == 0) {
                                $("#alert_failed").show();
                            } else {
                                $("#alert_success").show();
                                $("#myModalVerif").hide().removeClass('hide');
                                window.location.href = "product";
                            }
                        }
                    });
                }
            });
        }else{
            $("#btnreload").show();
            clearInterval(downloadTimer);
            document.getElementById("countdown").innerHTML = "Waktu Habis";
            var pincode =  $('.loginpin').pinlogin();
            pincode.disable();
        }
    }, 1000);


    $(function() {
        $('.input1').on('keypress', function(e) {
            if (e.which == 32)
                return false;
        });
    });

    $(document).on('click', '.btn-ok', function(e) {
        $(this).attr("disabled", true).removeClass("btn-ok");
    })
       
</script>
</html>
