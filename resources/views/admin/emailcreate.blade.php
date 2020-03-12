@extends('cms1')

@section('content')
    <div class="container" style="margin-top: 60px;">
        <div class="row" style="margin-left: 0px;padding-left: 80px;">
        <div class="col-md-2 col-md-offset-0">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Ups!</strong> Penambahan Email Baru Gagal.<br><br>
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
                    <div class="panel-heading"><i class='fa fa-envelope-o' style="font-size: larger"></i> Tambah Email Baru</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/addmail') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Alamat Email</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" maxlength="50" name="Email" value="{{ old('Email') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Cabang</label>
                                <select class="col-md-6 selectpicker" name="KodeCabang" id="divSelect" onChange= "changeDiv()">
                                    {!! $cabang !!}
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-success">
                                        <i style='color:white' class='fa fa-user-plus'></i>
                                        Simpan 
                                    </button>
                                    <a class='btn btn-primary' href="emails"><i style='color:white' class='fa fa-envelope-o'></i> Kembali ke Listing Email</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
