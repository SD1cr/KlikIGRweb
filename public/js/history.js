/**
 * Created by sd1 on 7/13/2015.
 */
function getHistoryDetail(TRID){
    $('.modal-dialog').width('');
    $('#myModalLabel').text("Detail Pesanan Anda");
    $('#modal-core').html("<span ><br/><i class='fa fa-spinner fa-3x fa-spin'></i><br/>&nbsp;</span>");
    $('#modal-error').html("");
    $.ajax({
        type: "GET",
        url: getHistoryDialogURL,
        data: { trid: TRID },
        success: function(data){
            if(data == undefined || data == ""){
                $('#modal-core').html('Gagal Memuat Histori Pesanan');
            }else{
                $('#modal-core').html($(data));
            }
        }
    });
}

function getHistoryReorder(TRID){
    $('.modal-dialog').width('');
    $('#myModalLabel').text("Riwayat Pesanan Anda");
    $('#modal-core').html("<span ><br/><i class='fa fa-spinner fa-3x fa-spin'></i><br/>&nbsp;</span>");
    $('#modal-error').html("");
    $.ajax({
        type: "GET",
        url: getHistoryDialogURL,
        data: { trid: TRID },
        success: function(data){
            if(data == undefined || data == ""){
                $('#modal-core').html('Gagal Memuat Histori Pesanan');
            }else{
                $('#modal-core').html($(data));
                $('#modal-core').append("<a style='width: 50%' class='btn btn-danger flat'>RE-ORDER PESANAN INI</a>");
            }
        }
    });
}