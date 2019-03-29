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
    excneRate       = excneRate.trim()
    var rsevSatus   = jQuery.trim($("#reserveStatus").html());
    var reserve     = rsevSatus.replace("Reserve:", "");
    reserve         = reserve.replace("BDT", "");
    reserve         = jQuery.trim(reserve);
    reserve         = parseInt(reserve, 10);
    // console.log(sellamunt);
    // console.log(reserve);
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
            // console.log(data);
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

function sxc_exchange_stepone() {
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
    if (sxcAmountSend == '' || sxcAmountSend == null) {
        sxcAmountSend = 0;
    }
    // console.log(sxcSendUs+' : '+sxcReceive+' : '+sxcAmountSend+' : '+sxcAmountReceive+' : '+sellUsStatus+' : '+reserveStatus);
    jQuery.ajax({
        url: "sxc_payout.php",
        data:'sxcSendUs='+sxcSendUs+'&sxcReceive='+sxcReceive+'&sxcAmountSend='+sxcAmountSend,
        type: "POST",
        success:function(data){
            var exchangelimit = JSON.parse(data);
            $("#sxc_exchange_results").html(exchangelimit[0]);
            $("#sxcReceiveGatewayName").html(exchangelimit[2]);
            $("#gateway_address").html(exchangelimit[4]);
            $("#gateway_name").html("Our "+exchangelimit[3]);
            $("#payoutAmount").html(exchangelimit[5]);
            if (exchangelimit[1] == 0) {
                $('#sharpxchange_step1').removeClass('active');
                $('#sharpxchange_step2').addClass('active in');
            }
            if (exchangelimit[6] == 1){
                var hostname = window.location.hostname;
                window.location.replace(exchangelimit[7]+"?error=1");
            }
            // console.log(hostname);
            // console.log(data);
        },
        error:function (){}
    });
}

function sxc_exchange_steptwo() {
    var actEmail = document.getElementById("sxcActiveEmail").value;
    var recvgtwy = document.getElementById("sxcReceiveGatewayEmail").value;
    var actphone = document.getElementById("sxcActivePhone").value;
    if (actEmail == "" && recvgtwy == "" && actphone == "") {
        document.getElementById("sxc_exchange_results").innerHTML = "All fields are required.";
    } else {
        $('#sharpxchange_step2').removeClass('active');
        $('#sharpxchange_step3').addClass('active in');
    } 
}

function contactform() {
    var contName    = document.getElementById("sxcContName").value;
    var contMail    = document.getElementById("sxcContMail").value;
    var contSub     = document.getElementById("sxcContSub").value;
    var conTxt      = document.getElementById("sxcConTxt").value;
    var conBtn      = document.getElementById("sxcConBtn").value;
    if (isEmpty(contName) || isEmpty(contMail) || isEmpty(contSub) || isEmpty(conTxt)) {
        $('#sxcConBtn').addClass('hide');
    } else {
        $('#sxcConBtn').removeClass('hide');
    }
}

function contactformSubmit() {
    var contName    = document.getElementById("sxcContName").value;
    var contMail    = document.getElementById("sxcContMail").value;
    var contSub     = document.getElementById("sxcContSub").value;
    var conTxt      = document.getElementById("sxcConTxt").value;
    jQuery.ajax({
        url: "contact.php",
        data:'contName='+contName+'&contMail='+contMail+'&contSub='+contSub+'&conTxt='+conTxt,
        type: "POST",
        success:function(data){
            // console.log(data);
            var kontak = JSON.parse(data);
            if (kontak[0] == 0) {
                $('#success').html(kontak[1]);
            }
            if (kontak[0] == 1) {
                $('#error').html(kontak[1]);
            }
        },
        error:function (){}
    });
}

function isEmpty(val){
    return (val === undefined || val == null || val.length <= 0) ? true : false;
}

function getTestimonels() {
    jQuery.ajax({
        url: "tstimnl.php",
        data:'testtimonial=0',
        type: "POST",
        success:function(data){
            console.log(data);
            $("#sxcTstmnl").html(data);
        },
        error:function (){}
    });
}