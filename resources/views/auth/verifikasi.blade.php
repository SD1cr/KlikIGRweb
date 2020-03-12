@extends('appcheckout')

@section('content')
    <div class="container" style="margin-top: 75px;">
        <div class="row">
            <div class="col-md-4 col-md-offset-4" style="margin-top: 30px;">
                <div class="panel panel-default">
                    <div class="panel-body">

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="text-center">
                            <i class="fa fa-key fa-3x"></i>
                            {{--<img height="75px" style="padding:1%;" src="{{ asset('image/kartu_biru.png') }}"/>--}}
                            <i></i>
                            <h3 class="text-center" style="margin-bottom: 20px;margin-top: 20px;">Verifikasi Kode Member</h3>
                            <p>Masukkan kode member yang terdaftar di Indogrosir, <br>Apabila belum punya, Segera daftar di Toko Indogrosir terdekat </p>
                            <div class="panel-body">

                                <form class="form-horizontal" role="form" method="POST" action="{{ url('/postverif') }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">


                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"> <i style='color:black' class="fa fa-user"></i></span>
                                            <input type="text" class="form-control" placeholder="Masukkan Kode Member" name="kodemember" value="{{ old('kodemember') }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"> <i style='color:black' class="fa fa-phone"></i></span>
                                            <input type="number" class="form-control" placeholder="Nomor Handphone" name="nohp" value="{{ old('nohp') }}">
                                        </div>
                                    </div>


                                    @if (session('err'))
                                        <div class="col-md-12 igr-flat" style="margin-top:10px;margin-bottom:10px;">
                                                <span style="color: red">{{session('err')}}</span>
                                        </div>
                                    @endif


                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-primary btn-block flat">
                                            Kirim SMS OTP
                                        </button>
                                    </div>

                                    <div class="form-group">
                                        <a data-toggle='modal' data-target='.confirm-create1'>Verifikasi Nanti</a>
                                        {{--<a href="{{ url('/product') }}">--}}
                                            {{--Verifikasi Nanti--}}
                                        {{--</a>--}}
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade confirm-create1" role="dialog">
        <div class="modal-dialog modal-xs">
            <div class="modal-content flat">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 style="text-align: center" class="modal-title" id="myModalLabel">Verifikasi Nanti</h4>
                </div>

                <div class="modal-body">
                    <p style="text-align: center">Apabila Anda tidak melakukan verifikasi maka Anda tidak akan mendapatkan benefit Promo</p>
                </div>

                <div class="modal-footer" style="padding-left: 50px;">
                    <a class="col-md-5 btn btn-danger flat" href="{{ url('/product') }}"> Lanjutkan</a>
                    <button type="button" class="col-md-5 btn btn-default flat" style="margin-left: 10px;" data-dismiss="modal">Batal</button>
                </div>

            </div>
        </div>
    </div>

    <div id="myModalVerif" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content flat">
                <div class="modal-header">
                    <div id="modal-error"></div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 style="margin-bottom:0px" id="myModalLabel" class="font-14"></h4>
                </div>
                <div id="modal-core" class="modal-body" style='text-align: center'>
                    <p>Untuk alasan keamanan. Silahkan masukkan kode OTP, <br>yang sudah dikirimkan ke nomor {{ session('nope') }}</p> 
                </div>
                <div id="modal-core" class="modal-body" style='text-align: center'>
                    <strong><span style="font-size: large">Masukkan 6-digit kode</span></strong>
                </div>

                <div id="modal-core" class="modal-body" style='text-align: center'>
                    <div class="loginpin"></div>
                </div>
                <div hidden id="alert_failed" style='text-align: center'>
                    <p style="color:red;padding-left: 20px;padding-right: 20px;">Kode OTP yang Anda masukkan salah <br> Silakan ulangi proses validasi</p>
                </div>

                <div hidden id="alert_max5" style='text-align: center'>
                    <p style="color:red;padding-left: 20px;padding-right: 20px;">Anda telah melakukan request OTP sebanyak 5x, <br> Coba kembali dalam 1x24 jam</p>
                </div>

                <div hidden id="btnreload" class="modal-body" style='text-align: center'>
                    <button type="button" class="btn btn-primary" id="btnreloadotp">Reload SMS OTP</button>
                </div>

                <div style="text-align: center;;margin-top: 20px;">Waktu Tersisa = <span id="countdown"></span></div>

                <div hidden id="alert_success" style='text-align: center'>
                    <p style="padding-left: 20px;padding-right: 20px;">Selamat, <i class="fa fa-check-square-o"></i><br>Akun Anda telah terverifikasi </p>
                </div>


                <div id="modal-error" class="modal-footer"><br/>
                    {{--<button id = "btn_checkout" class="btn btn-primary btn-ok"><i class="fa fa-check-square-o"></i> Verifikasi</button>--}}
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
@endsection
