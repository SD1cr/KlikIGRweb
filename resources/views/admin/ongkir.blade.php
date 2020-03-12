@extends('cms1')

@section('content')
    <div class="container" style="margin-top: 60px;">
        <div class="row" style="margin-left: 0px;padding-left: 80px;">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class='fa fa-envelope-o' style="font-size: larger"></i> Master Ongkos Kirim</div>
                    <div class="panel-body">
                        @if (session('suc'))
                            <div class="col-md-12">
                                <div class="alert alert-info flat">
                                    <strong>Selamat !Penambahan master ongkir berhasil !</strong>
                                </div>
                            </div>
                        @endif
                        {{--<div class="input-group inputs">--}}
                            {{--<span class="input-group-addon" style="min-width: 142px">Harga Km Berikutnya</span>--}}
                            {{--<input type="text" name="title" class="input-sm form-control">--}}
                        {{--</div>--}}

                        <div class="col-xs-12 table-responsive">
                            <table class="table" id="dtTable">
                                <thead>
                                <tr>
                                    <th width="10%">Jenis Kendaraan</th>
                                    <th width="10%">Pulau</th>
                                    <th width="10%">Km Pertama</th>
                                    <th width="10%">Hrg Km Pertama</th>
                                    <th width="20%">Hrg Km Berikutnya</th>
                                    <th width="20%">Hrg Ekstra</th>
                                    <th width="10%">Jarak Max</th>
                                    <th width="10%">Edit</th>
                                    <th width="10%">Hapus</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--<div class="row" style="margin-left: 0px;padding-left: 80px;">--}}
            {{--<div class="col-md-10 col-md-offset-1">--}}
                {{--<div class="panel panel-default">--}}
                    {{--<div class="panel-heading"><i class='fa fa-envelope-o' style="font-size: larger"></i> Edit Ongkos Kirim</div>--}}
                    {{--<div class="panel-body">--}}

                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>
    <div class="modal fade-scale" id="EditModalOngkir" role="dialog">
        <div class="modal-dialog modal-md" style="position:absolute;margin-left: -200px;">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit </h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="POST" action="">
                        <input type="text" id="txt_id" hidden>

                        <div class="input-group inputs" style="min-height: 60px;margin-top: 10px; margin-bottom: 10px;">
                            <span class="input-group-addon" style="min-width: 142px;text-align: left">Area Wilayah</span>
                            <input type="text" name="area" min="1" class="input-sm form-control" id="txt_area">
                        </div>

                        <div class="input-group inputs" style="min-height: 60px;margin-top: 10px; margin-bottom: 10px;">
                            <div class="input-group inputs" style="min-height: 60px;margin-top: 10px; margin-bottom: 10px;">
                                <span class="input-group-addon" style="min-width: 142px;text-align: left">Jenis Kendaraan</span>
                                <input type="text" name="jeniskendaraan" min="1" class="input-sm form-control" id="txt_jeniskendaraan">
                            </div>
                        </div>

                        <div class="col-md-12 input-group inputs">
                            <span class="input-group-addon" style="min-width: 142px;text-align: left">Km Pertama</span>
                            <input type="number" name="firstkm" min="1" class="input-sm form-control" id="txt_firstkm">
                            <span class="input-group-addon" style="min-width: 142px;text-align: left">Harga Km Pertama</span>
                            <input type="number" name="firstfee" min="1" class="input-sm form-control" id="txt_firstfee">
                        </div>

                        {{--<div class="col-md-6 input-group inputs">--}}
                        {{--<span class="input-group-addon" style="min-width: 142px">Harga Km Pertama</span>--}}
                        {{--<input type="text" name="title" class="input-sm form-control">--}}
                        {{--</div>--}}

                        <div class="input-group inputs" style="margin-top: 10px; margin-bottom: 10px;">
                            <span class="input-group-addon" style="min-width: 142px; text-align: left">Km Berikutnya</span>
                            <input type="number" name="nextkm" min="1" class="input-sm form-control" id="txt_nextkm">
                            <span class="input-group-addon" style="min-width: 142px; text-align: left">Harga Km Berikutnya</span>
                            <input type="number" name="nextfee" min="1" class="input-sm form-control" id="txt_nextfee">
                        </div>

                        <div class="input-group inputs">
                            <span class="input-group-addon" style="min-width: 142px;text-align: left">Km Ekstra</span>
                            <input type="number" name="extrakm" min="1" class="input-sm form-control" id="txt_extrakm">
                            <span class="input-group-addon" style="min-width: 142px;text-align: left">Harga Ekstra</span>
                            <input type="text" name="extrafee" min="1" class="input-sm form-control" id="txt_extrafee">
                        </div>

                        <div class="col-md-12 input-group inputs" style="margin-top: 10px; margin-bottom: 10px;">
                            <span class="input-group-addon" style="min-width: 142px;text-align: left">Jarak Maksimal</span>
                            <input type="number" name="distance" min="1" class="input-sm form-control" id="txt_distance">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="btn_saveongkir">Simpan</button>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>

    <div class="modal fade" id="EditDeleteOngkir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="position: absolute;margin-left: -200px;">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Konfirmasi Penghapusan</h4>
                </div>
                <div class="modal-body">
                <form class="form-horizontal" method="POST" action="">
                    <input type="text" id="txt_id" hidden>

                            <p>Anda akan menghapus Master Ongkos Kirim, aksi ini tidak dapat dibatalkan.</p>
                            <p>Apakah anda yakin ingin melanjutkan?</p>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger btn-ok" id="btndelete"><i class="fa fa-times"></i> Delete</button>
                    </div>
                </form>
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
                url: '{{url('admin/ongkir/datatable')}}',
                data: function (d) {
                    d.cab = $('[name=cab]').val();
                }
            },
            columns: [
                { data: 'nama', name: 'nama' },
                { data: 'pulau', name: 'pulau' },
                { data: 'km_a', name: 'km_a' },
                { data: 'biaya_a', name: 'biaya_a' },
                { data: 'biayaB', name: 'biayaB' },
                { data: 'ekstra', name: 'ekstra' },
                { data: 'km_max', name: 'km_max' },
                { data: 'action', name: 'action' },
                { data: 'delete', name: 'delete' }
            ],
            scrollX:        true,
            scrollCollapse: true,
            bResetDisplay: false,
            "bStateSave": true,
            fixedColumns : {
                leftColumns: 1
            }
        } );


        $(document).on('click', '#btn_delete_ongkir', function(){
            var id = $(this).val();
            $("#txt_id").val(id);
            $("#EditDeleteOngkir").modal();
        });

        $(document).on('click', '#btn_edit_ongkir', function(){
            var id = $(this).val();

            $("#txt_id").val(id);
            $("#EditModalOngkir").modal();

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url:'ongkirAjax',
                type : 'POST',
                data : {id : id},
                success:function(msg){

                    document.getElementById("txt_jeniskendaraan").disabled = true;
                    document.getElementById("txt_area").disabled = true;
                    document.getElementById("txt_firstkm").disabled = false;
                    document.getElementById("txt_firstfee").disabled = false;
                    document.getElementById("txt_nextkm").disabled = false;
                    document.getElementById("txt_nextfee").disabled = false;
                    if(msg[0]['kendaraan_id'] != 1) {
                        document.getElementById("txt_extrakm").disabled = true;
                        document.getElementById("txt_extrafee").disabled = false;
                    }else{
                        document.getElementById("txt_extrakm").disabled = true;
                        document.getElementById("txt_extrafee").disabled = true;
                    }

                    document.getElementById("txt_distance").disabled = false;


                    $("#txt_area").val(msg[0]['pulau']);
                    $("#txt_jeniskendaraan").val(msg[0]['nama']);
                    $("#txt_firstkm").val(msg[0]['km_a']);
                    $("#txt_firstfee").val(msg[0]['biaya_a']);
                    $("#txt_nextkm").val(msg[0]['km_b']);
                    $("#txt_nextfee").val(msg[0]['biaya_b']);
                    $("#txt_extrakm").val(msg[0]['km_c']);
                    $("#txt_extrafee").val(msg[0]['biaya_c']);
                    if(msg[0]['km_max'] != 1) {
                        $("#txt_distance").val(msg[0]['km_max']);
                    }

                }

            });

        });


        $("#btn_saveongkir").click(function(){
            var id = $("#txt_id").val();
            var firstkm = $("#txt_firstkm").val();
            var firstfee = $("#txt_firstfee").val();
            var nextkm = $("#txt_nextkm").val();
            var nextfee = $("#txt_nextfee").val();
            var extrakm = $("#txt_extrakm").val();
            var extrafee = $("#txt_extrafee").val();
            var distance = $("#txt_distance").val();

//            if(firstkm == "" || firstfee == "" || nextkm == "" || nextfee == "" || extrakm == "" || extrafee == "" || distance == ""){
//                alert("Silahkan lengkapi data!");
//            }else{
                $.ajax({
                    url: 'EditOngkir',
                    type : 'POST',
                    data : {
                        id : id,
                        firstkm : firstkm,
                        firstfee : firstfee,
                        nextkm : nextkm,
                        nextfee : nextfee,
                        extrakm : extrakm,
                        extrafee : extrafee,
                        distance : distance,
                    },
                    success:function(msg){
                        alert("Data berhasil diubah.");
                        location.reload();
                    }
                });
//            }
        });


        $("#btndelete").click(function(){
            var id = $("#txt_id").val();

            $.ajax({
                url: 'deleteongkir',
                type : 'POST',
                data : {
                    id : id,
                },
                success:function(msg){
                    alert("Data berhasil dihapus.");
                    $('#EditDeleteOngkir').modal('hide');
                    location.reload();
                    
//                    location.reload();
                }
            });
//            }
        });


        {{--function changeCabang(){--}}
            {{--var cab = $("#cabang").val();--}}
{{--//                                    var status = $("#status").val();--}}
            {{--$.ajax({--}}
                {{--url : '{{ url('emails')}}',--}}
                {{--data: {cab: cab},--}}
                {{--success : function(data){--}}
                    {{--window.location.href = window.location.href.replace( /[\?#].*|$/, "?cab=" + cab)--}}
                {{--}--}}
            {{--});--}}
        {{--}--}}


        {{--$( document ).ready(function() {--}}
            {{--$('#confirm-delete').on('show.bs.modal', function(e) {--}}
                {{--$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));--}}
            {{--});--}}
        {{--});--}}

    </script>
@endsection