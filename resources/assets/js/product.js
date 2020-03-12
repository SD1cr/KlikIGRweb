function getProductDetail(PLU){
    $('.modal-dialog').width('');
    $('#myModalLabel').text("Tambahkan ke Keranjang");
    $('#modal-core').html("<span ><i class='fa fa-spinner fa-3x fa-spin'></i>&nbsp;</span>");
    $('#modal-error').html("");
    $.ajax({
        type: "GET",
        url: getProductDialogURL,
        data: { prdcd: PLU },
        success: function(data){
            if(data == undefined || data == ""){
                $('#modal-core').html('Anda tidak memiliki Barang di Keranjang');
            }else{
                $('#modal-core').html($(data));
            }
        }
    });
}

function getBrand(){
    $('.modal-dialog').width('');
    $('#myModalLabel').text("FEATURED BRAND");
    $('#modal-core').html("<span ><i class='fa fa-spinner fa-3x fa-spin'></i>&nbsp;</span>");
    $('#modal-error').html("");
    $.ajax({
        type: "GET",
        url: getBrandDialogURL,
        success: function(data){
            if(data == undefined || data == ""){
                $('#modal-core').html('Maaf, Brand Tidak Ada');
            }else{
                $('#modal-core').html($(data));
            }
        }
    });
}      

//function changeOrd(){
//    $('#ordSelect').change(function(){
//        $.ajax({
//            type: "GET",
//            url: "list?ord="+$('#ordSelect').val(),
//        });
//    });
//}

function changeOrd(){
    var e = document.getElementById("ordSelect");
    $('#ORD').val(e.value);
    $('#searchForm').submit();
}     


function changeDiv(){
    var e = document.getElementById("divSelect");
    if(e.value == 7){
        $('#NEWKAT').val("%");
    }else{
        $('#NEWKAT').val(e.value);
    }
    $('#searchForm').submit();
}

function changeBrand(){
    var e = document.getElementById("brandSelect");
    $('#BRAND').val(e.value);
    $('#filterForm').submit();
}

function PriceFilter(){
    var inputmin = $("#inputmin").val();
    var inputmax = $("#inputmax").val();
    var sort = $("#sort").val();
    var ord = $("#ord").val();
    var key = $("#key").val();
    var x = $(".brand:checked").map(function() {
        return this.value;
    }).toArray();
    x = x.join(",");
    $.ajax({
        type: "GET",
        url: 'list',
        data: { min:inputmin, max :inputmax, brand:x, ord:ord, sort:sort },
        success : function(data) {
            if(data == undefined || data == ""){

            }else{
                window.location.href = window.location.href.replace( /[\?#].*|$/, "?key="+ key +"&brand=" + x + "&ord="+ ord +"&min=" + inputmin + "&max=" + inputmax + "&sort="+ sort);
            }
        }
    });
}

function PriceFilterContract(){
    var inputmin = $("#inputmin").val();
    var inputmax = $("#inputmax").val();
    var ord = $("#ord").val();
    var key = $("#key").val();
    $.ajax({
        type: "GET",
        url: 'listcontract',
        data: { min:inputmin, max :inputmax, ord:ord},
        success : function(data) {
            if(data == undefined || data == ""){

            }else{
                window.location.href = window.location.href.replace( /[\?#].*|$/, "?key="+ key + "&ord="+ ord +"&min=" + inputmin + "&max=" + inputmax );
            }
        }
    });
} 
