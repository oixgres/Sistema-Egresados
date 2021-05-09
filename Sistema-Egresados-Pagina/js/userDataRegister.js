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

$(document).ready(function (e) {
    document.cookie ="id=1" //cookie temporal



    let stepper = new Stepper($('.bs-stepper')[0]) //stteper principal
    const WINDOW_HEIGHT = $(window).height(); //altura maxima del dispositivo

    let questionContainerForIsWorking = $('#questionContainerForIsWorking');

    $('.container').css({"height":`${WINDOW_HEIGHT}px`});

    $("#isWorkingYes,#isWorkingNo").on('click', function (e) {
        e.stopPropagation()
        if($(this).attr('id') === "isWorkingYes"){
            questionContainerForIsWorking.hide();
            questionContainerForIsWorking.removeClass('d-none');
            questionContainerForIsWorking.show(600);
        }
        else{
            questionContainerForIsWorking.hide(600);
        }
    })

    if($("#isWorkingYes").prop('checked')) //validacion por la caché del navegador
    {
        questionContainerForIsWorking.hide();
        questionContainerForIsWorking.removeClass('d-none');
        questionContainerForIsWorking.show(600);
    }

    $('#PersonalDataBtn').on('click', function (e) {
        e.stopPropagation();
        const idUsuario = getCookie("id"); //obtener id de usuario
        const fechaNacimiento = $('#Fecha_Nacimiento').val(); //fecha de nacimiento



        //stepper.next();
    })
    $('#DatosEscolaresButton').on('click', function (e) {
        e.stopPropagation();
        stepper.next();
    })
    $('#DatosLaboralesBtn').on('click', function (e) {
        e.stopPropagation();
        alert("Guardado")
    })


})