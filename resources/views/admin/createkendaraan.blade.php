@extends('cms1')

@section('content')
    <div class="container" style="margin-top: 60px;">
        <div class="row" style="margin-left: 0px;padding-left: 80px;">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class='fa fa-envelope-o' style="font-size: larger"></i> Master Kendaraan</div>
                    <div class="panel-body">
                        @if (session('err'))
                            <div class="col-md-12">
                                <div class="alert alert-danger flat">
                                    <strong>Penambahan master kendaraan baru gagal, kendaraan sudah tersedia !</strong>
                                </div>
                            </div>
                        @endif
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/createkendaraan') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="col-md-12 input-group inputs" style="margin-top: 10px; margin-bottom: 10px;">
                            <span class="input-group-addon" style="min-width: 142px;text-align: left">Nama Kendaraan</span>
                            <input type="text" name="kendaraan" min="1" class="input-sm form-control">
                        </div>

                        <div style="padding-left: 0px;margin-bottom: 40px">
                            <button type=submit style="margin-top: 5px;" class="btn btn-primary igr-flat"><i class="fa fa-check-square-o">&nbsp</i>Simpan</button>
                        </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection