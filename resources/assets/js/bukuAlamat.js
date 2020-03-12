
var type_id;

function tambah_alamat(){
  $("#modalEditAlamat").modal('show');
  document.getElementById('div_simpan').style.display = 'block';
  document.getElementById('div_ubah').style.display = 'none';

  document.getElementById("txt_kota").disabled = true;
  document.getElementById("txt_district").disabled = true;
  document.getElementById("txt_sub_district").disabled = true;

  $("#txt_id_alamat").val("");
  $("#txt_label").val("");
  $("#txt_notelp").val("");
  $("#txt_alamat_penagihan").val("");
  $("#txt_notelp").val("");
}

function alamat_default($id){
  $("#modalUbahDefault").modal('show');
  if(type_id == "1"){
    $('#coba2').hide();
  }
  $("#id_alamat").val($id);
  // $.ajax({
  //   headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
  //   url:'alamat_default/'+$id,
  //   success:function(){
  //         REinit();
  //         // document.getElementById("btn_default_alamat_65").disabled = true;
  //   }
  // });
}

$("#btn_yes_default_alamat").click(function(){
  $.ajax({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
    url:'alamat_default/'+$("#id_alamat").val(),
    success:function(){
      REinit();
      $("#modalUbahDefault").modal('hide');
      cartReload();
      // document.getElementById("btn_default_alamat_65").disabled = true;
    }
  });
});

$("#btn_no_default_alamat").click(function(){
  $("#modalUbahDefault").modal('hide');
});

function REinit() {
  $.ajax({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
    url:'get_alamat',
    success:function(msg){
      //type_id = msg[0]['type_id'];
      var rows = '';
      if(msg.length == 0 && (msg[0]['type_id'] != 1 && msg[0]['type_id'] != 2)){ 
        rows += '<div class="col-md-4" style="margin-left:15px;height:30px;margin-top:-20px;">';
        rows += '<br>';
        rows += '<input class="btn btn-primary flat" type="button" id="btn_tambah_alamat" onclick="tambah_alamat()" value="Tambah Alamat">';
        rows += '</div>';
        rows += '<div class="col-md-4" style="margin-left:30px;margin-bottom:15px;height:30px;">';
        rows += '</div>';
      }
      else{
        if(msg[0]['type_id'] != 1 && msg[0]['type_id'] != 2){
          rows += '<div class="col-md-4" style="margin-left:15px;height:30px;margin-top:-20px;">';
          rows += '<br>';
          rows += '<input class="btn btn-primary flat" type="button" id="btn_tambah_alamat" onclick="tambah_alamat()" value="Tambah Alamat">';
          rows += '</div>';
          rows += '<div class="col-md-4" style="margin-left:30px;margin-bottom:15px;height:30px;">';
          rows += '</div>';
          type_id = msg[0]['type_id'];
        }
        else {
          // rows += '<div class="col-md-4" style="margin-left:30px;margin-bottom:15px;height:30px;">';
          // rows += '</div>';
        }

        for (var i = 0; i < msg.length; i++) {
          if(i > 3 && i % 2 == 0){
            rows += '<div class="col-md-3" style="margin-left=50px;padding-left:20px;">';
            rows += '</div>';
            rows += '<div class="col-md-4" style="margin-left:38px;margin-bottom:15px">';
          }else{
            rows += '<div class="col-md-4" style="margin-left:30px;margin-bottom:15px">';
          }
          if(i == 0){
            rows +=   '<div class="row" style="background-color:#EEEEEE;height:240px;">';   
            rows +=     '<div style="margin-top:15px;margin-left:15px;">';
          }
          else{
            rows +=   '<div class="row" style="background-color:#FFFFFF;height:240px;border:2px solid #EEEEEE;">';
            rows +=     '<div style="margin-top:15px;margin-left:15px;">';
          }
          rows +=         '<b><ul id="ul_email">'+msg[i]['label']+'</ul></b>';
          rows +=         '<ul id="ul_nama">'+msg[i]['nama']+'</ul><br>';
          rows +=         '<ul id="ul_alamat">'+"<ul>"+msg[i]['address']+', Prov.'+msg[i]['province_name']+',                '+msg[i]['city_name']+', Kec.'+msg[i]['district_name']+', Kel. '+msg[i]['sub_district_name']+', '+msg[i]['email']+"</ul>"+'</ul>';
          rows +=         '<ul id="ul_telp">'+'Telp : '+msg[i]['phone_number']+'</ul>';
          rows +=         '<br>';
          if(msg[0]['type_id'] != 1 && msg[0]['type_id'] != 2){   
            rows +=         '<a href="#" id="edit_alamat" onClick="editAlamat('+msg[i]['id']+')">Ubah Alamat</a>';
            rows +=         '&nbsp;&nbsp;<a href="#" id="edit_alamat" onClick="deleteAlamat('+msg[i]['id']+')">Hapus Alamat</a>';
          }
          // data-toggle="modal" data-target="#modalEditAlamat"
          if(msg[i]['flag_default'] == 1){
            rows +=         '&nbsp;&nbsp;<button class="btn btn-default flat" id="btn_default_alamat_'+msg[i]['id']+'" onclick="alamat_default('+msg[i]['id']+')" type="submit" style="height: 32px;" disabled="disabled">Pilih Default</button>';
            rows +=         '<img src="../resources/assets/icon/ok.png" width="30px" height="30px" align="right" style="margin-right:20px;">';
          }else{
            rows +=         '&nbsp;&nbsp;<button class="btn btn-default flat" id="btn_default_alamat_'+msg[i]['id']+'" onclick="alamat_default('+msg[i]['id']+')" type="submit" style="height: 32px;">Pilih Default</button>';
          }
          rows +=         '</ul>';
          rows +=      '</div>';
          rows +=   '</div>';
          rows += '</div>';
        }
      }

      $("#row_alamat").html(rows);

      // alert(msg[0]['address']+', '+msg[0]['province_name']+', '+msg[0]['city_name']+', '+msg[0]['district_name']);
    }
  });
}

