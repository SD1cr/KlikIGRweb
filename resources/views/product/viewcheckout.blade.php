@extends('appcheckout')
@section('content')
    <style>
        body{margin:0px;}                

        .stepwizard-step p {
            margin-top: 10px;
        }

        .stepwizard-row {
            display: table-row;
        }

        .stepwizard {
            display: table;
            width: 100%;
            position: relative;
        }

        .stepwizard-step button[disabled] {
            opacity: 1 !important;
            filter: alpha(opacity=100) !important;
        }

        .stepwizard-row:before {
            top: 30px;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 100%;
            height: 1px;
            background-color: #ccc;
            z-order: 0;

        }

        .stepwizard-step {
            display: table-cell;
            text-align: center;
            position: relative;
        }

        .btn-circle {
            width: 60px;
            height: 60px;
            text-align: center;
            padding: 6px 0;
            font-size: 12px;
            line-height: 1.428571429;
            border-radius: 30px;
        }


    </style>
    <div class="container" style="margin-top: 90px;">    
        <div class="row">
            {{--<div class="stepwizard">--}}
                {{--<div class="stepwizard-row">--}}
                    {{--<div class="stepwizard-step">--}}
                        {{--<button type="button" class="btn btn-default btn-circle">1</button>     --}}
                        {{--<p>Pengiriman</p>--}}
                    {{--</div>--}}
                    {{--<div class="stepwizard-step">--}}
                        {{--<button type="button" class="btn btn-primary btn-circle">2</button>--}}
                        {{--<p>Checkout</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="bs-callout bs-callout-primary" id="callout-glyphicons-dont-mix" style="margin-left: 20px;">
                <h4>Checkout</h4>
                <p>Terimakasih , selamat berbelanja kembali</p>
            </div>
            {{--<div class="col-md-10 col-md-offset-5">--}}
                {{--<img  class="col-lg-2" style="float: left" width="100px" src="{{ url('../resources/assets/img/cartcheckout.png') }}"/></div>--}}
            <div class="col-md-12 col-md-offset-0" style="margin-top: 10px; margin-bottom: 10px; text-align: center;" >
                <h4 style="margin-bottom: 10px;">TERIMA KASIH SUDAH BERBELANJA DI KLIKINDOGROSIR.COM</h4>
                <h4 style="margin-bottom: 10px; margin-top: 10px;">PESANAN ANDA AKAN SEGERA DI PROSES</h4>
                {{--<h1 style="margin-top: 10px;">SILAKAN CEK EMAIL ANDA DAN ADMIN KAMI AKAN MENGHUBUNGI ANDA</h1>--}}
            </div>
            <div style='border-width:0px;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;text-align: center; background-color: white;padding-left: 0;padding-right: 0; padding-bottom: 15px;' class='col-md-8'>
                <div class="row" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;padding-top: 20px;">
                    @foreach ( $ListAddress as $index => $row )
                        <div style='font-weight: bold;text-align: left;font-size: medium !important;'>Alamat Pengiriman </div><hr style='margin-top: 5px;margin-bottom: 5px;'/>
                        <div style='font-weight: bold; text-align: left;'>{{ $row['email'] }}</div>
                        <div style='text-align: left;padding-top: 5px;'>{{ $row['label'] }}</div>
                        <div style='text-align: left;padding-top: 10px;'>{{ $row['address'] }},<br> Kel.{{ $row['sub_district_name'] }}, Kec. {{ $row['district_name'] }},  Kota {{ $row['city_name'] }}, Prov. {{ $row['province_name'] }}</div>
                        <div style='text-align: left;'>{{ $row['postal_code'] }}</div>
                        <div style='text-align: left; padding-bottom: 10px;'>{{ $row['phone_number'] }}</div>
                    @endforeach
                </div>
            </div>
            {!! $detailpayment !!}
            {!! $detailcheckout !!}
            <div style='text-align: left; margin-top: 25px;float: right; padding-right: 10px;'><a href={{ url('/product') }} class="btn btn-primary flat">Lanjutkan Belanja</a></div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection

