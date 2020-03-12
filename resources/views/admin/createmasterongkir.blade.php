@extends('cms1')

@section('content')
    <div class="container" style="margin-top: 60px;">
        <div class="row" style="margin-left: 0px;padding-left: 80px;">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class='fa fa-envelope-o' style="font-size: larger"></i> Master Ongkos Kirim</div>
                    <div class="panel-body">
                        @if (session('suc'))
                            <div class="col-md-12">
                                <div class="alert alert-info flat">
                                    <strong>Selamat !Penambahan master kendaraan berhasil !</strong>
                                </div>
                            </div>
                        @endif
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/createongkir') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="input-group inputs" style="min-height: 60px;margin-top: 10px; margin-bottom: 10px;">
                            <span class="input-group-addon" style="min-width: 142px; text-align: left">Area Wilayah</span>
                            <select class="selectpicker input-sm form-control" name="area" id="areaSelect">
                                @foreach($cab as $c)
                                    <option value="{{ $c->id }}">{{ $c->pulau }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="areaValue" id="areaValue">
                        </div>

                        <div class="input-group inputs" style="min-height: 60px;margin-top: 10px; margin-bottom: 10px;">
                            <span class="input-group-addon" style="min-width: 142px; text-align: left">Jenis Kendaraan</span>
                            <select class="selectpicker input-sm form-control" name="kendaraan" id="kendaraanSelect">
                                @foreach($kendaraan as $c)
                                    <option value="{{ $c->id }}">{{ $c->nama }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="kendaraanValue" id="kendaraanValue">
                        </div>

                        <div class="col-md-12 input-group inputs">
                            <span class="input-group-addon" style="min-width: 142px;text-align: left">Km Pertama</span>
                            <input type="number" name="firstkm" min="1" class="input-sm form-control">
                            <span class="input-group-addon" style="min-width: 142px;text-align: left">Harga Km Pertama</span>
                            <input type="number" name="firstfee" min="1" class="input-sm form-control">
                        </div>

                        {{--<div class="col-md-6 input-group inputs">--}}
                        {{--<span class="input-group-addon" style="min-width: 142px">Harga Km Pertama</span>--}}
                        {{--<input type="text" name="title" class="input-sm form-control">--}}
                        {{--</div>--}}

                        <div class="input-group inputs" style="margin-top: 10px; margin-bottom: 10px;">
                            <span class="input-group-addon" style="min-width: 142px; text-align: left">Km Berikutnya</span>
                            <input type="number" name="nextkm" min="1" class="input-sm form-control" style="padding-left: 22px;">
                            <span class="input-group-addon" style="min-width: 142px; text-align: left">Harga Km Berikutnya</span>
                            <input type="number" name="nextfee" min="1" class="input-sm form-control">
                        </div>

                        <div class="input-group inputs">
                            <span class="input-group-addon" style="min-width: 142px;text-align: left">Km Ekstra</span>
                            <input type="number" name="extrakm" min="1" value="100" disabled class="input-sm form-control">
                            <span class="input-group-addon" style="min-width: 142px;text-align: left">Harga Ekstra</span>
                            <input type="number" name="extrafee" min="1" class="input-sm form-control">
                        </div>

                        <div class="col-md-12 input-group inputs" style="margin-top: 10px; margin-bottom: 10px;">
                            <span class="input-group-addon" style="min-width: 142px;text-align: left">Jarak Maksimal</span>
                            <input type="number" name="distance" min="1" class="input-sm form-control">
                        </div>

                        <div style="padding-left: 0px;margin-bottom: 40px">
                            <button type=submit style="margin-top: 5px;" class="btn btn-primary igr-flat"><i class="fa fa-check-square-o">&nbsp</i>Simpan</button>
                        </div>
                        {{--<div class="input-group inputs">--}}
                        {{--<span class="input-group-addon" style="min-width: 142px">Harga Km Berikutnya</span>--}}
                        {{--<input type="text" name="title" class="input-sm form-control">--}}
                        {{--</div>--}}
                    </form>
                    </div>
                </div>
            </div>
        </div>

        {{--<div class="row" style="margin-left: 0px;padding-left: 80px;">--}}
        {{--<div class="col-md-10 col-md-offset-1">--}}
        {{--<div class="panel panel-default">--}}
        {{--<div class="panel-heading"><i class='fa fa-envelope-o' style="font-size: larger"></i> Edit Ongkos Kirim</div>--}}
        {{--<div class="panel-body">--}}

        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
    </div>
@endsection