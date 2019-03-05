// login Show/Hide password
$(document).ready(function() {
    $("#showpassword").on('click', function(){
        var password = $("#sxcSigninPassword");
        var type = password.attr('type');
        if (type == 'password') {
            password.attr('type', 'text');
            $(this).text("Hide Password");
        } else {
            password.attr('type', 'password');
            $(this).text("Show Password");
        }
    });
});
    

function checkSendUsGateway() {
    jQuery.ajax({
        url: "check_ajax.php",
        data:'sxcSendUs='+$("#sxcSendUs").val(),
        type: "POST",
        success:function(data){
            var exchangeSell = JSON.parse(data);
            $("#sxc_imageSendUs").attr("src","assets/img/"+exchangeSell[0]+".png");
            $("#sellUsStatus").html(exchangeSell[1]);
            $("#sxcAmountSend").val(exchangeSell[2]);
            $("#sxcAmountReceive").val(exchangeSell[3]);
            // console.log(data);
        },
        error:function (){}
    });
}

function checkReceiveGateway() {
    jQuery.ajax({
        url: "check_ajax.php",
        data:'sxcReceive='+$("#sxcReceive").val(),
        type: "POST",
        success:function(data){
            var exchangeReceive = JSON.parse(data);
            $("#sxc_imageReceive").attr("src","assets/img/"+exchangeReceive[0]+".png");
            $("#reserveStatus").html(exchangeReceive[1]);
            $("#sellUsStatus").html(exchangeReceive[2]);
            $("#sxcAmountSend").val(exchangeReceive[3]);
            $("#sxcAmountReceive").val(exchangeReceive[4]);
            // console.log(data);
        },
        error:function (){}
    });
}

function calculateAmount(){
    var sellamunt   = $("#sxcAmountSend").val();
    var excneRate   = $("#sellUsStatus").html();
    var rsevSatus   = jQuery.trim($("#reserveStatus").html());
    var reserve     = rsevSatus.replace("Reserve:", "");
    reserve         = reserve.replace("BDT", "");
    reserve         = jQuery.trim(reserve);
    reserve         = parseInt(reserve, 10);
    // console.log(sellamunt);
    console.log(reserve);
    jQuery.ajax({
        url: "check_ajax.php",
        data:'sxcAmountSend='+sellamunt+'&sellUsStatus='+excneRate+'&reserve='+reserve,
        type: "POST",
        success:function(data){
            var exchangePrice = JSON.parse(data);
            $("#sxcAmountReceive").val(exchangePrice[0]);
            if (exchangePrice[1] == 1) {
                $('#btn_sharpxchange_step1').addClass('hide');
                $("#sxc_exchange_results").html(exchangePrice[2]);
            } else {
                $('#btn_sharpxchange_step1').removeClass('hide');
                $("#sxc_exchange_results").html("");
            }
            console.log(data);
        },
        error:function(){}
    });
}

function checkUsername() {
    jQuery.ajax({
        url: "check_validation.php",
        data:'username='+$("#sxcSignupUsername").val(),
        type: "POST",
        success:function(data){
            $("#sxcUsernameStatus").html(data);
        },
        error:function (){}
    });
}
function checkEmail() {
    jQuery.ajax({
        url: "check_validation.php",
        data:'email='+$("#sxcSignupEmail").val(),
        type: "POST",
        success:function(data){
            $("#sxcEmailStatus").html(data);
        },
        error:function (){}
    });
}
function checkpasswd() {
    jQuery.ajax({
        url: "check_validation.php",
        data:'passwd='+$("#sxcSignupPassword").val(),
        type: "POST",
        success:function(data){
            $("#sxcPasswdStatus").html(data);
        },
        error:function (){}
    });
}
function checkconpasswd() {
    jQuery.ajax({
        url: "check_validation.php",
        data:'conpasswd='+$("#sxcSignupConPassword").val(),
        type: "POST",
        success:function(data){
            $("#sxcConPasswdStatus").html(data);
        },
        error:function (){}
    });
}



function sxc_exchange_step1() {
    var sxcSendUs           = $("#sxcSendUs").val();
    var sxcReceive          = $("#sxcReceive").val();
    var sxcAmountSend       = $("#sxcAmountSend").val();
    var sxcAmountReceive    = $("#sxcAmountReceive").val();
    var sellUsStatus        = jQuery.trim($("#sellUsStatus").html());
    var reserveStatus       = jQuery.trim($("#reserveStatus").html());
    var reserve             = reserveStatus.replace("Reserve:", "");
    reserve                 = reserve.replace("BDT", "");
    reserve                 = jQuery.trim(reserve);
    sxcAmountReceive        = parseInt(sxcAmountReceive, 10);
    reserve                 = parseInt(reserve, 10);
    // console.log(sxcSendUs+' : '+sxcReceive+' : '+sxcAmountSend+' : '+sxcAmountReceive+' : '+sellUsStatus+' : '+reserveStatus);
    
    // jQuery.ajax({
    //     url: "check_ajax.php",
    //     data:'conpasswd='+$("#sxcSignupConPassword").val(),
    //     type: "POST",
    //     success:function(data){
    //         $("#sxcConPasswdStatus").html(data);
    //     },
    //     error:function (){}
    // });
}