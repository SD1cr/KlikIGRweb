@extends('cms1')

@section('content')
    <div class="container" style="margin-top: 60px;">
        <div class="row" style="margin-left: 0px;padding-left: 80px;">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class='fa fa-envelope-o' style="font-size: larger"></i> List Email</div>
                    <div class="panel-body">
                        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog" style="position: absolute">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Konfirmasi Penghapusan</h4>
                                    </div>

                                    <div class="modal-body">
                                        <p>Anda akan menghapus Listing Email, aksi ini tidak dapat dibatalkan.</p>
                                        <p>Apakah anda yakin ingin melanjutkan?</p>
                                    </div>

                                    <div class="modal-footer">
                                        <a class="btn btn-danger btn-ok"><i class="fa fa-times"></i> Delete</a>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (\Auth::user('users_admin')->role != 2)
                            <div class="form-group">
                                <label for="combo_cabang">&nbsp;&nbsp;Filter Cabang : </label>
                                <select id="cabang" name="cab" class="selectpicker" data-live-search="true" onchange="changeCabang()">
                                    <option style="font-size: 12px;" value="">All Cabang </option>   
                                    {!! $cab !!}
                                </select>
                            </div>
                        @endif
                        <div class="col-xs-12 table-responsive">
                            <table class="table" id="dtTable">
                                <thead>
                                <tr>
                                    <th width="20%">Kode Cabang</th>
                                    <th width="40%">Email</th>
                                    <th width="10%">Aksi</th>
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
            searching : true,
            dom: 'Blfrtip',

            iDisplayLength: 10,
            ajax: {
                url: '{{url('admin/emails/datatable')}}',
                data: function (d) {
                    d.cab = $('[name=cab]').val();
                }
            },
            columns: [
                { data: 'kode_cabang', name: 'kode_cabang' },
                { data: 'email', name: 'email' },
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