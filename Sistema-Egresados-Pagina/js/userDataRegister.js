$(document).ready(function (e) {
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
    function CreateOptionComponent(value) {
        /*
            <option value="volvo" class="form-text">Volvo</option>
        */
        return $(`
            <option value="${value}" class="form-text">${value}</option>
        `);
    }
    const STATES_DOCUMENT = "Estados";


    document.cookie ="id=1" //cookie temporal


    let stepper = new Stepper($('.bs-stepper')[0]) //stteper principal
    const WINDOW_HEIGHT = $(window).height(); //altura maxima del dispositivo

    let questionContainerForIsWorking = $('#questionContainerForIsWorking');

    $('.container').css({"height":`${WINDOW_HEIGHT}px`}); //poner al contenedor la altura del dispositivo

    $("#isWorkingYes,#isWorkingNo").on('click', function (e) { //
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


    })
    $('#DatosEscolaresButton').on('click', function (e) {
        e.stopPropagation();
        stepper.next();
    })
    $('#DatosLaboralesBtn').on('click', function (e) {
        e.stopPropagation();
        alert("Guardado")
    })


    $.ajax({
        url: '../php/getStates.php',
        type: 'POST',
        async: false,
        data: {},
        success: function (response) {
            try{
                let estados = JSON.parse(response); //obtener los estados
                let estados_dictionary = {}; //crear diccionario
                let dataListParent = $('#Estados');

                $('#Estado').on("change", function (e) { //listener para comprobar que el estado existe
                    const estados = JSON.parse(localStorage.getItem(STATES_DOCUMENT));

                    if(estados[$(this).val()] === undefined){
                        $(this).removeClass('alert alert-success is-valid')
                        $(this).addClass('alert alert-danger is-invalid')
                        $('#Ciudad').attr('disabled', true);

                    }
                    else{
                        $(this).removeClass('alert alert-danger is-invalid')
                        $(this).addClass('alert alert-success is-valid')
                        $('#Ciudad').attr('disabled', false);

                    }

                })

                estados.forEach(estado => {
                    dataListParent.append(CreateOptionComponent(estado.nombre))//agregar opciones a los estados
                    estados_dictionary[estado.nombre] = estado.idEstado; //convertir json en diccionario
                })
                localStorage.setItem(STATES_DOCUMENT, JSON.stringify(estados_dictionary)); //guardar diccionario


            }catch (e){
                console.log(e)
            }
        },
        error: function () {
          alert("error")
        }
    })

})