function changeKota(){
  var prov_id = $("#txt_prov").val();
  $.ajax({
    url : 'get_kota',
    data : {id_prov : prov_id},
    success:function(msg){
      document.getElementById("txt_kota").disabled = false;
      $("#txt_kota").html(msg);
      $("#txt_kota").selectpicker('refresh');
    }
  });
}

function changeDistrict(){
  var city_id = $("#txt_kota").val();
  $.ajax({
    url : 'get_district',
    data : {id_kota : city_id},
    success : function(msg){
      document.getElementById("txt_district").disabled = false;
      $("#txt_district").html(msg);
      $("#txt_district").selectpicker('refresh');
    }
  });
}

function changeSubDistrict(){
  var district_id = $("#txt_district").val();
  $.ajax({
    url : 'get_sub_district',
    data : {id_district : district_id},
    success : function(msg){
      document.getElementById("txt_sub_district").disabled = false;
      $("#txt_sub_district").html(msg);
      $("#txt_sub_district").selectpicker('refresh');
    }
  });
}

function editAlamat($id){
  $("#modalEditAlamat").modal('show');
  document.getElementById('div_simpan').style.display = 'none';
  document.getElementById('div_ubah').style.display = 'block';

  document.getElementById("txt_kota").disabled = false;
  $("#txt_kota").selectpicker('refresh');
  document.getElementById("txt_district").disabled = false;
  $("#txt_district").selectpicker('refresh');
  document.getElementById("txt_sub_district").disabled = false;
  $("#txt_sub_district").selectpicker('refresh');

  $.ajax({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
    url:'edit_alamat/'+$id,
    success : function(msg){
      $("#txt_id_alamat").val(msg[0]['id']);
      $("#txt_label").val(msg[0]['label']);
      $("#txt_notelp").val(msg[0]['phone_number']);
      $("#txt_alamat_penagihan").val(msg[0]['address']);

      $('#txt_prov').selectpicker('val', msg[0]['province_id']);

      $("#txt_kota").html("<option style='font-size:12px;' value='"+msg[0]['city_id']+"'></option>");
      $("#txt_district").html("<option style='font-size:12px;' value='"+msg[0]['district_id']+"'></option>");
      $("#txt_sub_district").html("<option style='font-size:12px;' value='"+msg[0]['sub_district_id']+"'></option>");
      changeKota();
      changeDistrict();
      changeSubDistrict();
      $.ajax({
        success:function(){
          $('#txt_kota').selectpicker('val', msg[0]['city_id']);
          $('#txt_district').selectpicker('val', msg[0]['district_id']);
          $('#txt_sub_district').selectpicker('val', msg[0]['sub_district_id']);
        }
      });
    }
  });
}

function deleteAlamat($id){
  $.ajax({
    url : 'delete_alamat/'+$id,
    success:function(msg){
      $(document).ready(function(){
        REinit();
      });
    }
  });
}


function UpdateFlagAddress($id){
  $.ajax({
    url : 'updateflag/'+$id,
    success: function(data){
      if(data == '1'){
        location.reload();
      }else{
        $('#modal-error').html('<div class="alert alert-danger">' + data + '</div>');
      }
    }
  });
}


function getChangeAddress(){
  $('.modal-dialog').width('500px');
  $('#myModalLabel').text("Alamat Anda");
  $('#modal-core').html("<span ><i class='fa fa-spinner fa-3x fa-spin'></i>&nbsp;</span>");
  $('#modal-error').html("");
  $.ajax({
    type: "GET",
    url: getAddressChangeDialog,
    success: function(data){
      if(data == undefined || data == ""){
        $('#modal-core').html('Anda Belum Membuat Alamat');
      }else{
        $('#modal-core').html($(data));
      }
    }
  });
}
