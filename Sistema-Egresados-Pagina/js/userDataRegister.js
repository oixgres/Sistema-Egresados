$(document).ready(function (e) {
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
        stepper.next();
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