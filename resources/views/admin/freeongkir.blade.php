@extends('cms1')

@section('content')
    <div class="container" style="margin-top: 80px;">
        <div class="row" style="margin-left: 0px;padding-left: 80px;">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-bus" style="font-size: larger"></i> Master Free Ongkir</div>
                    <div class="panel-body">
                        @if (session('suc'))
                            <div class="col-md-12">
                                <div class="alert alert-info flat">
                                    <strong>Selamat !Penambahan master free ongkir !</strong>
                                </div>
                            </div>
                        @endif

                        @if (session('err'))
                            <div class="col-md-12">
                                <div class="alert alert-danger flat">
                                    <strong>Maaf !Masih ada promo free ongkir yang masih jalan !</strong>
                                </div>
                            </div>
                        @endif


                        @if (session('err2'))
                            <div class="col-md-12">
                                <div class="alert alert-info flat">
                                    <strong>Maaf ! Data Isian yang Anda masukkan, kurang lengkap !</strong>
                                </div>
                            </div>
                        @endif


                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/postfreeongkir') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="col-md-12 input-group inputs">
                                <span class="input-group-addon" style="min-width: 142px;text-align: left">Nama Program</span>
                                <input type="text" name="namaproject" class="input-sm form-control">
                            </div>

                            <div class='input-daterange input-group' id='datepicker' style="margin-top: 10px; margin-bottom: 10px;">
                                <span style="padding-left: 12px;padding-right: 22px;" class="input-group-addon">Periode Program</span>
                                <input type='text' class="form-control" name="start" id="dtStart"/>
                                <span class="input-group-addon">Sampai Tanggal</span>
                                <input type='text' class="form-control" name="end" id="dtEnd"/>
                            </div>

                            <div style='text-align: left; font-weight: bold;padding-left: 5px;'>Tipe Program Ongkir</div><hr style='margin-top: 5px;margin-bottom: 5px;'/>

                            {{--<div class="form-group" style="margin-left: -0px;margin-right: 0px;">--}}
                            {{--<label for="combo_cabang">&nbsp;&nbsp;Filter Cabang : </label>--}}
                            {{--<select class="selectpicker form-control" name="KodeCabang" id="cabangSelect" data-live-search="true" onselect="onPilih()" multiple>--}}
                            {{--{!! $cabang !!}--}}
                            {{--</select>--}}
                            {{--</div>--}}


                            <div class="row" style="padding-left: 20px;">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" name='sendRadio' value='0' id='nom' style="margin-right: 10px; margin-bottom: 10px; margin-top:10px;" onclick="addForm();" ><span>By Nominal</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" name='sendRadio' value='1' id='mem' style="margin-right: 10px;" onclick="hideForm()"; CHECKED><span>By Member</span>
                                    </label>
                                </div>
                            </div>


                            <div class="form-group" style="padding-top: 20px;margin-left: 0px;">
                                <label for="combo_cabang">&nbsp;&nbsp;Filter Cabang : </label>
                                <select id="cabang" name="cab[]" class="selectpicker" data-live-search="true" multiple data-actions-box="true" onchange="onPilih()" multiple>
                                    {{--<option style="font-size: 12px;" value="%">All Cabang </option>--}}
                                    {!! $cabang !!}
                                </select>
                            </div>

                            <div id="cab" class="col-md-12 input-group inputs" style="margin-top: 0px;"></div>
                            <div id="demo" class="col-md-12 input-group inputs" style="margin-top: 0px;"></div>

                            @if (session('err3'))
                                <div class="col-md-12">
                                    <div class="alert alert-warning flat">
                                        <strong>Maaf ! Data Isian Minimal Order Harus di isi !</strong>
                                    </div>
                                </div>
                            @endif


                            {{--<div id="orademo">--}}
                            <div id='wow' class="input-group">
                                <label style='margin-top: 10px;' for="basic-url">Tentukan Member </label>
                                <select class="js-example-basic-multiple" name="member[]" id='member' multiple="multiple">
                                    {!! $getmember !!}
                                </select>
                            </div>

                            <div style="padding-left: 0px;margin-top: 40px; float: right">
                                <button type=submit style="margin-top: 5px;" class="btn btn-primary igr-flat"><i class="fa fa-check-square-o">&nbsp</i>Simpan</button>
                            </div>
                            {{--</div>--}}
                        </form>
                    </div>
                </div>
                <script>
                    function addForm() {
                        $('#demo').html("<span class='input-group-addon' style='min-width: 142px;text-align: left'>Jumlah Nominal</span><input type='number' name='biayaongkir' min='1' class='input-sm form-control'>");
                        {{--$('#cab').html("<span class='input-group-addon' style='min-width: 142px;text-align: left'>Filter Cabang</span><select class='selectpicker form-control' name='kodeCabang' id='cabangSelect' data-live-search='true' onselect='onPilih()'>{!! $cabang !!}</select><input type='hidden' name='cabangValue' id='cabangValue'><script>$('.selectpicker').selectpicker();\<\/script>");--}}
                        $('#wow').hide();
                    }

                    function hideForm(){
                        $('#demo').html("");
//                        $('#cab').show();
                        $('#wow').show();
                    }


                    function onPilih(){
                        var cab = $("#cabang").val();
                        $.ajax({
                            url : '{{ url('changemember') }}',
                            data: {cab: cab},
                            success : function(data) {
                                $("#member").html(data);
                                $("#member").select2('refresh');
                            }
                        });
                    }

                    $(document).ready(function() {
                        $('.selectpicker').selectpicker();
                        $('.js-example-basic-multiple').select2();
                    });
                </script>
            </div>
        </div>
    </div>
@endsection 