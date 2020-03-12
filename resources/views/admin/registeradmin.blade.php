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
            </div>
            <div class="col-md-8 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading"><i style='font-size: larger;' class='fa fa-user-plus'></i> Tambah User Baru</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/addadmin') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">Nama <b style="color:red">*</b></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" maxlength="50" name="Name" value="{{ old('Name') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Alamat Email <b style="color:red">*</b></label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" maxlength="50" name="Email" value="{{ old('Email') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Password <b style="color:red">*</b></label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" maxlength="50" name="Password">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Confirm Password <b style="color:red">*</b></label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" maxlength="50" name="Password_confirmation">
                                </div>
                            </div>

                            <div class="form-group" style="margin-top: 10px;">
                                <label class="col-md-4 control-label">Pilih Role :</label>
                                <div class="col-sm-6">
                                    <select id='rol' style="padding-left: 20px;" class="selectpicker" name="rolestatus">
                                        <option value="x">--Pilih Status--</option>
                                        <option value="2">Admin Cabang</option>
                                        <option value="3">Admin HO</option>
                                    </select>
                                </div>
                            </div>

                            <div id='cabang' class="form-group">
                                <label class="col-md-4 control-label">Cabang <b style="color:red">*</b></label>
                                <select class="col-md-6 selectpicker" name="KodeCabang" id="divSelect" onChange= "changeDiv()">
                                    {!! $cabangOpt !!}
                                </select>
                            </div>


                            <div style="text-align: center; font-size:larger; margin-bottom: 10px">
                               <i>(<b style="color:red">*</b>) Harus Diisi </i>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-success">
                                        <i style='color:white' class='fa fa-user-plus'></i>
                                        Simpan User
                                    </button>
                                    <a class='btn btn-primary' href="adminlist"><i style='color:white' class='fa fa-user'></i> Kembali ke List Member</a>
                                </div>
                            </div>

                            {{--<div data-theme="light" id="rajaongkir-widget"></div>--}}
                            {{--<script type="text/javascript" src="//rajaongkir.com/script/widget.js"></script>--}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showCabang() {
            var e = $('#rol').val();
            if(e == 2){
                $('#cabang').show();
            }else if(e == 3){
                $('#cabang').hide();
            }
        }
    </script>
@endsection
