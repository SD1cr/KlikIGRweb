@extends('cms1')

@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="row" style="margin-left: 0px;padding-left: 80px;">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class='fa fa-address-book' style="font-size: larger"></i> Master Free Ongkir</div>
                    <div class="panel-body">
                        @if (session('suc'))
                            <div class="col-md-12">
                                <div class="alert alert-info flat">
                                    <strong>Selamat !Penambahan master free Ongkir berhasil !</strong>
                                </div>
                            </div>
                        @endif



                        <div class="col-xs-12 table-responsive">
                            <table class="table" id="dtTable">
                                <thead>
                                <tr>
                                    <th>Nama Project</th>
                                    <th>Tipe</th>
                                    <th>Nominal</th>
                                    <th>Periode Mulai</th>
                                    <th>Periode Akhir</th>
                                    {{--<th>Cabang</th>--}}
                                    <th>Berlaku di</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog" style="position: absolute">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 style="margin-bottom:0px" id="myModalLabel" class="font-14"></h4>
                </div>
                <div id="modal-core" class="modal-body" style='text-align: center'></div>
                <div id="modal-error" class="modal-footer"><br/></div>
            </div>
        </div>
    </div>
    <script>
        $(document).on('click', '#btn_editfree_ongkir', function(){
            var id = $(this).val();

//            $("#txt_id").val(id);
            $("#myModal").modal();

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                type: "GET",
                url: getMemberOngkirURL,
                data : {id : id},
                success:function(data){
                    if(data == undefined || data == ""){
                        $('#modal-core').html('Gagal Memuat Konfirmasi');
                    }else{
                        $('#modal-core').html($(data));
                    }
                }

            });

        });

        $(document).on('click', '#btn_cabang_ongkir', function(){
            var id = $(this).val();

//            $("#txt_id").val(id);
            $("#myModal").modal();

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                type: "GET",
                url: getCabangOngkirURL,
                data : {id : id},
                success:function(data){
                    if(data == undefined || data == ""){
                        $('#modal-core').html('Gagal Memuat Konfirmasi');
                    }else{
                        $('#modal-core').html($(data));
                    }
                }

            });

        });

        $('#dtTable').dataTable( {
            ajax: '{{url('admin/freeongkir/datatable')}}',
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            columns: [
                { data: 'nama', name: 'nama' },
                { data: 'tipe', name: 'tipe' },
                { data: 'tipefree', name: 'tipefree' },
                { data: 'awal', name: 'awal' },
                { data: 'akhir', name: 'akhir' },
//                { data: 'cabang', name: 'cabang' },
                { data: 'action', name: 'action' }
            ]
        } );

    </script>
@endsection