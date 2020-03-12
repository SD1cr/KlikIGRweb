@extends('appcheckout')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="row">
            <div class="col-sm-8 col-md-offset-2" style="min-height: 4px;box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);">
                @if (isset($suc))
                    <div class="col-md-12 igr-flat" style="margin-top:10px;">
                        <div class="alert alert-info flat">
                            <strong>{{$suc}}</strong>
                        </div>
                    </div>
                @endif
                @if (isset($err))
                    <div class="col-md-12 igr-flat" style="margin-top:10px;">
                        <div class="alert alert-danger flat">
                            <strong>{{$err}}</strong>
                        </div>
                    </div>
                @endif
                <div style="margin-bottom: 10px;margin-top: 10px;">

                    <div class="row">
                        <div class="bs-callout bs-callout-primary" style="margin-top: -10px; margin-bottom: 20px;">
                            <h4 style="font-size: 30px !important;text-align: center">Aktivasi Akun</h4>
                        </div>
                    </div>
                    <div style="padding-left: 20px;padding-right: 10px;">
                        <p style="font-size: medium !important; color: #428bca; font-weight: bold">Terima kasih sudah mendaftar sebagai member Klikindogrosir !</p><br>
                        <p>Saat ini kami telah mengirimkan sebuah email yang berisi petunjuk aktivasi akun Anda</p>
                        <p>Silakan periksa dan lakukan verifikasi di email Anda untuk dapat mulai berbelanja. </p><br/>

                        <p>Apabila dalam waktu 5 menit, Anda belum mendapatkan email aktivasi </p>
                        <p>silakan klik tombol dibawah ini : </p><br/>


                        <form class="form-horizontal" role="form" method="GET" action="{{ url('/resendaktivasi') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="col-md-6" style="padding-left: 0px;">
                                <input type="text" class="form-control flat" name="email">
                            </div>
                            <button type="submit" class="btn btn-primary flat">
                                <i style='color:white' class='fa fa-envelope'></i>
                                Kirim Ulang Aktivasi Email
                            </button>
                        </form>
                        {{--<div class="col-md-6" style="padding-left: 0px;">--}}
                            {{--<input type="text" class="form-control flat" name="email">--}}
                        {{--</div>--}}

                        {{--<a class='btn btn-primary flat' href="resendaktivasi"><i style='color:white' class='fa fa-envelope'></i> Kirim Ulang Aktivasi Email</a>--}}

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
