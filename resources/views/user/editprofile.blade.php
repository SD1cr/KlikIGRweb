@extends('app')
@section('content')

    <div class="container" style="margin-top: 75px;">
        <div class="row">

            {!! $sidebar !!}

            <div class="col-md-9">
                <div class="panel panel-default flat">
                    <div class="bs-callout bs-callout-primary" style="margin-top: 0px;">
                        <h4 style="font-size: 30px !important;"><i style='color:#428BCA; font-size: xx-large !important;' class='fa fa-user'></i>&nbsp; Ubah User Baru</h4>
                    </div>
                    <div class="panel-body">

                        @if (session('err'))
                            <div class="col-md-12 igr-flat" style="margin-top:10px;">
                                <div class="alert alert-danger igr-flat">
                                    <strong>{{session('err')}}</strong>
                                </div>
                            </div>
                        @endif

                        @if (session('suc'))
                            <div class="col-md-12 igr-flat" style="margin-top:10px;">
                                <div class="alert alert-success igr-flat">
                                    <strong>{{session('suc')}}</strong>
                                </div>
                            </div>
                        @endif
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/updateprofile') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            @if(!empty($profilArray))
                                @foreach($profilArray as $index => $row)

                                    <div class="form-group">
                                        <div class="col-md-9">
                                            <label class="control-label">Nama </label><i style="color: red"> *</i>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control flat"  name="nama" value="{{ $row['nama'] }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="control-label">Alamat Email </label><i style="color: red"> *</i>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="email" class="form-control flat" maxlength="50" name="Email" readonly="true" value="{{ $row['email'] }}">
                                        </div>
                                    </div>

                                    @if (\Auth::User()->type_id == 3 && \Auth::User()->flag_verif == null)
                                        <div class="form-group">
                                            <div class="col-md-5">
                                                <label class="control-label">Kode Member </label><i style="color: red"> *</i>
                                                {{--<label class="control-label">Belum Verifikasi? </label><a href="" style="color: red; font-weight: bold"> Verifikasi Sekarang</a>--}}
                                            </div>
                                            <div class="col-md-4">
                                                {{--<label class="control-label">Kode Member </label><i style="color: red"> *</i>--}}
                                                <label class="control-label">Belum Verifikasi? </label>&nbsp<a href="{{ url('/verif') }}" style="color: red; font-weight: bold"> Verifikasi Sekarang</a>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control flat" maxlength="50" name="NoHp" value="-" readonly="true">
                                            </div>
                                        </div>
                                    @else
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <label class="control-label">Kode Member </label><i style="color: red"> *</i>
                                            </div>
                                            <div class="col-md-4">
                                                {{--<label class="control-label">Kode Member </label><i style="color: red"> *</i>--}}
                                                <label class="control-label">Akun Anda Telah Terverifikasi</label><i style='font-size: larger;color:green' class="fa fa-check"></i>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control flat" maxlength="50" name="NoHp" value="{{ $row['kodemember'] }}" readonly="true">
                                            </div>
                                        </div>
                                    @endif


                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="control-label">No. Handphone </label><i style="color: red"> *</i>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control flat" maxlength="50" name="NoHp" value="{{ $row['phone_number'] }}">
                                        </div>
                                    </div><hr style='margin-top: 5px;margin-bottom: 10px;'/>

                                    @if (\Auth::User()->type_id == 3)
                                    @if (session('errnpwp'))
                                        <div class="col-md-12 igr-flat" style="margin-top:10px;">
                                            <div class="alert alert-danger igr-flat">
                                                <strong>{{session('errnpwp')}}</strong>
                                            </div>
                                        </div>
                                    @endif


                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="control-label">Nama NPWP </label><i style="color: grey"> *</i>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control flat"  name="namanpwp" value="{{ $row['npwp_name'] }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="control-label">Nomor NPWP </label><i style="color: grey"> *</i>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control flat"  name="nomornpwp" value="{{ $row['npwp_number'] }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="control-label">Alamat NPWP </label><i style="color: grey"> *</i>
                                        </div>
                                        <div class="col-md-9">
                                            <input style='height: 80px;' type="text" class="form-control flat"  name="alamatnpwp" value="{{ $row['npwp_address'] }}">
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            @endif


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-0">
                                    <button type="submit" class="btn btn-primary flat">
                                        <i style='color:white' class='fa fa-user-plus'></i>
                                        Ubah User
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        function changeProv(){
            var provSelect = $("#provSelect").val();
            $.ajax({
                url : '{{ url('changecity') }}',
                data: { prov: provSelect },
                success : function(data) {
                    $("#citySelect").html(data);
                    $("#citySelect").selectpicker('refresh');
                }
            });
        }

        function changeCity(){
            var citySelect = $("#citySelect").val();
            $.ajax({
                url : '{{ url('changedistrict')}}',
                data: {city: citySelect},
                success : function(data){
                    $("#disSelect").html(data);
                    $("#disSelect").selectpicker('refresh');
                }
            });
        }
    </script>
@endsection