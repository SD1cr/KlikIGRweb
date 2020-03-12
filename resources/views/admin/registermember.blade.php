@extends('cms1')
@section('content')
    <div class="container" style="margin-top: 60px;">
        <div class="row" style="margin-left: 0px;padding-left: 80px;">  
            <div class="col-md-2 col-md-offset-0">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Ups!</strong> Penambahan User Baru Gagal.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (isset($err))
                    <div class="col-md-12 igr-flat" style="margin-top:10px;">
                        <div class="alert alert-success igr-flat">
                            <strong>{{$err}}</strong>
                        </div>
                    </div>
                @endif
            </div>

            {{--<div class="bs-callout bs-callout-info" style="margin-top: -10px; margin-bottom: 20px;">--}}
            {{--<h4 style="font-size: 30px !important;">Registrasi Akun Anda</h4>--}}
            {{--Klik Indogrosir siap melayani Anda--}}
            {{--</div>--}}

            <div class="col-md-8 col-md-offset-0">
                <div class="panel panel-default flat">

                    <div class="bs-callout bs-callout-danger" style="margin-top: 0px;">
                        <h4 style="font-size: 30px !important;">Buat Akun Member Merah Baru</h4>
                        Klik Indogrosir siap melayani Anda
                    </div>

                    {{--<div class="panel-heading igr-flat"><i style='font-size: larger;' class='fa fa-user-plus'></i> Tambah User Baru</div>--}}
                    <div class="panel-body"> 
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/createmembermerah') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            {{--<div class="form-group">--}}
                            {{--<div class="col-md-12">--}}
                            {{--<label class="control-label">Cabang</label><i style="color: red"> *</i>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-9">--}}
                            {{--<select class="selectpicker" data-width="270px" name="cabang" id="cabSelect" onChange= "changeDis()">--}}
                            {{--<option>--Pilih Cabang--</option>--}}
                            {{--{!! $cabangOpt !!}--}}
                            {{--</select>--}}
                            {{--</div>--}}
                            {{--</div>--}}


                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="control-label">Nama </label><i style="color: red"> *</i>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control flat"  name="Nama" value="{{ old('Nama') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="control-label">Alamat Email </label><i style="color: red"> *</i>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control flat" maxlength="50" name="Email" value="{{ old('Email') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="control-label">Password </label><i style="color: red"> *</i>
                                </div>
                                <div class="col-md-6">
                                    <input type="password" class="form-control flat" maxlength="50" name="Password">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="control-label">Confirm Password </label><i style="color: red"> *</i>
                                </div>
                                <div class="col-md-6">
                                    <input type="password" class="form-control flat" maxlength="50" name="Password_confirmation">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="control-label">Alamat Penagihan </label><i style="color: red"> *</i>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control flat" maxlength="150" name="Alamat" value="{{ old('Alamat') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="control-label">Cabang </label><i style="color: red"> *</i>
                                </div>
                                <select class="col-md-6 selectpicker" name="KodeCabang" id="divSelect" onChange= "changeDiv()">
                                    {!! $cabangOpt !!}
                                </select>
                            </div>

                            <div id="LOVmember" class="form-group">
                                <div class="col-md-12">
                                    <label class="control-label flat">Kode Member <b style="color:red">*</b></label>
                                </div>

                                <div class="col-md-6">
                                    <input type="hidden" id="hKodemember" name="KodeMember">
                                    <input type="text" readonly class="form-control" id="KodeMembers" value="{{old('KodeMember')}}">
                                </div>
                                <a class='btn btn-success flat' data-id='a'><i style='color:white' class='fa fa-search'></i> Cari</a>
                            </div>   


                            <div class="form-group">
                                <div class="col-md-3">
                                    <label class="control-label">Provinsi </label><i style="color: red"> *</i>
                                    <select class="selectpicker" data-width="130px" name="province" id="provSelect" onChange= "changeProv()" data-live-search="true" >
                                        <option value="0">--Pilih Provinsi--</option>
                                        {!! $provOpt !!}
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label">Kota </label><i style="color: red"> *</i><br/>
                                    <select class="selectpicker" data-width="130px" name="cities" id="citySelect" onChange= "changeCity()" data-live-search="true" >
                                        <option value="0">--Pilih Kota--</option>
                                        {!! $citOpt !!}
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label">Kecamatan </label><i style="color: red"> *</i>
                                    <select class="selectpicker" data-width="130px" id="disSelect" onChange= "changeDis()" name="district" data-live-search="true" >
                                        <option value="0">--Pilih Kecamatan--</option>
                                        {!! $disOpt !!}
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label">Kelurahan</label><i style="color: red"> *</i>
                                    <select class="selectpicker" data-width="130px" id="subSelect" name="subdistrict" data-live-search="true" >
                                        <option value="0">--Pilih Kelurahan--</option>
                                        {!! $SubDistrictOpt !!}
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="control-label">No. Handphone </label><i style="color: red"> *</i>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control flat" maxlength="50" name="NoHp" value="{{ old('NoHp') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="control-label">Minimal Order </label><i style="color: red"> *</i>
                                </div>
                                <div class="col-md-6">
                                    <input type="number" class="form-control flat"  max="9999999999" name="MinimalOrder" value="{{ old('MinimalOrder') }}"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="control-label">Shipping Fee </label><i style="color: red"> *</i>
                                </div>
                                <div class="col-md-6">
                                    <input type="number" class="form-control flat" step="100" max="9999999999" name="ShippingFee" value="{{ old('ShippingFee') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-0">
                                    <button type="submit" class="btn btn-primary flat">
                                        <i style='color:white' class='fa fa-user-plus'></i>
                                        Simpan User
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        {{--function changeCab(){--}}
        {{--var cabSelect = $("#cabSelect").val();--}}
        {{--$.ajax({--}}
        {{--url : '{{ url('changebranches') }}',--}}
        {{--data: { cab: cabSelect },--}}
        {{--success : function(data) {--}}
        {{--$("#memSelect").html(data);--}}
        {{--$("#memSelect").selectpicker('refresh');--}}
        {{--}--}}
        {{--});--}}
        {{--}--}}
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
        function changeDis(){
            var disSelect = $("#disSelect").val();
            $.ajax({
                url : '{{ url('changeBranch')}}',
                data: {district: disSelect},
                success : function(data){
                    $("#subSelect").html(data);
                    $("#subSelect").selectpicker('refresh');
                }
            });
        }


    </script>
@endsection
