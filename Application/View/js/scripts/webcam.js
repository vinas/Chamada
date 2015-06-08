$(document).ready(function() {

    $(document).on("click", "#addFoto", function() {
        $.openFancybox("/Chamada/Alunos/webcam/", 500, 400);
    });

    $(document).on("click", "#salvarFoto", function() {
        //$.openFancybox("/Chamada/Alunos/webcam/", 500, 400);
        $.post ("/Chamada/Alunos/uploadFoto", $("#fotoForm").serialize(), function(res) {
            if (res.response == 1) {
                parent.$("#addFoto").html("<b>&bull; Adicionar Foto &bull;</b>");
                parent.$("#foto").val(res.message);
                parent.$("#fotoAluno").attr("src", "/Chamada/Application/View/img/" + res.message);
                parent.$.fancybox.close();
            } else {
                console.log(res.message);
            }
        }, "json");
    });

    $("#webcam").scriptcam({
        showMicrophoneErrors:false,
        onError:onError,
        cornerRadius:20,
        disableHardwareAcceleration:1,
        cornerColor:'e3e5e2',
        onWebcamReady:onWebcamReady,
        onPictureAsBase64:base64_tofield_and_image
    });

    $.openFancybox = function(url, width, height) {
        $.fancybox({
            href            : url,
            width           : width,
            height          : height,
            closeBtn        : true,
            scrolling       : 'no',
            openEffect      : 'elastic',
            closeEffect     : 'elastic',
            openSpeed       : 600,
            closeSpeed      : 200,
            type            : 'iframe'
        });
    };

});

function base64_tofield() {
    $('#formfield').val($.scriptcam.getFrameAsBase64());
};

function base64_toimage() {
    b64 = $.scriptcam.getFrameAsBase64();
    $('#foto').val(b64);
    $('#image').attr("src","data:image/png;base64,"+b64);
};

function base64_tofield_and_image(b64) {
    $('#formfield').val(b64);
    $('#image').attr("src","data:image/png;base64,"+b64);
};

function changeCamera() {
    $.scriptcam.changeCamera($('#cameraNames').val());
}

function onError(errorId,errorMsg) {
    $( "#btn2" ).attr( "disabled", true );
    alert(errorMsg);
}          

function onWebcamReady(cameraNames,camera,microphoneNames,microphone,volume) {
    $.each(cameraNames, function(index, text) {
        $('#cameraNames').append( $('<option></option>').val(index).html(text) )
    });
    $('#cameraNames').val(camera);
}
