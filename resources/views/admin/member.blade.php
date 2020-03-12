@extends('cms1')

@section('content')  
    <div class="container" style="margin-top: 60px;">
        <div class="row" style="margin-left: 0px;padding-left: 80px;">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-dashboard" style="font-size: larger"></i> Admin Dashboard</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" id="search-form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                            @if (\Auth::user('users_admin')->role != 2)
                                <div class="form-group">
                                    <label for="combo_cabang">&nbsp;&nbsp;Filter Cabang : </label>
                                    <select id="cabang" name="cab" class="selectpicker" data-live-search="true" onchange="changeCabang()">
                                        <option style="font-size: 12px;" value="%">All Cabang </option>
                                        {!! $cab !!}
                                    </select>
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="status">&nbsp;&nbsp;Tipe Member : </label>
                                <select style="padding-left: 20px;" class="selectpicker" data-width="270px" name="tipemember" id="statusSelect">
                                    <option style="font-size: 12px;" value="%">All Member </option> 
                                    {!! $type !!}
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
                                    <th class="font-14" style="text-align: center;">Cabang</th>
                                    <th class="font-14" style="text-align: center;">Email</th>
                                    <th class="font-14" style="text-align: center;">Nama</th>
                                    <th class="font-14" style="text-align: center;">Kode Member</th>
                                    <th class="font-14" style="text-align: center;">Jenis</th>
                                    <th class="font-14" style="text-align: center;">No.Hp</th>
                                    <th class="font-14" style="text-align: center;">Alamat aktif</th>
                                    <th class="font-14" style="text-align: center;">Aksi</th>
                                    {{--<th class="font-14" style="text-align: center;">View</th>--}}
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

        $(document).on('click', '#btn_edit', function(){
            var id = $(this).val();
            var hp = $(this).parent().prev().prev().text();
            var alamat = $(this).parent().prev().text();

            $("#txt_id").val(id);
            $("#txt_hp").val(hp);
            $("#txt_alamat").val(alamat);
            $("#EditModal").modal();
            $("#kode_pos").val("");

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url:'get_alamat_admin',
                type : 'POST',
                data : {id : id},
                success:function(msg){
                    if(msg[0]['type_id'] != 2){
                        document.getElementById("txt_hp").disabled = true;
                        document.getElementById("txt_alamat").disabled = true;
                        document.getElementById("combo_provinsi").disabled = true;
                        document.getElementById("combo_kota").disabled = true;
                        document.getElementById("combo_kecamatan").disabled = true;
                        document.getElementById("combo_kelurahan").disabled = true;
                        document.getElementById("txt_type").disabled = true;
                        document.getElementById("nama_npwp").disabled = true;
                        document.getElementById("alamat_npwp").disabled = true;
                        document.getElementById("nomor_npwp").disabled = true;
                        document.getElementById("minor").disabled = true;
                        document.getElementById("shipping").disabled = true;
                        document.getElementById("btn_save").disabled = true;
                    }else{
                        document.getElementById("txt_hp").disabled = false;
                        document.getElementById("txt_alamat").disabled = false;
                        document.getElementById("combo_provinsi").disabled = false;
                        document.getElementById("combo_kota").disabled = false;
                        document.getElementById("combo_kecamatan").disabled = false;
                        document.getElementById("combo_kelurahan").disabled = false;
                        document.getElementById("txt_type").disabled = true;
                        document.getElementById("nama_npwp").disabled = true;
                        document.getElementById("alamat_npwp").disabled = true;
                        document.getElementById("nomor_npwp").disabled = true;
                        document.getElementById("minor").disabled = false;
                        document.getElementById("shipping").disabled = false;
                        document.getElementById("btn_save").disabled = false;
                    }

                    changeKecamatan(msg[0]['city_id'], msg[0]['district_id']);
                    changeKelurahan(msg[0]['district_id'], msg[0]['sub_district_id']);

                    $("#combo_provinsi").val(msg[0]['province_id']);
                    $("#combo_provinsi").selectpicker('refresh');

                    $("#combo_kota").val(msg[0]['city_id']);
                    $("#combo_kota").selectpicker('refresh');

                    $("#combo_kecamatan").val(msg[0]['district_id']);
                    $("#combo_kecamatan").selectpicker('refresh');

                    $("#combo_kelurahan").val(msg[0]['sub_district_id']);
                    $("#combo_kelurahan").selectpicker('refresh');

                    $("#kode_pos").val(msg[0]['postal_code']);

                    $("#txt_type").val(msg[0]['type']);
                    $("#txt_type").selectpicker('refresh');

                    $("#nama_npwp").val(msg[0]['npwp_name']);
                    $("#nama_npwp").selectpicker('refresh');

                    $("#alamat_npwp").val(msg[0]['npwp_address']);
                    $("#alamat_npwp").selectpicker('refresh');

                    $("#nomor_npwp").val(msg[0]['npwp_number']);
                    $("#nomor_npwp").selectpicker('refresh');

                    $("#minor").val(msg[0]['minor']);
                    $("#minor").selectpicker('refresh');

                    $("#shipping").val(msg[0]['shipping_fee']);
                    $("#shipping").selectpicker('refresh')

//                    $("#combo_kelurahan").val(msg[0]['sub_district_id']);
//                    $("#combo_kelurahan").selectpicker('refresh');
//
//                    $("#combo_kelurahan").val(msg[0]['sub_district_id']);
//                    $("#combo_kelurahan").selectpicker('refresh')

                }

            });

        });

        //        $(document).on('click', '#btn_edit', function(){
        //            var id = $(this).val();
        //            var hp = $(this).parent().prev().prev().text();
        //            var alamat = $(this).parent().prev().text();
        //
        //            $("#txt_id").val(id);
        //            $("#txt_hp").val(hp);
        //            $("#txt_alamat").val(alamat);
        //            $("#EditModal").modal();
        //            $("#kode_pos").val("");
        //
        //            $.ajax({
        //                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
        //                url:'get_alamat_admin',
        //                type : 'POST',
        //                data : {id : id},
        //                success:function(msg){
        //
        //                    changeKecamatan(msg[0]['city_id'], msg[0]['district_id']);
        //                    changeKelurahan(msg[0]['district_id'], msg[0]['sub_district_id']);
        //
        //                    $("#combo_provinsi").val(msg[0]['province_id']);
        //                    $("#combo_provinsi").selectpicker('refresh');
        //
        //                    $("#combo_kota").val(msg[0]['city_id']);
        //                    $("#combo_kota").selectpicker('refresh');
        //
        //                    $("#combo_kecamatan").val(msg[0]['district_id']);
        //                    $("#combo_kecamatan").selectpicker('refresh');
        //
        //                    $("#combo_kelurahan").val(msg[0]['sub_district_id']);
        //                    $("#combo_kelurahan").selectpicker('refresh');
        //
        //                    $("#kode_pos").val(msg[0]['postal_code'])
        //                }
        //
        //            });
        //
        //        });


        var projTable = $('#dtTable').DataTable( {
            dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
            "<'row'<'col-xs-12't>>"+
            "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
            processing: true,
            serverSide: true,
            ordering: true,
            searching : true,
            dom: 'Blfrtip',
            autoWidth: false,
            iDisplayLength: 10,
            ajax: {
                url: '{{url('admin/members/datatable')}}',
                data: function (d) {
                    d.cab = $('[name=cab]').val();
                    d.tipemember = $('[name=tipemember]').val();
                }
            },

            columns: [
                { data: 'name', name: 'name'},
                { data: 'email', name: 'email'},
                { data: 'nama', name: 'nama'},
                { data: 'kodemember', name: 'kodemember'},
                { data: 'type', name: 'type'},
                { data: 'phone_number', name: 'phone_number'},
                { data: 'address', name: 'address'},
                { data: 'edit', name: 'aksi'}
//                { data: 'view', name: 'view'}
            ],

            scrollX:        true,
            scrollCollapse: true,
            bResetDisplay: false,
            "bStateSave": true,
            fixedColumns : {
                leftColumns: 1
            }
        } );

        $('#search-form').on('submit', function(e) {
            projTable.draw();
            e.preventDefault();
        });

        function changeCabang(){
            var cab = $("#cabang").val();
            $.ajax({
                url : '{{ url('dashboard')}}',
                data: {cab: cab},
                success : function(data){
                    window.location.href = window.location.href.replace( /[\?#].*|$/, "?cab=" + cab)
                }
            });
        }


        $(function() {
            changePronvinsi();
            changeKota();
        });

        function changePronvinsi(){
            $.ajax({
                url : 'get_provinsi_admin',
                success:function(msg){
                    $("#combo_provinsi").html(msg);
                    $("#combo_provinsi").selectpicker('refresh');
                }
            });
        }

        function changeKota(){
            var id_provinsi = $("#combo_provinsi").val();
            $.ajax({
                url : 'get_kota_admin',
                data : {id : id_provinsi},
                type : 'POST',
                success : function(msg){
                    $("#combo_kota").html(msg);
                    $("#combo_kota").selectpicker('refresh');
                }
            });
        }

        function changeKecamatan($data, $kecamatan){
            var id_kota = $("#combo_kota").val();

            if($data != null){
                id_kota = $data;
            }

            $.ajax({
                url : 'get_kecamatan_admin',
                data : {id : id_kota},
                type : 'POST',
                success : function(msg){
                    $("#combo_kecamatan").html(msg);
                    $("#combo_kecamatan").selectpicker('refresh');
                    if($kecamatan != null){
                        $("#combo_kecamatan").val($kecamatan);
                        $("#combo_kecamatan").selectpicker('refresh');
                    }
                }
            });
        }

        function changeKelurahan($data, $kelurahan){
            var id_kecamatan = $("#combo_kecamatan").val();

            if($data != null){
                id_kecamatan = $data;
            }
            $.ajax({
                url : 'get_kelurahan_admin',
                data : {id : id_kecamatan},
                type : 'POST',
                success : function(msg){
                    $("#combo_kelurahan").html(msg);
                    $("#combo_kelurahan").selectpicker('refresh');
                    if($kelurahan != null){
                        $("#combo_kelurahan").val($kelurahan);
                        $("#combo_kelurahan").selectpicker('refresh');
                    }
                }
            });
        }

        function changeKodePos(){
            var id_kelurahan = $("#combo_kelurahan").val();
            $.ajax({
                url : 'get_kodepos_admin',
                data : {id : id_kelurahan},
                type : 'POST',
                success : function(msg){
                    $("#kode_pos").val(msg);
                }
            });
        }

    </script>


@endsection
