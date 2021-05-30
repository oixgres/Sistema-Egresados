$(document).ready(function () {
    function getCookie(cname) {
        const name = cname + "=";
        const decodedCookie = decodeURIComponent(document.cookie);
        const ca = decodedCookie.split(';');
        for(let i = 0; i <ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) === 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    } //funcion para obtener un cookie

    $('#pass_hide').on('click', function (e) {
        e.stopPropagation();
        $('#passContainer').removeClass('d-none');
        $(this).addClass('d-none')
    })

    $('#saveNewPassword').on('click', function (e) {
        e.stopPropagation();

        let idUsuario = getCookie('id');
        let password = $('#newPassWord').val()

        $.ajax({
            url: 'updatePassword.php',
            data: {idUsuario, password},
            type: 'POST',
            success: function (response) {
                console.log(response)
                if(parseInt(response, 10) === 0){
                    alert("Contraseña actualizada")

                    $('#passContainer').addClass('d-none');
                    $('#pass_hide').removeClass('d-none')
                }
                else{
                    alert("Ocurrio un error");
                }
            }
        })

    })

    console.log("id = " + getCookie("id"))

})