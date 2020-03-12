@extends('appcheckout')
@section('content')
    <style>
        /* Print Only */
        @media print {
            .noprint {
                display: none !important;
            }

            .noshow {
                display: block !important;
            }

            body, html, #wrapper {
                width: 100%;
            }

            body {
                display: block;
                font-size: 13px !important;
            }
        }

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

        .checkout-panel {
            display: flex;
            flex-direction: column;
            width: 1092px;
            height: 166px;
            background-color: white;
            box-shadow : 0 0px 4px 0 rgba(0, 0, 0, 0.14);
            /*margin-top: 275px;*/
            margin-bottom: 20px;
            /*background-color: rgb(255, 255, 255);*/
            /*box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .2);*/
        }

        .progress-bar1 {
            display: flex;
            margin-bottom: 50px;
            justify-content: space-between;
        }

        .step {
            box-sizing: border-box;
            position: relative;
            z-index: 1;
            display: block;
            width: 25px;
            height: 25px;
            margin-bottom: 30px;
            border: 4px solid #fff;
            border-radius: 50%;
            background-color: #efefef;
        }

        .step:after {
            position: absolute;
            z-index: -1;
            top: 5px;
            left: 22px;
            width: 225px;
            height: 6px;
            content: '';
            background-color: #efefef;
        }

        .step:before {
            color: #2e2e2e;
            position: absolute;
            top: 40px;
        }

        .step:last-child:after {
            content: none;
        }

        .step.active {
            background-color: #f62f5e;
        }
        .step.active:after {
            background-color: #f62f5e;
        }
        .step.active:before {
            color: #f62f5e;
        }
        .step.active + .step {
            background-color: #f62f5e;
        }
        .step.active + .step:before {
            color: #f62f5e;
        }

        .step:nth-child(1):before {
            content: 'Delivery';
        }
        .step:nth-child(2):before {
            right: -40px;
            content: 'Confirmation';
        }
        .step:nth-child(3):before {
            right: -30px;
            content: 'Payment';
        }
        .step:nth-child(4):before {
            right: 0;
            content: 'Finish';
        }


    </style>
    <div class="container" style="margin-top: 75px;">
        <div class="row">
            <div class="bs-callout bs-callout-primary" id="callout-glyphicons-dont-mix" style="margin-left: 20px;">
                <h4>Pengiriman</h4>
                <p>Pastikan alamat pengiriman & metode pengiriman</p>
            </div>
            <div class="col-md-12" style="margin-top: 0px;padding-left: 0;padding-right: 0;">
                <div style='border-width:0px; box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);border-style:solid; border-color: #9e9e9e;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;text-align: center; background-color: white;padding-left: 0;margin-left: 20px;padding-right: 0; padding-bottom: 15px;' class='col-md-7'>
                    <div class="row noprint" style="margin-left: 0px;margin-right: 0px;padding-left: 20px;padding-top: 20px;">
                        @foreach ( $ListAddress as $index => $row )
                            <div style='font-weight: bold;text-align: left;font-size: medium !important;'>Alamat Pengiriman </div><hr style='margin-top: 5px;margin-bottom: 5px;'/>
                            <div style='font-weight: bold; text-align: left;'>{{ $row['email'] }}</div>
                            <div style='text-align: left;padding-top: 5px;'>{{ $row['label'] }}</div>
                            <div style='text-align: left;padding-top: 10px;'>{{ $row['address'] }},<br> Kel.{{ $row['sub_district_name'] }}, Kec. {{ $row['district_name'] }},  Kota {{ $row['city_name'] }}, Prov. {{ $row['province_name'] }}</div>
                            <div style='text-align: left;'>{{ $row['postal_code'] }}</div>
                            <div style='text-align: left; padding-bottom: 10px;'>{{ $row['phone_number'] }}</div>
                            <div style='text-align: left;float: left; padding-right: 10px;padding-bottom: 5px;'><a id="changeaddressdialog" class='btn btn-primary flat'>Ubah Alamat</a></div>
                        @endforeach
                    </div>
                    <hr style='margin-top: 5px;margin-bottom: 5px;'/>
                    <div style='font-weight: bold;text-align: left;font-size: medium !important;padding-left: 20px;padding-top: 20px;'><span class="caret" style="border-width: 10px; margin-right: 5px;"></span>Detail Barang Belanja</div>
                    <hr style='margin-top: 5px;margin-bottom: 5px;'/>
                    <div style='font-weight: bold;text-align: left;font-size: small !important;padding-left: 20px;padding-top: 0px;'>Dikirim dari : {{ $row['name'] }}</div>
                    <hr style='margin-top: 5px;margin-bottom: 5px;'/>
                    {!! $cartdetail !!}
                </div>
                <div style='border-width:0px; box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);border-style:solid; border-color: #9e9e9e;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;text-align: center; background-color: white;padding-left: 0;padding-right: 0; padding-left: 20px;padding-right: 0; padding-bottom: 20px;padding-top: 20px; margin-bottom: 10px;margin-left: 20px;' class='col-md-4'>
                    {!! $ongkir !!}  

                </div>
                <div style='border-width:0px; box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);border-style:solid; border-color: #9e9e9e;border-left-width: 0px;border-top-width: 0px;border-bottom-width: 0px;text-align: center; background-color: white;padding-left: 0;padding-right: 0; padding-left: 20px;padding-right: 0; padding-bottom: 20px;padding-top: 20px; margin-left: 20px;' class='col-md-4'>
                    {!! $detail !!}
                </div>
            </div> 

        </div>
    </div>




@endsection
@section('scripts')

@endsection

