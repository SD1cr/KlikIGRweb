@extends('app')
@section('content')

<div class="container" style="margin-top: 75px;">
    <div class="row">
        @if (session('new'))
            <div class="col-md-12">
                <div class="alert alert-success">
                    <strong>Anda sukses menambah alamat baru !</strong> <br><br>
                </div>
            </div>
        @endif
        @if (session('err'))
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <strong>Kota Anda diluar jangkauan Indogrosir !</strong> <br><br>
                </div>
            </div>
        @endif
        {!! $sidebar !!}
        {{--@if (isset($err))--}}
            {{--<div class="col-md-12 igr-flat" style="margin-top:10px;">--}}
                {{--<div class="alert alert-success igr-flat">--}}
                    {{--<strong>{{$err}}</strong>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--@endif--}}
        <div class="row" id="row_alamat">

        </div>
    </div>
</div>
<div id="modalEditAlamat" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="width:500px;">
        <div class="modal-content flat">
            <div class="modal-header">
              <b>Tambah Alamat</b>
                <div id="modal-error"></div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 style="margin-bottom:0px" id="myModalLabel" class="font-14"></h4>
            </div>
            <div id="eidt_add_body" class="modal-body">
              <form class="form" method="POST" action="{{ url('/tambah_alamat') }}">
                <div hidden="" id="div_txt_id_alamat">
                  <input type="text" class="form-control" id="txt_id_alamat" name="txt_id_alamat">
                </div>
                <div class="form-group">
                  <label for="txt_label">Label</label>
                  <input class="form-control" type="text" name="txt_label" id="txt_label" placeholder="Contoh : Rumah, Kantor, dsb." required="true">
                </div>
                <div class="form-group">
                  <label for="txt_alamat_penagihan">Alamat Pengiriman</label>
                  <input class="form-control" type="text" name="txt_alamat_penagihan" id="txt_alamat_penagihan" placeholder="Contoh : Jl.Pademangan 7 No.23" required="true">
                </div>
                <div class="form-group">
                  <label for="txt_prov">Provinsi</label>
                  <br>
                  <select class="selectpicker" data-width="270px" name="txt_province" id="txt_prov" onChange= "changeKota()" data-live-search="true">
										<option>--Pilih Provinsi--</option>
                    {!! $province !!}
                  </select>
                </div>
                <div class="form-group">
                  <label for="txt_kota">Kota</label>
                  <br>
                  <select class="selectpicker" data-width="270px" name="txt_kota" id="txt_kota" onChange= "changeDistrict()" data-live-search="true" required="true" disabled="true">
										<option>--Pilih Kota/Kab.--</option>
                      <!-- {!! $city !!} -->
                  </select>
                </div>
                <div class="form-group">
                  <label for="txt_disctrict">Kecamatan</label>
                  <br>
                  <select class="selectpicker" data-width="270px" name="txt_district" id="txt_district" onChange= "changeSubDistrict()" data-live-search="true" required="true" disabled="true">
										<option>--Pilih Kecamatan--</option>
                      <!-- {!! $district !!} -->
                  </select>
                </div>
                <div class="form-group">
                  <label for="txt_kelurahan">Kelurahan</label>
                  <br>
                  <select class="selectpicker" data-width="270px" name="txt_sub_district" id="txt_sub_district"  data-live-search="true" required="true" disabled="true">
										<option>-- Pilih Kelurahan--</option>
                      <!-- {!! $sub_district !!} -->
                  </select>
                </div>
                <div class="form-group">
                  <label for="txt_notelp">No. Telp</label>
                  <input class="form-control" type="text" name="txt_notelp" id="txt_notelp" width="270px" required="true" placeholder="085112349876">
                </div>
                <div class="form-group" id="div_simpan">
                  <input type="submit" class="btn btn-primary" value="Simpan" style="float:right;">
                </div>
                <div class="form-group" id="div_ubah">
                  <input type="submit" class="btn btn-primary" value="Ubah" style="float:right;">
                </div>
              </form>
            </div>
            <div id="modal-error" class="modal-footer"></div>
        </div>
    </div>
</div>

<div id="modalUbahDefault" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="width:500px;">
        <div class="modal-content flat">
            <div class="modal-header">
              <b>Ubah Default Alamat</b>
                <div id="modal-error"></div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 style="margin-bottom:0px" id="myModalLabel" class="font-14"></h4>
            </div>
            <div id="info_default_alamat_body" class="modal-body">
              <input hidden="" type="text" id="id_alamat" value="">
              <p>Anda yakin ingin merubah default alamat ?</p>
              <br>
            </div>
            <div class="modal-footer">
              <tr style="float:right;">
                <button type="button" id="btn_yes_default_alamat" class="btn btn-danger">Ya</button>
                <button type="button" id="btn_no_default_alamat" class="btn btn-default">Tidak</button>
              </tr>
            </div>
        </div>
    </div>
 </div>
@endsection

@section('scripts')
@endsection
