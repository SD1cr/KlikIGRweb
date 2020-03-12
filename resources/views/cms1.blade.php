<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Klikindogrosir</title>


    <link href="{{ secure_url('css/bootstrap.min.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/bootstrap-theme.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/elegant-icons-style.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/font-awesome.min.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/stylecms.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/style-responsive.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/select2.min.css') }}" rel="stylesheet"/>

    <link href="{{ secure_url('css/bootstrap.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/bootstrap-select.min.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/bootstrap-editable.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/igr.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/style.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/owl.carousel.css') }}" rel="stylesheet"/>
    <link href="{{ secure_url('css/owl.theme.css') }}" rel="stylesheet"/>
    <link href="{{secure_url('css/fileinput.min.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>

    <!-- include summernote css/js -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
    <!-- include summernote css/js -->

</head>

<body>
<!-- container section start -->
<section id="container" class="">
    <!--header start-->

    <header class="header linkedin-bg">
        <div class="toggle-nav">
            <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
        </div>

        <!--logo start-->
        <a href="{{ url('/dashboard') }}"><img  class="col-lg-2" style="float: left;margin-top: 10px;" width="100px" src="{{ secure_url('img/cmslogo.png') }}"/></a>
        <!--logo end-->

        {{--<div class="nav search-row" id="top_menu">--}}
            {{--<!--  search form start -->--}}
            {{--<ul class="nav top-menu">--}}
                {{--<li>--}}
                    {{--<form class="navbar-form">--}}
                        {{--<input class="form-control" placeholder="Search" type="text">--}}
                    {{--</form>--}}
                {{--</li>--}}
            {{--</ul>--}}
            {{--<!--  search form end -->--}}
        {{--</div>--}}

        <div class="top-nav notification-row">
            <!-- notificatoin dropdown start-->
            <ul class="nav pull-right top-menu">

                <!-- task notificatoin start -->

                <!-- task notificatoin end -->
                <!-- inbox notificatoin start-->

                <!-- inbox notificatoin end -->
                <!-- alert notification start-->

                <!-- alert notification end-->
                <!-- user login dropdown start-->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" id="userMenu" data-toggle="dropdown" role="button" aria-expanded="false" style="color: white">Selamat Datang, {{ \Auth::user('users_admin')->name }} <span class="caret"></span></a>
                    <ul class="dropdown-menu extended logout">
                        <div class="log-arrow-up"></div>
                        <li>

                            <a href="logout_admin"><i class="icon_key_alt"></i> Log Out</a>
                        </li>

                    </ul>
                </li>
                <!-- user login dropdown end -->
            </ul>
            <!-- notificatoin dropdown end-->
        </div>
    </header>
    <!--header end-->

    <!--sidebar start-->
    <aside>
        <div id="sidebar" class="nav-collapse ">
            <!-- sidebar menu start-->
            <ul class="sidebar-menu">
                @if (\Auth::user('users_admin')->role == 1 || \Auth::user('users_admin')->role == 2)
                    <li class="">
                        <a href="{{ url('/dashboard') }}">
                            <i class="icon_house_alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    {{--<li class="">--}}
                    {{--<a href="{{ url('/emails') }}">--}}
                    {{--<i class="icon_mail_alt"></i>--}}
                    {{--<span>Manage Emails</span>--}}
                    {{--</a>--}}
                    {{--</li>--}}

                    <li class="sub-menu">
                        <a href="javascript:;" class="">
                            <i class="icon_mail_alt"></i>
                            <span>Manage Emails</span>
                            <span class="menu-arrow arrow_carrot-right"></span>
                        </a>
                        <ul class="sub">
                            <li><a class="" href="{{ url('/emails') }}">View Emails</a></li>
                            <li><a class="" href="{{ url('/createmail') }}">Create New Email</a></li>
                        </ul>
                    </li>

                    <li class="">
                        <a href="{{ url('/realisasi') }}">
                            <i class="icon_document_alt"></i>
                            <span>Realisasi Pesanan</span>
                        </a>
                    </li>
                    @if (\Auth::user('users_admin')->role == 3)
                        <li class="">
                            <a href="{{ url('/dashboard') }}">
                                <i class="icon_mail_alt"></i>
                                <span>Manage Emails</span>
                            </a>
                        </li>
                    @endif
                    @if (\Auth::user('users_admin')->role == 1 || \Auth::user('users_admin')->role == 2)
                        <li class="sub-menu">
                            <a href="javascript:;" class="">
                                <i class="icon_id"></i>
                                <span>Manage Admin</span>
                                <span class="menu-arrow arrow_carrot-right"></span>
                            </a>
                            <ul class="sub">
                                <li><a class="" href="{{ url('/adminlist') }}">View List Admin</a></li>
                                @if (\Auth::user('users_admin')->role == 1) 
                                <li><a class="" href="{{ url('/registeradmin') }}">Create New Admin</a></li>
                                @endif
                            </ul>
                        </li>
                        {{--<li class="">--}}
                        {{--<a href="{{ url('/adminlist') }}">--}}
                        {{--<i class="icon_id"></i>--}}
                        {{--<span>Manage Admin</span>--}}
                        {{--</a>--}}
                        {{--</li>--}}
                        <li class="sub-menu">
                            <a href="javascript:;" class="">
                                <i class="icon_profile"></i>   
                                <span>ManageMember</span>
                                <span class="menu-arrow arrow_carrot-right"></span>
                            </a>
                            <ul class="sub"> 
                                <li><a class="" href="{{ url('/member') }}">View List Member</a></li>
                                @if (\Auth::user('users_admin')->role == 2)
                                <li><a class="" href="{{ url('/registermember') }}">Create New Member</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (\Auth::user('users_admin')->role == 1)
                        <li class="">
                            <a href="{{ url('/monitoring') }}">
                                <i class="icon_calendar"></i>
                                <span>Monitoring Job</span>
                            </a>
                        </li>
                    @endif   

                    @if (\Auth::user('users_admin')->role == 1)
                        <li class="sub-menu">
                            <a href="javascript:;" class="">
                                <i class="icon_key"></i>
                                <span>Manage Ongkir</span>
                                <span class="menu-arrow arrow_carrot-right"></span>
                            </a>
                            <ul class="sub">
                                <li><a class="" href="{{ url('/viewongkir') }}">View List Ongkir</a></li>
                                <li><a class="" href="{{ url('/masterkendaraan') }}">Create Kendaraan</a></li>
                                <li><a class="" href="{{ url('/masterongkir') }}">Create Ongkir</a></li>
                            </ul>
                        </li>
                    @endif

                    @if (\Auth::user('users_admin')->role == 1)
                        <li class="sub-menu">
                            <a href="javascript:;" class="">
                                <i class="fa fa-calculator"></i>
                                <span>Free Ongkir</span>
                                <span class="menu-arrow arrow_carrot-right"></span>
                            </a>
                            <ul class="sub">
                                <li><a class="" href="{{ url('/masterfreeongkir') }}">Create Free Ongkir</a></li>
                                <li><a class="" href="{{ url('/viewfreeongkir') }}">View List FreeOngkir</a></li>
                            </ul>
                        </li>
                    @endif

                    @if (\Auth::user('users_admin')->role == 1)
                        <li class="sub-menu">
                            <a href="javascript:;" class="">
                                <i class="fa fa-truck"></i>
                                <span>Set Distance</span>
                                <span class="menu-arrow arrow_carrot-right"></span>
                            </a>
                            <ul class="sub">
                                <li><a class="" href="{{ url('/postalcode') }}">View Distance</a></li>   
                                {{--<li><a class="" href="{{ url('/') }}">View List FreeOngkir</a></li>--}}
                            </ul>
                        </li>
                    @endif

                    @if (\Auth::user('users_admin')->role == 1)
                        <li class="sub-menu">
                            <a href="javascript:;" class="">
                                <i class="fa fa-file"></i>
                                <span>Manage Notif</span>
                                <span class="menu-arrow arrow_carrot-right"></span>
                            </a>
                            <ul class="sub">
                                <li><a class="" href="{{ url('/createpromo') }}">Create Promo</a></li>
                                <li><a class="" href="{{ url('/notif') }}">Send Notification</a></li>
                                {{--<li><a class="" href="{{ url('/') }}">View List FreeOngkir</a></li>--}}
                            </ul>
                        </li>
                    @endif

                @endif
                {{--<li class="sub-menu">--}}
                {{--<a href="javascript:;" class="">--}}
                {{--<i class="icon_document_alt"></i>--}}
                {{--<span>Forms</span>--}}
                {{--<span class="menu-arrow arrow_carrot-right"></span>--}}
                {{--</a>--}}
                {{--<ul class="sub">--}}
                {{--<li><a class="" href="form_component.html">Form Elements</a></li>--}}
                {{--<li><a class="" href="form_validation.html">Form Validation</a></li>--}}
                {{--</ul>--}}
                {{--</li>--}}

            </ul>
            <!-- sidebar menu end-->
        </div>
    </aside>
    <!--sidebar end-->

    <!--main content start-->
    <!--main content end-->
    <div class="text-right">
        <div class="credits">
            <!--
              All the links in the footer should remain intact.
              You can delete the links only if you purchased the pro version.
              Licensing information: https://bootstrapmade.com/license/
              Purchase the pro version form: https://bootstrapmade.com/buy/?theme=NiceAdmin
            -->
            <a href="https://bootstrapmade.com/">Free Bootstrap Templates</a> by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </div>

    @yield('content')

    <div style="text-align: center; font-size:larger; color:black; margin-bottom: 10px">
        Indogrosir &copy; 2017
    </div>

