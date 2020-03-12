@extends('cms1')

@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="row" style="margin-left: 0px;padding-left: 80px;">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class='fa fa-envelope-o' style="font-size: larger"></i>Monitoring Data</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <span style="color: red; font-size: large">Note :&nbsp;&nbsp;Harap hubungi Team Support apabila Tarikan Data tidak berhasil. </span>
                        </div>

                        {{--@if (\Auth::user('users_admin')->role != 2)--}}
                            {{--<div class="form-group">--}}
                                {{--<label for="combo_cabang">&nbsp;&nbsp;Filter Cabang : </label>--}}
                                {{--<select id="cabang" name="cab" class="selectpicker" data-live-search="true" onchange="changeCabang()">--}}
                                    {{--<option style="font-size: 12px;" value="%">All Cabang </option>--}}
                                    {{--{!! $cab !!}--}}
                                {{--</select>--}}
                            {{--</div>--}}
                        {{--@endif--}}
                        <div class="col-xs-12 table-responsive">
                            <table class="table" id="dtTable">
                                <thead>
                                <tr>
                                    <th style="text-align: center" width="20%">Nama</th>
                                    <th style="text-align: center" width="20%">Waktu</th>
                                    <th style="text-align: center" width="50%">Keterangan</th>
                                    <th style="text-align: center" width="10%">Status</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

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
                url: '{{url('admin/monitoring/datatable')}}',
//                data: function (d) {
//                    d.cab = $('[name=cab]').val();
//                }
            },
            columns: [
                { data: 'nama', name: 'nama' },
                { data: 'log_dt', name: 'log_dt' },
                { data: 'log_msg', name: 'log_msg' },
                { data: 'action', name: 'action' }
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
                url : '{{ url('emails')}}',
                data: {cab: cab},
                success : function(data){
                    window.location.href = window.location.href.replace( /[\?#].*|$/, "?cab=" + cab)
                }
            });
        }


        $( document ).ready(function() {
            $('#confirm-delete').on('show.bs.modal', function(e) {
                $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
            });
        });

    </script>
@endsection