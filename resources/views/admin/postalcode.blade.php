@extends('cms1')
{{--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCrrmehQr0CFsfbpsJNZyacdTQpxFHNwrY&callback=init_map"></script>--}}
@section('content')
    <html>
    <head>
        <title>Geocoding service</title>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="utf-8">
        <style>
            #map {
                height: 100%;
            }
            /* Optional: Makes the sample page fill the window. */
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }
        </style>
    </head>
    <body>
    {{--<div id="map"></div>--}}
    <script>
        function getMarkerDistanceAjax(data) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                dataType: 'JSON',
                type: 'POST',
                url: 'getviewmarker',
                data: {},
                beforeSend: function () {
                },
                success: function (response) {
                    initMap(response, data);
                },
                error: function (response) {
                    console.log(response);
                }
            });
        }

        var geocoder;
        var map;
        var address = "Jakarta";

        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 8,
                center: {lat: -34.397, lng: 150.644}
            });
            geocoder = new google.maps.Geocoder();
            codeAddress(geocoder, map);
        }

        function codeAddress(geocoder, map) {
            geocoder.geocode({'address': address}, function(results, status) {
                if (status === 'OK') {
                    map.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location
                    });
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        }

    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCrrmehQr0CFsfbpsJNZyacdTQpxFHNwrY&callback=initMap">
    </script>
    </body>
    </html>

    <div class="container" style="margin-top: 90px;">

        <div class="col-md-10 col-md-offset-1">
            {{--<div class="panel-group">--}}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a>Proses Penambahan Jarak</a>
                    </h4>
                </div>
                <div class="panel-body">
                    <form id ='confirm-form' class="form-horizontal" role="form" enctype="multipart/form-data" method="POST" action="{{ url('getpostalcode') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                        <div class="form-group" style="margin-left: 300px;">
                            <div class="">
                                <button type="submit" class="btn btn-default btn-lg">
                                    <span class="glyphicon glyphicon-adjust" aria-hidden="true"></span> Proses Ulang Jarak
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="alert alert-danger fade in" style="margin-top: 30px;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4>Oopss ! Ada<i style="font-style: italic; font-weight: bold"> {{ $countdistance }} </i>alamat yang belum lengkap jaraknya !</h4>
                    </div>

                    <form class="form-horizontal" role="form" method="POST" id="search-form">
                        <div class="form-group">
                            <label for="status">&nbsp;&nbsp;Filter Alamat : </label>
                            <select style="padding-left: 20px;" class="selectpicker" data-width="270px" name="tipestatus" id="statusSelect">
                                <option style="font-size: 12px;" value="x">All Status </option>
                                <option style="font-size: 12px;" value="y">Sudah Lengkap </option>
                                <option style="font-size: 12px;" value="z">Belum Lengkap </option>
                            </select>
                            <button type="submit" class="btn btn-primary">
                                <i style='color:white' class='fa fa-eye'></i>
                                Lihat
                            </button>
                        </div>
                        <hr>
                    </form>
                    <div class="col-xs-12 table-responsive">
                        <table class="table" id="dtTable">
                            <thead>
                            <tr>
                                <th class="font-14" style="text-align: center;">Tujuan</th>
                                <th class="font-14" style="text-align: center;">Cabang</th>
                                <th class="font-14" style="text-align: center;">Jarak</th>
                                <th class="font-14" style="text-align: center;">Proses Manual</th>
                                {{--<th class="font-14" style="text-align: center;">Map</th>--}}

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

    <div class="modal fade-scale" id="EditModalDistance" role="dialog">
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
                        <span>Informasi Alamat Indogrosir :</span>
                        <hr style='margin-top: 5px;margin-bottom: 5px;'/>
                        <div class="input-group inputs" style="min-height: 60px;margin-top: 10px; margin-bottom: 10px;">
                            <span class="input-group-addon" style="min-width: 142px;text-align: left">Alamat Cabang</span>
                            <input type="text" name="area" min="1" class="input-sm form-control" id="txt_asal">
                        </div>

                        <div class="input-group inputs" style="min-height: 60px;margin-top: 10px; margin-bottom: 10px;">
                            <span class="input-group-addon" style="min-width: 142px;text-align: left">Latitude</span>
                            <input type="text" name="latitude" min="1" class="input-sm form-control" id="txt_latitude">
                        </div>

                        <div class="input-group inputs" style="min-height: 60px;margin-top: 10px; margin-bottom: 10px;">
                            <span class="input-group-addon" style="min-width: 142px;text-align: left">Longitude</span>
                            <input type="text" name="longitude" min="1" class="input-sm form-control" id="txt_longitude">
                        </div>
                        <hr style='margin-top: 15px;margin-bottom: 5px;'/>
                        <span>Informasi Alamat Member :</span>
                        <div class="input-group inputs" style="min-height: 60px;margin-top: 10px; margin-bottom: 10px;">
                            <span class="input-group-addon" style="min-width: 142px;text-align: left">Alamat Member</span>
                            <input type="text" name="area" min="1" class="input-sm form-control" id="txt_tujuan">
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="combo_provinsi">Provinsi : </label>
                            <select class="selectpicker col-md-6" data-live-search="true" name="combo_provinsi" id="combo_provinsi" onchange="changeKota()" data-title="Pilih Provinsi!" >

                            </select>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="combo_kota">Kota/Kab. : </label>
                            <select class="selectpicker col-md-6" data-live-search="true" name="combo_kota" id="combo_kota" onchange="changeKecamatan()" data-title="Pilih Kota/Kabupaten!"></select>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="combo_kecamatan">Kecamatan : </label>
                            <select class="col-md-6 selectpicker" data-live-search="true" name="combo_kecamatan" id="combo_kecamatan" onchange="changeKelurahan()" data-title="Pilih Kecamatan!"></select>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="combo_kelurahan">Kelurahan : </label>
                            <select class="col-md-6 selectpicker" data-live-search="true" name="combo_kelurahan" id="combo_kelurahan" data-title="Pilih Kelurahan!" onchange=""></select>
                        </div>

                        <div class="input-group inputs" style="min-height: 60px;margin-top: 10px; margin-bottom: 10px;">
                            <span class="input-group-addon" style="min-width: 142px;text-align: left">Latitude</span>
                            <input type="text" name="latitude1" min="1" class="input-sm form-control" id="txt_latitude1">
                        </div>

                        <div class="input-group inputs" style="min-height: 60px;margin-top: 10px; margin-bottom: 10px;">
                            <span class="input-group-addon" style="min-width: 142px;text-align: left">Longitude</span>
                            <input type="text" name="longitude1" min="1" class="input-sm form-control" id="txt_longitude1">
                        </div>

                        <hr style='margin-top: 15px;margin-bottom: 5px;'/>
                        <span>Informasi Jarak terhitung :</span>
                        <div class="input-group inputs" style="min-height: 60px;margin-top: 10px; margin-bottom: 10px;">
                            <span class="input-group-addon" style="min-width: 142px;text-align: left">Jarak</span>
                            <input type="text" name="distance" min="1" class="input-sm form-control" id="txt_distance">
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


    <script>


        $(document).ready(function() {

            $("#inputcsv").fileinput({
                browseClass: "btn btn-primary btn-block",
                showCaption: false,
                showRemove: false,
                showUpload: false
            });

        });

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
                url: '{{url('getviewaddress/datatable')}}',
                data: function (d) {
                    d.tipestatus = $('[name=tipestatus]').val();
                }
            },

            columns: [
                { data: 'tujuan', name: 'tujuan'},
                { data: 'branchaddress', name: 'branchaddress'},
                { data: 'distance', name: 'distance'},
                { data: 'manual', name: 'manual'}
//                { data: 'map', name: 'map'}
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


        $(document).on('click', '#btn_edit_distance', function(){
            var id = $(this).val();

            $("#txt_id").val(id);
            $("#EditModalDistance").modal();


            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url:'getdistanceajax',
                type : 'POST',
                data : {id : id},
                success:function(msg){       
                    if(msg[0]['distance'] == 0){
                        document.getElementById("txt_distance").disabled = true;
                        document.getElementById("txt_asal").disabled = true;
                        document.getElementById("txt_longitude").disabled = true;
                        document.getElementById("txt_latitude").disabled = true;
                        document.getElementById("txt_tujuan").disabled = false;
                        document.getElementById("combo_provinsi").disabled = false;
                        document.getElementById("combo_kota").disabled = false;
                        document.getElementById("combo_kecamatan").disabled = false;
                        document.getElementById("combo_kelurahan").disabled = false;
                        document.getElementById("btn_saveongkir").disabled = false;
                        document.getElementById("txt_longitude1").disabled = true;
                        document.getElementById("txt_latitude1").disabled = true;

                    }else{
                        document.getElementById("txt_distance").disabled = true;
                        document.getElementById("txt_asal").disabled = true;
                        document.getElementById("txt_longitude").disabled = true;
                        document.getElementById("txt_latitude").disabled = true;
                        document.getElementById("txt_tujuan").disabled = false;
                        document.getElementById("combo_provinsi").disabled = false;
                        document.getElementById("combo_kota").disabled = false;
                        document.getElementById("combo_kecamatan").disabled = false;
                        document.getElementById("combo_kelurahan").disabled = false;
                        document.getElementById("btn_saveongkir").disabled = true;
                        document.getElementById("txt_longitude1").disabled = true;
                        document.getElementById("txt_latitude1").disabled = true;
                    }



                    $("#txt_distance").val(msg[0]['distance']);
                    $("#txt_longitude").val(msg[0]['lg']);
                    $("#txt_latitude").val(msg[0]['lt']);
                    $("#txt_longitude1").val(msg[0]['lg1']);
                    $("#txt_latitude1").val(msg[0]['lt1']);
                    $("#txt_asal").val(msg[0]['branchaddress']);
                    $("#txt_tujuan").val(msg[0]['asaladdress']);
                    $("#combo_provinsi").val(msg[0]['province_name']);
                    $("#combo_kota").val(msg[0]['city_name']);
                    $("#combo_kecamatan").val(msg[0]['district_name']);
                    $("#combo_kelurahan").val(msg[0]['sub_district_name']);

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

                }


            });

        });

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


        $("#btn_saveongkir").click(function(){

            var id = $("#txt_id").val();
            var province_name = $("#combo_provinsi").val();
            var citi_name = $("#combo_kota").val();
            var district_name = $("#combo_kecamatan").val();
            var sub_district_name = $("#combo_kelurahan").val();
            var longitude = $("#txt_longitude").val();
            var latitude = $("#txt_latitude").val();

//            if(firstkm == "" || firstfee == "" || nextkm == "" || nextfee == "" || extrakm == "" || extrafee == "" || distance == ""){
//                alert("Silahkan lengkapi data!");
//            }else{
            $.ajax({
                url: 'EditJarakOngkir',
                type : 'POST',
                data : {
                    id : id,
                    province_name : province_name,
                    citi_name : citi_name,
                    district_name : district_name,
                    sub_district_name : sub_district_name,
                    latitude : latitude,
                    longitude : longitude,
                },
                success:function(msg){
                    if(msg == "false"){
                        alert("Maaf, Alamat yang anda masukkan tidak ditemukan");
                    }else{
                        alert("Data berhasil diubah.");
                        location.reload();
                    }

                }
            });
//            }
        });

    </script>

@endsection