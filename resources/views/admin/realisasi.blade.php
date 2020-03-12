@extends('cms1')

@section('content') 
    <div class="container" style="margin-top: 60px;">
        <div class="row" style="margin-left: 0px;padding-left: 80px;">
        <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-bar-chart" style="font-size: larger"></i> Laporan PB Realisasi</div>
                    <div class="panel-body">
                        @if (session('errorSL'))
                            <div style="text-align: center" class="alert alert-danger">
                                <strong>Tidak Ada Data</strong>
                            </div>
                        @endif
                        <div class="span8">
                            <form class="form-horizontal" id="upload" enctype="multipart/form-data" method="post" action="{{ url('reportpb') }}" autocomplete="off">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                                <div class="form-group">
                                    <label class="col-md-1 control-label">Cabang</label>
                                    <select class="col-md-6 selectpicker" name="KodeCabang" id="divSelect" onChange= "changeDiv()">
                                        @if (\Auth::user('users_admin')->role != 2)
                                        <option style="font-size: 12px;" value="%">All Cabang </option>
                                        @endif
                                        {!! $cabang !!}
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="status">&nbsp;&nbsp;Tipe Member</label>
                                    <select style="padding-left: 20px;" class="selectpicker" data-width="270px" name="tipemember" id="statusSelect">
                                        <option style="font-size: 12px;" value="%">All Type </option>
                                        {!! $type !!}
                                    </select>
                                </div>

                                <div class="form-group">    
                                    <label for="status">&nbsp;&nbsp;Status Pesanan  </label>
                                    <select style="padding-left: 20px;" class="selectpicker" data-width="270px" name="tipestatus" id="statusSelect">
                                        <option style="font-size: 12px;" value="x">All Status </option>
                                        <option style="font-size: 12px;" value="y">Diproses </option>
                                        <option style="font-size: 12px;" value="z">Tidak Diproses </option>
                                    </select>
                                </div>

                                <div class='input-daterange input-group' id='datepicker' style="margin-top: 10px; margin-bottom: 10px;">
                                    <span class="input-group-addon">Per Tanggal</span>
                                    <input type='text' class="form-control" name="start" id="dtStart"/>
                                    <span class="input-group-addon">Sampai Tanggal</span>
                                    <input type='text' class="form-control" name="end" id="dtEnd"/>
                                </div>

                                <div style="float:right;">
                                    <button type="submit" class="btn btn-primary">
                                        <i style='color:white' class='fa fa-eye'></i>
                                        Lihat
                                    </button>
                                </div>
                            </form>
                        </div>
                        <script>
                            $(document).ready(function() {
                                var options = {
                                    beforeSubmit:  showRequest,
                                    dataType: 'json'
                                };
                                $('.input-daterange').datepicker({
                                    format: "yyyy-mm-dd",
                                    immediateUpdates: true,
                                    todayHighlight: true,
                                    orientation: "bottom auto"
                                });
                            });
                            function showRequest(formData, jqForm, options) {
                                $("#validation-errors").hide().empty();
                                $("#output").css('display','none');
                                return true;
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

