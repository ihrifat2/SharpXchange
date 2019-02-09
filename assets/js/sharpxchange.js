function checkSendUsInput() {
    jQuery.ajax({
        url: "check_ajax.php",
        data:'sxcSendUs='+$("#sxcSendUs").val(),
        type: "POST",
        success:function(data){
            $("#sxc_imageSendUs").attr("src","assets/img/"+data+".png");
        },
        error:function (){}
    });
}

function checkRecieveInput() {
    jQuery.ajax({
        url: "check_ajax.php",
        data:'sxcRecieve='+$("#sxcRecieve").val(),
        type: "POST",
        success:function(data){
            // $("#sxc_imageRecieveStatus").html(data);
            $("#sxc_imageRecieve").attr("src","assets/img/"+data+".png");
        },
        error:function (){}
    });
}