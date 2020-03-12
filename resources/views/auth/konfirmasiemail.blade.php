@extends('appcheckout')
@section('content')

<div class="container">
    <div class="col-md-4 col-md-offset-4">
        <div style="margin-top: 90px;margin-left: 15px;" class="panel panel-default">
            <div class="panel-body flat">
                <div style="text-align: center">
                    <a style="padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;">
                        <img  src="{{ url('img/logo.png') }}"/>
                    </a>
                </div>

                <div style="text-align: center">
                    <i style="color:lightgrey" class="fa fa-envelope fa-5x"></i>
                </div>

                <div style="text-align: center; margin-top: 30px;margin-bottom: 15px;">
                    <span style="font-weight: bold; font-size: 13pt;">Verifikasi Email Berhasil !</span>
                </div>

                <div style="text-align: center; margin-bottom: 15px;">
                    <span style="font-size: 13pt;">Kamu bisa langsung berbelanja di aplikasi atau website KlikIndogrosir</span>
                </div>

                <div style="text-align: center" class="col-md-12">
                    <a class="btn btn-primary btn-block"  href="{{ secure_url('/product') }}">Mulai Belanja</a>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection