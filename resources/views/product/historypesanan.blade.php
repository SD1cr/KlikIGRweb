@extends('app')
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
            top: 50px;
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
            width: 40px;
            height: 40px;
            text-align: center;
            padding: 6px 0;
            font-size: 12px;
            line-height: 1.428571429;
            border-radius: 30px;
        }


    </style>

    <div class="container" style="margin-top: 75px;">
        <div class="row">
            {!! $sidebar !!}
            <div class="col-md-9">
                <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
                <div class="panel panel-default panel-order">
                    <div class="bs-callout bs-callout-warning" style="margin-top: 0px;">
                        <h4 style="font-size: 30px !important;"><i style='color:#F0AD4E; font-size: xx-large !important;' class='fa fa-history'></i>&nbsp; Order history</h4>
                    </div>

                    @if(Session::has('error_message'))
                        <div class="alert alert-danger">
                            <strong>Warning!</strong> {!!  Session::get('error_message')  !!} <br/>
                            <span class="close kv-error-close error-close">×</span>
                        </div>
                    @elseif (Session::has('success_message'))
                        <div class="alert alert-info">
                            <strong>Success!</strong> {!!  Session::get('success_message')  !!} <br/>
                            <span class="close kv-error-close error-close">×</span>
                        </div>
                    @endif
                    @if (session('err'))
                        <div class="col-md-12 igr-flat" style="margin-top:10px;">
                            <div class="alert alert-danger igr-flat">
                                <strong>{{session('err')}}</strong>
                            </div>
                        </div>
                    @endif
                    @if (isset($err))
                        <div class="col-md-12 igr-flat" style="margin-top:10px;">
                            <div class="alert alert-danger igr-flat">
                                <strong>{{$err}}</strong>
                            </div>
                        </div>
                    @endif

                    {{--<div class="panel-heading">--}}      
                        {{--<strong>Order history</strong>--}}
                        <div class="btn-group pull-right">
                            {{--<div class="btn-group">--}}
                                {{--<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">--}}
                                    {{--Filter history <i class="fa fa-filter"></i>--}}
                                {{--</button>--}}
                                {{--<ul class="dropdown-menu dropdown-menu-right">--}}
                                    {{--<li><a href="#">Approved orders</a></li>--}}
                                    {{--<li><a href="#">Pending orders</a></li>--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        </div>
                    {{--</div>--}}
                    <div class="panel-body">
                        @foreach ( $trharray as $index => $row )
                        <div class="row" style="padding-top: 10px;">
                            {{--<div class="collapse" id="collapseExample">--}}
                            {{--</div>--}}
                            <div class="col-md-6" style="margin-top: 10px; margin-bottom: 10px;padding-top: 0px;">
                                <div style='text-align: left; font-weight: bold'>Kode Transaksi : <label style='width: 100%' class="label label-primary flat">TRX{{ str_pad($row['kode_transaksi'], 6, '0', STR_PAD_LEFT) }}</label></div><hr style='margin-top: 5px;margin-bottom: 5px;'/>
								 <div style='text-align: left; font-weight: bold'>Nomor PO :  {{ $row['no_po'] }}</div><hr style='margin-top: 5px;margin-bottom: 5px;'/>   
                                <div style='text-align: left; font-weight: bold'>Tanggal Transaksi :  {{ date('d M Y', strtotime($row['tgl_transaksi'])) }}</div><hr style='margin-top: 5px;margin-bottom: 5px;'/>
                                <div style='text-align: left; font-weight: bold'>Alamat Pengiriman : </div>
                                <div style='text-align: left;'>{{ $row['shipping_address'] }}, <br> Kel.{{ $row['shipping_subdistrict'] }}, Kec. {{ $row['shipping_district'] }},  Kota {{ $row['shipping_city'] }}, Prov. {{ $row['shipping_province'] }}</div><hr style='margin-top: 5px;margin-bottom: 5px;'/>
                                <div style='text-align: left; font-weight: bold' id='total'>Total Belanja : Rp. {{ number_format($row['total_harga'], 0, ',', '.') }}</div><hr style='margin-top: 5px;margin-bottom: 5px;'/>
                            </div>
                            <div class="col-md-6" style="margin-top: 10px;padding-top: 30px;">
                                <div style='text-align: right; font-weight: bold'>Status Pesanan : <label style='width: 100%' class="label label-success flat">{{ $row['description'] }}</label></div><hr style='margin-top: 5px;margin-bottom: 5px;'/>
                                <div style='text-align: right; font-weight: bold'><a style='width: 50%' class='btn btn-danger flat' href='reorder?TRID={{ $row['kode_transaksi'] }}'>RE-ORDER</a></div><hr style='margin-top: 5px;margin-bottom: 5px;'/>
                                 <div class="TrHeader" style='text-align: right; font-weight: bold'><a data-id="{{ $row['kode_transaksi'] }}" style='width: 50%' class='btn btn-primary flat'>VIEW DETAILS</a></div><hr style='margin-top: 5px;margin-bottom: 5px;'/>
                                <div class="TrHeader" style='text-align: right; font-weight: bold'><a class="btn btn-default flat" data-toggle="collapse" href="#{{ $row['kode_transaksi'] }}" aria-expanded="false" aria-controls="collapseExample" class='btn btn-default flat'>Status Pesanan</a></div><hr style='margin-top: 5px;margin-bottom: 5px;'/>
                            </div>
      
                            <div class="collapse" id="{{ $row['kode_transaksi'] }}">
                                <div class="stepwizard" style="padding-top: 30px;padding-bottom: 30px;">
                                    <div class="stepwizard-row">
                                        @if($row['status_id'] == 1)
                                            <div class="stepwizard-step">
                                                <button type="button" class="btn btn-primary btn-circle">1</button>
                                                <p style="color:#337AB7">Pesanan Diterima</p>
                                            </div>
                                        @else
                                            <div class="stepwizard-step">
                                                <button type="button" class="btn btn-default btn-circle">1</button>
                                                <p>Pesanan Diterima</p>
                                            </div>
                                        @endif

                                        @if($row['status_id'] == 2)
                                            <div class="stepwizard-step">
                                                <button type="button" class="btn btn-primary btn-circle">2</button>
                                                <p style="color:#337AB7">Pesanan Diproses</p>
                                            </div>
                                        @else
                                            <div class="stepwizard-step">
                                                <button type="button" class="btn btn-default btn-circle">2</button>
                                                <p>Pesanan Diproses</p>
                                            </div>
                                        @endif

                                        @if($row['status_id'] == 3)
                                            <div class="stepwizard-step">
                                                <button type="button" class="btn btn-primary btn-circle">3</button>
                                                <p style="color:#337AB7">Validasi Pembayaran</p>
                                            </div>
                                        @else
                                            <div class="stepwizard-step">
                                                <button type="button" class="btn btn-default btn-circle">3</button>
                                                <p>Validasi Pembayaran</p>
                                            </div>
                                        @endif

                                        @if($row['status_id'] == 4)
                                            <div class="stepwizard-step">
                                                <button type="button" class="btn btn-primary btn-circle">4</button>
                                                <p style="color:#337AB7">Pesanan Dipacking</p>
                                            </div>
                                        @else
                                            <div class="stepwizard-step">
                                                <button type="button" class="btn btn-default btn-circle">4</button>
                                                <p>Pesanan Dipacking</p>
                                            </div>
                                        @endif

                                        @if($row['status_id'] == 5)
                                            <div class="stepwizard-step">
                                                <button type="button" class="btn btn-primary btn-circle">5</button>
                                                <p style="color:#337AB7">Pesanan Siap Kirim</p>
                                            </div>
                                        @else
                                            <div class="stepwizard-step">
                                                <button type="button" class="btn btn-default btn-circle">5</button>
                                                <p>Pesanan Siap Kirim</p>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>

                        </div>
                        @endforeach
                            <tr>
                                <td colspan="9" style="text-align: center">{!! str_replace('/?', '?', $trharray->appends(Input::except('page'))->render()) !!}</td>
                            </tr>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
@endsection