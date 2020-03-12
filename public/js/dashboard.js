function downloadCSV(trID){     
    $.ajax({
        type: "POST",
        url: getCSVDownloadURL,
        data: { trid: trID },
        success: function(data){
            arrayData = data.split("!@#$%");
            $("#filenm").val(arrayData[1]);
            $("#filedata").val(arrayData[0]);
            $("#hiddenform").submit();

            if($("#state" + trID).text() == 'Belum di Download'){
                $("#state" + trID).text('Sudah di Download');
                $("#state" + trID).css( "color", "Blue" );
                $("#tdStCh" + trID).html("<select id=\"stCh"+ trID +"\" data-width=\'125px\' onchange=\"chStatusKirim("+ trID +")\">\r\n\t\t\t\t\t\t\t\t\t\t\t\t<option value=\'Proses\' selected>Dalam Proses<\/option>\r\n\t\t\t\t\t\t\t\t\t\t\t\t<option value=\'Kirim\'>Sudah Dikirim<\/option>\r\n\t\t\t\t\t\t\t\t\t\t\t\t<\/select>");
                $("#stCh"+ trID).selectpicker();
            }
        }
    });

}

function chStatusKirim(trID){
	var sel = document.getElementById("stCh" + trID);
	if(sel.value == "Kirim"){
		$.ajax({
			type: "POST",
			url: updateStatusKirimUrl,
			data: { trid: trID },
			success: function(data){
				if(data == "OK"){
					$("#tdStCh" + trID).html("Sudah Dikirim");				
				}
			}
		});
	}
}

function getMemberInfo(id){ 
    $('.modal-dialog').width('');
    $('#myModalLabel').text("Informasi Member");
    $('#modal-core').html("<span ><br/><i class='fa fa-spinner fa-3x fa-spin'></i><br/>&nbsp;</span>");
    $('#modal-error').html("");
    $.ajax({
        type: "GET",
        url: getMemberOngkirURL,    
        data: { id: id },
        success: function(data){
            if(data == undefined || data == ""){
                $('#modal-core').html('Gagal Memuat Konfirmasi');
            }else{
                $('#modal-core').html($(data));
            }
            $('#btnapprove').attr('disabled', false);
        }
    });
}
  
