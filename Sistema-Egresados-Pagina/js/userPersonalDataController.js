var debug; 
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
    function validateUserPersonalData() {
        const Fecha_Nacimiento = $('#Fecha_Nacimiento');
        const Estado = $('#Estado');
        const Ciudad = $('#Ciudad');
        const Domicilio = $('#Domicilio');
        const Telefono = $('#Telefono');
        let flag = true;

        if(Fecha_Nacimiento.val() === ""){
            Fecha_Nacimiento.addClass("alert alert-danger is-invalid");
            flag = false;
        }
        if(Estado.val() === "") {
            Estado.removeClass("alert alert-success is-valid");
            Estado.addClass("alert alert-danger is-invalid");
            flag = false;
        }
        if(Ciudad.val() === "") {
            Ciudad.removeClass("alert alert-success is-valid");
            Ciudad.addClass("alert alert-danger is-invalid");
            flag = false;
        }
        if(Domicilio.val() === "") {
            Domicilio.removeClass("alert alert-success is-valid");
            Domicilio.addClass("alert alert-danger is-invalid");
            flag = false;
        }
        if(Telefono.val() === "" || isNaN(Telefono.val())) {
            Telefono.removeClass("alert alert-success is-valid");
            Telefono.addClass("alert alert-danger is-invalid");
            flag = false;
        }

        return flag;
    }
    function CreateOptionComponent(value) {
        /*
            <option value="volvo" class="form-text">Volvo</option>
        */
        return $(`
            <option value="${value}" class="form-text">${value}</option>
        `);
    }
    const STATES_DOCUMENT = "Estados";
    const CITIES_DOCUMENT = "Ciudades";

    let stepper = mainSteper.stepper;



    $('#PersonalDataBtn').on('click', function (e) {
        e.stopPropagation();

        if(validateUserPersonalData()){
            const spinner = $('#spinnerPersonalData');
            //const btn = spinner.parent();

            spinner.removeClass('d-none');
            //btn.text('Guardando')

            const idUsuario = getCookie("verification"); //obtener id de usuario
            const fechaNacimiento = $('#Fecha_Nacimiento').val(); //fecha de nacimiento
            const idEstado = JSON.parse(localStorage.getItem(STATES_DOCUMENT))[$('#Estado').val()];
            const idCiudad = JSON.parse(localStorage.getItem(CITIES_DOCUMENT))[$('#Ciudad').val()];
            const domicilio = $('#Domicilio').val();
            const telefono = $('#Telefono').val();


            $.ajax({
                url: '../php/registerPersonalData.php',
                data: {idUsuario, fechaNacimiento, idEstado, idCiudad, domicilio, telefono},
                type: 'POST',
                success: function (response) {
                    try{
                        if(parseInt(response, 10) === 0){
                            spinner.addClass('d-none');
                            alert("Registrado con exito")
                            stepper.next();
                        }
                        else {
                            alert("Hubo un error")
                        }

                    }catch (e){
                        alert("Hubo un error")
                    }
                }

            })

        }
        else{
            alert("Favor de llenar correctamente todos los campos")
        }

    })
    $('#DatosEscolaresButton').on('click', function (e) {
        e.stopPropagation();
        stepper.next();
    })
    $('#Fecha_Nacimiento').on('change', function (e) {

        if($(this).val() !== ""){
            $(this).removeClass('alert alert-danger is-invalid');
            $(this).addClass('alert alert-success is-valid');
        }else{
            $(this).removeClass('alert alert-success is-valid');
            $(this).addClass('alert alert-danger is-invalid');

        }
    })
    $('#Domicilio').on('change', function (e) {
        if($(this).val() !== ""){
            $(this).removeClass('alert alert-danger is-invalid');
            $(this).addClass('alert alert-success is-valid');
        }else{
            $(this).removeClass('alert alert-success is-valid');
            $(this).addClass('alert alert-danger is-invalid');

        }
    })
    $('#Telefono').on('change', function (e) {
        if($(this).val() !== ""){
            $(this).removeClass('alert alert-danger is-invalid');
            $(this).addClass('alert alert-success is-valid');
        }else{
            $(this).removeClass('alert alert-success is-valid');
            $(this).addClass('alert alert-danger is-invalid');

        }
    })

    $.ajax({
        url: '../php/getStates.php',
        type: 'POST',
        async: false,
        data: {},
        success: function (response) {
            console.log(response)
            debug = response;
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

                        let idEstado = estados[$(this).val()];

                        $.ajax({
                            url: '../php/getCities.php',
                            data: {idEstado},
                            type: 'POST',
                            success: function (response) {

                                try{
                                    let ciudades = JSON.parse(response);
                                    let ciudades_object = {};

                                    $('#Ciudades').empty();
                                    ciudades.forEach(ciudad => {
                                        ciudades_object[ciudad.nombre] = ciudad.idCiudad;
                                        $('#Ciudades').append(CreateOptionComponent(ciudad.nombre));
                                    })

                                    $('#Ciudad').on('change', function () {
                                        const ciudades = JSON.parse(localStorage.getItem(CITIES_DOCUMENT));
                                        if(ciudades[$(this).val()] === undefined){
                                            $(this).removeClass('alert alert-success is-valid')
                                            $(this).addClass('alert alert-danger is-invalid')
                                        }
                                        else{
                                            $(this).removeClass('alert alert-danger is-invalid')
                                            $(this).addClass('alert alert-success is-valid')
                                        }

                                    })

                                    localStorage.setItem(CITIES_DOCUMENT, JSON.stringify(ciudades_object));

                                }catch (e){

                                }

                            },
                            error: function () {
                                alert("error al obtener las ciudades")
                            }
                        })
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