<!-- container section end -->
<!-- javascripts -->
{{--<script src="{{ secure_url('js/jquery-1.9.1.js') }}"></script>--}}

<script src="{{ secure_url('js/bootstrap.min.js') }}"></script>
<script src="{{ secure_url('js/jquery.scrollTo.min.js') }}"></script> 
<script src="{{ secure_url('js/jquery.nicescroll.js') }}"></script>
<script src="{{ secure_url('js/scripts.js') }}"></script>

<script src="{{ secure_url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ secure_url('js/owl.carousel.min.js') }}"></script>
<script src="{{ secure_url('js/accounting.min.js') }}"></script>
<script src="{{ secure_url('js/jquery.smartWizard.min.js') }}"></script>

<script src="{{ secure_url('js/dashboard.js') }}"></script>
<script src="{{ secure_url('js/product.js') }}"></script>
<script src="{{ secure_url('js/cart.js') }}"></script>
<script src="{{ secure_url('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ secure_url('js/bootstrap-hover-tabs.js') }}"></script>
<script src="{{ secure_url('js/login.js') }}"></script>
<script src="{{secure_url('js/fileinput.min.js')}}"></script>       
<script src="{{ secure_url('js/bootstrap-editable.min.js') }}"></script>
<script src="{{ secure_url('js/select2.min.js') }}"></script>


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
        var getKodedialogURL = '{{ url('getKodedialog') }}';
        var getMemberOngkirURL = '{{ url('memberongkirdialog') }}';
        {{--var getMemberOngkirURL = '{{ url('memberongkirdialog') }}';--}}
        var getCabangOngkirURL = '{{ url('cabangongkirdialog') }}';
        var getDistanceURL = '{{ url('getdistanceajax') }}';
    </script>  

