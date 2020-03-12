function getLoginMember(){
    $('.modal-dialog').width('400px');
    $('#myModalLabel').text("Halaman Login");
    $('#modal-core').html("<span ><i class='fa fa-spinner fa-3x fa-spin'></i>&nbsp;</span>");
    $('#modal-error').html("");
    $.ajax({
        type: "GET",
        url: getLoginMemberDialogURL,
        success: function(data){
            if(data == 0){
                $('#modal-core').html('Maaf, Login Salah');
            }else{
                $('#modal-core').html($(data));
            }
        }
    });
}

$("#btn_login").click(function(event){ 
    var user = $("#email").val();
    var pass = $("#password").val();
    if(user == "" || pass == ""){
        $("#alert_warning_login").show();
    }else{
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
            type: "POST",
            url: getValidLoginUrl,
            data:{
                email: user,
                password: pass,
            },
            success:function(msg){
                if(msg == "3"){
                    window.location.href = "verif";
                    //location.replace("http://192.168.11.157/klikigr/public/verif")
                }else if(msg == 0){
                    $("#alert_danger_login").show();
                }else if(msg == 1){
                    $("#modalLogin").modal('hide');
                    loginReload();
                    cartReload();
                    $("#div_modal_login").hide().removeClass('hide');
                    location.reload();
                }else if(msg == "2"){
                    $("#alert_activ_login").show();
                }
                // $("#cart-bar").hide().removeClass('hide');

            }
        });
    }
});

function validLogin(){
    var username=$("#email").val();
    var password=$("#password").val();

    $.ajax({
        type: "POST",
        url: getValidLoginUrl,
        data: { email: username, password: password, _token: $('#_token').val() },
        success: function(data){
            if(data == 0){
                $('#modal-core').html('Maaf, Login Salah');
            }else{
                $('#myModal').modal('hide');
                loginReload();
            }
        }
    });
}

function getOptAddress(){
    $('.modal-dialog').width('');
    $('#myModalLabel').text("Pilih Alamat");
    $('#modal-core').html("<span ><i class='fa fa-spinner fa-3x fa-spin'></i>&nbsp;</span>");
    $('#modal-error').html("");
    $.ajax({
        type: "GET",
        url: getOptionAddressDialogURL,
        success: function(data){
            if(data == undefined || data == ""){
                $('#modal-core').html('Maaf, Alamat Tidak Ada');
            }else{
                $('#modal-core').html($(data));
            }
        }
    });
}

function loginReload(){
    $('#hallo').html("<i class='fa fa-refresh fa-2x fa-spin'></i>&nbsp;");
    $.ajax({
        type: "GET",
        url: reloadLoginURL,
        success: function(data){
            $('#hallo').html(data);
        }
    });
}

function cartReload(){
    $('.cart-bar').html("<i class='fa fa-refresh fa-2x fa-spin'></i>&nbsp;");
    $.ajax({
        type: "GET",
        url: reloadCartURL,
        success: function(data){
            $('.cart-bar').html(data);
            //$.notify("Hello World");
        }
    });
}

function getKodMem(){
    $('.modal-dialog').width('');
    $('#myModalLabel').text("ID Member");
    $('#modal-core').html("<span ><br/><i class='fa fa-spinner fa-3x fa-spin'></i><br/>&nbsp;</span>");
    $('#modal-error').html("");
    $.ajax({
        type: "GET",
        url: getKodedialogURL,
        success: function(data){
            if(data == undefined || data == ""){
                $('#modal-core').html('Anda tidak menemukan ID member');
            }else{
                $('#modal-core').html(data);
            }
        }
    });
}

function sendKd(KD){
    $('#KodeMembers').val(KD);
    $('#hKodemember').val(KD);
    $('#myModal').modal('hide');

}

function searching(){
    kdMember = $('#KODEKEY').val();
    $.ajax({
        type: "GET",
        data: { KEY : kdMember },
        url: getKodedialogURL,
        success: function(data){
            if(data == undefined || data == ""){
                $('#modal-core').html('Anda tidak menemukan ID member');
            }else{
                $('#modal-core').html(data);
            }
        }
    });
}

function handle(e){
    if(e.keyCode === 13){
        e.preventDefault();
        var user = $("#email").val();
        var pass = $("#password").val();
        if(user == "" || pass == ""){
            $("#alert_warning_login").show();
        }else{
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                type: "POST",
                url: getValidLoginUrl,
                data:{
                    email: user,
                    password: pass,
                },
                success:function(msg){
                    if(msg == "3"){
                        window.location.href = "verif";
                        //location.replace("http://192.168.11.157/klikigr/public/verif")
                    }else if(msg == 0){
                        $("#alert_danger_login").show();
                    }else if(msg == 1){
                        $("#modalLogin").modal('hide');
                        loginReload();
                        cartReload();
                        $("#div_modal_login").hide().removeClass('hide');
                        location.reload();
                    }else if(msg == "2"){
                        $("#alert_activ_login").show();
                    }

                }
            });
        }
    }
}
//function loginReload(){
//    $('#cart-bar').html("<br/><i class='fa fa-refresh fa-2x fa-spin'></i><br/>&nbsp;");
//    $.ajax({
//        type: "GET",
//        url: reloadLoginURL,
//        success: function(data){
//            $('#cart-bar').html(data);
//        }
//    });
//}
