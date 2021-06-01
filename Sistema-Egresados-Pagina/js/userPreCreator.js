$(document).ready(function () {
    const HEIGHT = $(document).height();
    const WIDTH = $(document).width();


    $('.container').css({
        'height' : HEIGHT
    })

    $(window).resize(function () {
        let height = $(document).height();
        $('.container').css({
            'height' : height
        })
    })


    $('#registerUser').on('click', function () {
        let idName = $('#idName').val()
        let idLastName = $('#idLastName').val()
        let idMat = $('#idMat').val()
        let idMail = $('#idMail').val()
        let idPass = $('#idPass').val()
        let idPass2 = $('#idPass2').val()


        $.ajax({
            url: '../php/registerUserSendMail.php',
            data: {idName, idLastName, idMail, idMat, idPass, idPass2},
            type: 'POST',
            success: function (response) {
                alert("Usuario creado con exito")
            },
            error: function () {

            }

        })
    })



})