<script type="text/javascript" type="text/javascript">
    $(function () {
        $("#LOVmember").find("a").on('click', function () {
            $('#myModal').modal('show');
            getKodMem();
        });

        $("#memberdialog").on('click', function () {
            $('#myModal').modal('show');
            getMemberInfo();
        });

        $('.input-daterange').datepicker({
            format: "yyyy-mm-dd",
            immediateUpdates: true,
            todayHighlight: true
        });

        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    });
</script>
{{--<script src="js/bootstrap.min.js"></script>--}}
{{--<!-- nice scroll -->--}}
{{--<script src="js/jquery.scrollTo.min.js"></script>--}}
{{--<script src="js/jquery.nicescroll.js" type="text/javascript"></script>--}}
{{--<!--custome script for all page-->--}}
{{--<script src="js/scripts.js"></script>--}}
    <div id="myModal" class="modal fade" role="dialog">   
        <div class="modal-dialog" style="position: absolute; margin-left: -200px;"> 
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 style="margin-bottom:0px" id="myModalLabel" class="font-14"></h4>
                </div>
                <div id="modal-core" class="modal-body" style='text-align: center'></div>
                <div id="modal-error" class="modal-footer"><br/></div>
            </div>
        </div>
    </div>

    <div class="modal fade-scale" id="EditModal" role="dialog">
        <div class="modal-dialog modal-md" style="position:absolute;margin-left: -200px;">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit </h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="POST" action="">
                        <input type="text" id="txt_id" hidden>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="txt_hp"> No. Hp : </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="txt_hp" id="txt_hp">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="txt_alamat">Alamat Aktif : </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="txt_alamat" id="txt_alamat">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="combo_provinsi">Provinsi : </label>
                            <select class="selectpicker col-md-6" data-live-search="true" name="combo_provinsi" id="combo_provinsi" onchange="changeKota()" data-title="Pilih Provinsi!" >

                            </select>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="combo_kota">Kota/Kab. : </label>
                            <select class="selectpicker col-md-6" data-live-search="true" name="combo_kota" id="combo_kota" onchange="changeKecamatan()" data-title="Pilih Kota/Kabupaten!"></select>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="combo_kecamatan">Kecamatan : </label>
                            <select class="col-md-6 selectpicker" data-live-search="true" name="combo_kecamatan" id="combo_kecamatan" onchange="changeKelurahan()" data-title="Pilih Kecamatan!"></select>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="combo_kelurahan">Kelurahan : </label>
                            <select class="col-md-6 selectpicker" data-live-search="true" name="combo_kelurahan" id="combo_kelurahan" data-title="Pilih Kelurahan!" onchange="changeKodePos()"></select>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="text_kodepos">Kode Pos : </label>
                            <div class="col-md-6">
                                <input class="form-control" type="text" id="kode_pos" name="text_kodepos" disabled="true" placeholder="Kode pos">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="txt_alamat">Jenis Member : </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="txt_type" id="txt_type">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="txt_alamat">Nama NPWP : </label>
                            <div class="col-md-6">
                                {{--<input type="text" class="form-control" name="nama_npwp" id="nama_npwp">--}}
                                <textarea class="form-control" rows="3" name="nama_npwp" id="nama_npwp"></textarea>     
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="txt_alamat">Alamat NPWP : </label>
                            <div class="col-md-6">
                                {{--<input type="text" class="form-control" name="alamat_npwp" id="alamat_npwp">--}}
                                <textarea class="form-control" rows="5" name="alamat_npwp" id="alamat_npwp"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="txt_alamat">Nomor NPWP : </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nomor_npwp" id="nomor_npwp">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="txt_minor">Minimal order : </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="minor" id="minor">
                            </div>
                        </div>

                        {{--<div class="form-group">--}}
                            {{--<label class="col-md-3 control-label" for="txt_alamat">Shipping Fee : </label>--}}
                            {{--<div class="col-md-6">--}}
                                {{--<input type="text" class="form-control" name="shipping" id="shipping">--}}
                            {{--</div>--}}
                        {{--</div>--}}    

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn_save">Simpan</button>
                </div>
            </div>

        </div>
    </div>
    <script>
        $("#btn_save").click(function(){
            var id = $("#txt_id").val();
            var hp = $("#txt_hp").val();
            var alamat = $("#txt_alamat").val();
            var provinsi = $("#combo_provinsi").val();
            var kota = $("#combo_kota").val();
            var kecamatan = $("#combo_kecamatan").val();
            var kelurahan = $("#combo_kelurahan").val();
            var kodepos = $("#kode_pos").val();
            var minor = $("#minor").val();
            var shipping = $("#shipping").val();

            if(hp == "" || hp == "" || alamat == "" || provinsi == "" || kota == "" || kecamatan == "" || kelurahan == ""){
                alert("Silahkan lengkapi data!");
            }else{
                $.ajax({
                    url: 'simpan_alamat',
                    type : 'POST',
                    data : {
                        id : id,
                        no_hp : hp,
                        alamat : alamat,
                        provinsi : provinsi,
                        kota : kota,
                        kecamatan : kecamatan,
                        kelurahan : kelurahan,
                        kodepos : kodepos,
                        minor : minor,
                        shipping : shipping,       
                    },
                    success:function(msg){
                        alert("Data berhasil diubah.");
                        location.reload();
                    }
                });
            }
        });
    </script>


</section>
</body>

</html>
