@extends('cms1')

@section('content')
    <div class="container" style="margin-top: 60px;">
        <div class="row" style="margin-left: 0px;padding-left: 80px;">   
            <div class="col-md-3">     
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-dashboard" style="font-size: larger"></i> Admin Dashboard</div>
                        <div id="bar-example" style="margin-top: 30px">
                        </div>

                    <div class="form-group" style="margin-top: 20px;">
                        <label for="combo_cabang">&nbsp;&nbsp;Cabang : </label>
                        <a style="text-align: left; font-size: 15px !important; margin-bottom: 10px">
                            {!! $cabang !!}
                        </a>
                    </div>

                    <div class="form-group">
                        <label for="combo_cabang">&nbsp;&nbsp;Total Pesanan : </label>
                        <a style="text-align: left; font-size: 15px !important; margin-bottom: 10px">
                            {!! $statusall !!}
                        </a>
                    </div>
                    </div>
                </div>
            <div class="col-md-9" style="padding-left: 0px;padding-right: 0px;">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-dashboard" style="font-size: larger"></i> Admin Dashboard</div>
                    <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" id="search-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        @if (\Auth::user('users_admin')->role != 2)
                        <div class="form-group">
                            <label for="combo_cabang">&nbsp;&nbsp;Filter Cabang : </label>
                            <select id="cabang" name="cab" class="selectpicker" data-live-search="true" onchange="changeCabang()">
                                <option style="font-size: 12px;" value="">All Cabang </option>
                                {!! $cab !!}
                            </select>
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="status">&nbsp;&nbsp;Tipe Member : </label>
                            <select style="padding-left: 20px;" class="selectpicker" data-width="270px" name="tipemember" id="statusSelect">
                                <option style="font-size: 12px;" value="%">All Status </option>
                                {!! $type !!}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">&nbsp;&nbsp;Pilih Status : </label>
                            <select style="padding-left: 20px;" class="selectpicker" data-width="270px" name="statusdownload" id="statusSelect">
                                <option style="font-size: 12px;" value="%">All Status </option>
                                {!! $status !!}
                            </select>
                        </div>
                        <div style="padding-left: 15px;margin-bottom: 40px">
                            <button type=submit style="margin-top: 5px;" class="btn btn-primary igr-flat"><i class="fa fa-check-square-o">&nbsp</i>Submit</button>
                        </div>
                    </form>
                    <div class="col-xs-12 table-responsive">
                        <table class="table" id="dtTable">
                            <thead>
                            <tr>
                                <th class="font-14" style="text-align: center;">Kode Transaksi</th>
								   <th class="font-14" style="text-align: center;">No PO</th>
								 <th class="font-14" style="text-align: center;">Customer</th>
                                <th class="font-14" style="text-align: center;">Email</th> 
                                <th class="font-14" style="text-align: center;">Type</th>
                                <th class="font-14" style="text-align: center;">Cabang</th>     
                                <th class="font-14" style="text-align: center;">Status</th>
                                <th class="font-14" style="text-align: center;">Tanggal Transaksi</th>
                                <th class="font-14" style="text-align: center;">Status Pengiriman</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <form style="display:none" id="hiddenform" method="POST" action="forced">   
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="filedata" name="data" value="">
        <input type="hidden" id="filenm" name="named" value="">
    </form>
    <script>
        $(document).ready(function() {
            $('.input-daterange').datepicker({
                format: "yyyy-mm-dd",
                immediateUpdates: true,
                todayHighlight: true
            });
        });

        function changeCabang(){
            var cab = $("#cabang").val();
            var trx = $("#trx").val();
//                                    var status = $("#status").val();
            $.ajax({
                url : '{{ url('dashboard')}}',
                data: {cab: cab, STDWN :'', KDTRN: trx},
                success : function(data){
                    window.location.href = window.location.href.replace( /[\?#].*|$/, "?cab=" + cab +"&STDWN=" + status + "&KDTRN=" + trx )
                }
            });
        }
        var persen1='{!! number_format($persen1, 2, ',', '.') !!}';
        var persen2='{!! number_format($persen2, 2, ',', '.') !!}';
        var persen3='{!! number_format($persen3, 2, ',', '.') !!}';
        Morris.Donut({
            element: 'bar-example',
            data: [
                {label: "Pesanan Diterima", value: persen1 } ,
                {label: "Pesanan Siap Kirim", value: persen2} ,
                {label: "Pesanan Dibatalkan", value: persen3}
            ],
            colors: ["#FF5254", "#72AD75", "#FFAC08"],
            formatter: function (x) { return x + "%"}
        });

        var projTable = $('#dtTable').DataTable( {
            dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
            "<'row'<'col-xs-12't>>"+
            "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
            processing: true,
            serverSide: true,
            ordering: true,
            searching : false,
            dom: 'Blfrtip',

            iDisplayLength: 10,
            ajax: {
                url: '{{url('admin/dashboard/datatable')}}',
                data: function (d) {
                    d.cab = $('[name=cab]').val();
                    d.tipemember = $('[name=tipemember]').val();  
                    d.statusdownload = $('[name=statusdownload]').val();
                }
            },
            columns: [
              { data: 'trx', name: 'trx' },
			  { data: 'no_po', name: 'no_po' },         
                { data: 'nama', name: 'nama' },
                { data: 'email', name: 'email'},
                { data: 'type', name: 'type' },   
                { data: 'name', name: 'name' },
                { data: 'action', name: 'action' },
                { data: 'tgl_transaksi', name: 'tgl_transaksi' },
                { data: 'description', name: 'description' }
            ],
            scrollX:        true,
            scrollCollapse: true,
            bResetDisplay: false,
            "bStateSave": true,
            fixedColumns : {
                leftColumns: 1
            }
        } );

        function changeCabang(){
            var cab = $("#cabang").val();
//                                    var status = $("#status").val();
            $.ajax({
                url : '{{ url('dashboard')}}',
                data: {cab: cab},
                success : function(data){
                    window.location.href = window.location.href.replace( /[\?#].*|$/, "?cab=" + cab)
                }
            });
        }


        $('#search-form').on('submit', function(e) {
            projTable.draw();
            e.preventDefault();
//            var cab = $('[name=cab]').val();
//            window.location.href = window.location.href.replace( /[\?#].*|$/, "?cab=" + cab )
        });


    </script>

@endsection
