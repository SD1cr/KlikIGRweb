function getCartDetail(){
    $('.modal-dialog').width('');
    $('#myModalLabel').text("Keranjang Anda");
    $('#modal-core').html("<span ><i class='fa fa-spinner fa-3x fa-spin'></i>&nbsp;</span>");
    $('#modal-error').html("");
    $.ajax({
        type: "GET",
        url: getCartDialogURL,
        success: function(data){
            if(data == undefined || data == ""){
                $('#modal-core').html('Anda tidak memiliki Barang di Keranjang');
            }else{
                $('#modal-core').html($(data));
            }
        }
    });
}

function getLoadPage(){
    $('.modal-dialog').width('');
    $('#myModalLabel').text("Lokasi Anda");
    $('#modal-core').html("<span ><i class='fa fa-spinner fa-3x fa-spin'></i>&nbsp;</span>");
    $('#modal-error').html("");
}



function addToCart($a){
    var PLU, QTY;
    PLU =$("[name=radioplu]:checked").val();
    QTY = $('.QTYSELECT').val();
    $('#modal-error').html("");
    $.ajax({
        type: "POST",
        url: addCartURL,
        data: { prdcd: PLU, qty: QTY },
        success: function(data){
            //if(data == '2'){
            //    $('#myModal').modal('hide');
            //    $.notify("Keranjang Anda sudah mencapai batasan maksimal belanja", {
            //        className:'danger',
            //        globalPosition: 'top right'
            //    });
            //    cartReload();
            //}
            //else
            if(data == '1'){
                if($a == 1){
                    $('#myModal').modal('hide');
                    $.notify("Item Berhasil Ditambahkan !", {
                        className:'info',
                        globalPosition: 'top right'
                    });
                    cartReload();
                }else{
                    $.notify("Item Berhasil Ditambahkan !", {
                        className:'info',
                        globalPosition: 'top right'
                    }); 
                    cartReload();
                    getCartDetail();
                    $('#myModal').modal('show');
                }
            }else{
                $('#modal-error').html('<div class="alert alert-danger">' + data + '</div>');
                $('#validateQty').html('<div class="alert alert-danger">' + data + '</div>');
                $('#btnsubmit').attr('disabled', false);
            }
            $(this).attr('disabled', false);
        }
    });
}

//$("#btn_checkout").click(function(){
//    $.ajax({
//        url:'checkout/'+$("#nomorpo").val(),
//        success:function(){
//            REinit();
//            // document.getElementById("btn_default_alamat_65").disabled = true;
//        }
//    });
//});


//function addToCart(){
//    var PLU = [];
//    var QTY = [];
//
//    //$('.PLUArray').val();
//
//    $.each($('.PLUArray'), function(index){
//        PLU.push(this.value);
//    });
//    $.each($('.QTYArray'), function(index){
//        QTY.push(this.value);
//    });
//
//    $('#modal-error').html("");
//    $.ajax({
//        type: "GET",
//        url: addCartURL,
//        data: { prdcd: PLU, qty: QTY },
//        success: function(data){
//            if(data == '1'){
//                $('#myModal').modal('hide');
//                cartReload();
//            }else{
//                $('#modal-error').html('<div class="alert alert-danger">' + data + '</div>');
//                $('#btnsubmit').attr('disabled', false);
//            }
//            $(this).attr('disabled', false);
//        }
//    });
//}

function changeCartQty(){
    var status = 0;
    var error = "";
    $.each($('.cart'), function(index) {
        var PLU = [];
        var QTY = [];
        var currentAddr = $(this).data("id");

        $.each($('.PLUArray' + currentAddr), function(index){
            PLU.push(this.value);
        });
        $.each($('.QTYArray' + currentAddr), function(index){
            QTY.push(this.value);
        });
        $('#modal-error').html("");
        $.ajax({
            type: "GET",
            url: updateCartURL,
            async:false,
            data: { prdcd: PLU, qty: QTY, addr: currentAddr },
            success: function(data){
                if (data == '1') {
                    status = 1;
                } else {
                    error = data;
                }
            }
        });
    });
    if(status == 1){
        cartReload();
        getCartDetail();
    }else{
        $('#modal-error').html('<div class="alert alert-danger">' + error + '</div>');
    }
}
//function changeCartQty(PLU, QTY){
//    $.ajax({
//        type: "PUT",
//        url: updateCartURL,
//        data: { prdcd: PLU, qty: QTY },
//        success: function(data){
//            if(data == '1'){
//                cartReload();
//                getCartDetail();
//            }else{
//                $('#modal-error').html('<div class="alert alert-danger">' + data + '</div>');
//            }
//        }
//    });
//}
function deleteCart(PLU){
    var currentAddr = $(this).data("id");
    $.ajax({
        type: "DELETE",
        url: deleteCartURL,
        data: { prdcd: PLU },
        success: function(data){
            if(data == '1'){
                cartReload();
                getCartDetail();
            }else{
                $('#modal-error').html('<div class="alert alert-danger">' + data + '</div>');
            }
        }
    });
}

function deleteAllCart(){
    $.ajax({
        type: "DELETE",
        url: deleteALLCartURL,
        success: function(data){
            if(data == undefined || data == ""){
                $('#modal-core').html('Anda tidak memiliki Barang di Keranjang');
            }else{
                cartReload();
                getCartDetail();
            }
        }
    });
}


function cartReload(){
    $('.cart-bar').html("<i class='fa fa-refresh fa-2x fa-spin'></i>&nbsp;");
    $.ajax({
        type: "GET",
        secure_url: reloadCartURL,
        success: function(data){
            $('.cart-bar').html(data);  
        }
    });
}

function getQty($qty){
    document.getElementById("getqty").value = $qty;
}