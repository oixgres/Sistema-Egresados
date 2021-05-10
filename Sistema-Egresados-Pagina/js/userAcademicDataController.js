$(document).ready(function () {
    const UNIVERSITIES = "universities"
    const CAMPUS = "campus";
    const FACULTADES = "facultades";
    const CARRERAS = "carreras";

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

    let stepper = mainSteper.stepper;
    
    $('#Universidad').on('change', function (e) {
        e.stopPropagation();
        const universidades = JSON.parse(localStorage.getItem(UNIVERSITIES));
        $(this).removeClass('alert alert-danger is-invalid is-valid alert-success')
        $('#Campus').attr('disabled', true)

        if(universidades[$(this).val()] !== undefined){

            $(this).addClass('alert alert-success is-valid')
            $('#Campus').attr('disabled', false)
            $('#CampusAll').empty();

            let idUniversidad = universidades[$(this).val()];

            $.ajax({
                url: '../php/getCampus.php',
                type: 'POST',
                data: {idUniversidad},
                success: function (response) {
                    try{
                        let campus_s = JSON.parse(response);
                        let campus_object = {}


                        campus_s.forEach(campus => {
                            $('#CampusAll').append(CreateOptionComponent(campus.nombre));
                            campus_object[campus.nombre] = campus.idCampus;
                        })

                        $('#Campus').attr('disabled', false)
                        localStorage.setItem(CAMPUS, JSON.stringify(campus_object))

                    }catch (e){

                    }

                },
                error: function () {
                    alert("Error al obtener los campus")
                }
            })


        }
        else{
            $(this).addClass('alert alert-danger is-invalid')
            $('#Campus').attr('disabled', true)
            $('#Campus').val("")
        }

    })
    $('#Campus').on('change', function (e) {
        e.stopPropagation();
        const campuses = JSON.parse(localStorage.getItem(CAMPUS));
        $(this).removeClass('alert alert-danger is-invalid is-valid alert-success');

        if(campuses[$(this).val()] !== undefined){
            $(this).addClass('alert alert-success is-valid')
            const idCampus = campuses[$(this).val()];
            $.ajax({
                url: '../php/getFaculties.php',
                data: {idCampus},
                type: 'POST',
                success: function (response) {
                    try{
                        let facultades = JSON.parse(response);
                        let facultades_object = {};

                        facultades.forEach(facultad => {
                            $('#Facultades').append(CreateOptionComponent(facultad.nombre))
                            facultades_object[facultad.nombre] = facultad.idFacultad;
                        })

                        localStorage.setItem(FACULTADES, JSON.stringify(facultades_object));
                        $('#Facultad').attr('disabled', false)

                    }catch (e){
                        alert("Error obteniendo las facultades")
                    }


                },
                error: function () {
                    alert("Error al obtener los campus")
                }
            })

        }else{
            $(this).addClass('alert alert-danger is-invalid')
            $('#Facultad').attr('disabled', true)
            $('#Facultad').val("");
        }

    })
    $('#Facultad').on('change', function (e) {
        e.stopPropagation();
        $(this).removeClass('alert alert-danger is-invalid is-valid alert-success');
        const facultades = JSON.parse(localStorage.getItem(FACULTADES));
        $('#Carrera').attr('disabled', true)
        if(facultades[$(this).val()] !== undefined){
            $(this).addClass('alert alert-success is-valid')
            const idFacultad = facultades[$(this).val()];

            $.ajax({
                url: '../php/getPrograms.php',
                data: {idFacultad},
                type: 'POST',
                success: function (response) {
                    try{
                        let carreras = JSON.parse(response);
                        let carreras_object = {}

                        carreras.forEach(carrera => {
                            $('#Carreras').append(CreateOptionComponent(carrera.nombre))
                            carreras_object[carrera.nombre] = carrera.idPlan_Estudio;
                        })

                        $('#Carrera').attr('disabled', false)
                        localStorage.setItem(CARRERAS, JSON.stringify(carreras_object))

                    }catch (e){

                    }



                },
                error: function () {
                    alert("error al traer las carreras")
                }


            })

        }
        else{
            $(this).addClass('alert alert-danger is-invalid')
            $('#Carrera').attr('disabled', true)
            $('#Carrera').val("")
        }

    })
    $('#Carrera').on('change', function (e) {
        e.stopPropagation();
        $(this).removeClass('alert alert-danger is-invalid is-valid alert-success');
        const carreras = JSON.parse(localStorage.getItem(CARRERAS))

        if(carreras[$(this).val()] !== undefined){
            $(this).addClass('alert alert-success is-valid');
        }
        else{
            $(this).addClass('alert alert-danger is-invalid')
        }
    })
    $('#saveAcademicData').on('click', function (e) {
        e.stopPropagation();

        if(validateFields()){
            const idUsuario = getCookie("id");
            const idUniversidad = JSON.parse(localStorage.getItem(UNIVERSITIES))[$('#Universidad').val()];
            const idCampus = JSON.parse(localStorage.getItem(CAMPUS))[$('#Campus').val()];
            const idFacultad = JSON.parse(localStorage.getItem(FACULTADES))[$('#Facultad').val()];
            const idPlanEstudio = JSON.parse(localStorage.getItem(CARRERAS))[$('#Carrera').val()];
            const fechaIngreso = $('#Ingreso').val();
            const fechaEgreso = $('#Egreso').val();
            const semestreGrad = $('#Semestre_Grad').val();
            const generacion = $('#Generacion').val();
            const fechaTitulacion = $('#Titulacion').val();
            const correo = $('#CorreoInstucional').val();

            $.ajax({
                url: '../php/registerAcademicData.php',
                data: {idUsuario, idUniversidad, idCampus, idFacultad, idPlanEstudio, fechaIngreso, fechaEgreso, semestreGrad, generacion, fechaTitulacion, correo},
                type: 'POST',
                success: function (response) {
                    try{
                        if(parseInt(response, 10) === 0){
                            alert("Registrado con exito")
                            stepper.next();
                        }
                    }catch (e){
                        console.log(e)
                    }


                },
                error: function () {
                    alert("error al registrar datos")
                }
            })


        }else{
            alert("Favor de verificar los datos")
        }

    })
    function validateFields() {
        let flag = true;

        $('*').removeClass('alert alert-danger alert-success is-invalid is-invalid')

        if($('#Universidad').val() === ""){
            flag = false;
            $('#Universidad').addClass('alert alert-danger is-invalid');
        }
        if($('#Campus').val() === ""){
            flag = false;
            $('#Campus').addClass('alert alert-danger is-invalid');
        }
        if($('#Facultad').val() === ""){
            flag = false;
            $('#Facultad').addClass('alert alert-danger is-invalid');
        }
        if($('#Carrera').val() === ""){
            flag = false;
            $('#Carrera').addClass('alert alert-danger is-invalid');
        }
        if($('#Ingreso').val() === ""){
            flag = false;
            $('#Ingreso').addClass('alert alert-danger is-invalid');
        }
        if($('#Egreso').val() === ""){
            flag = false;
            $('#Egreso').addClass('alert alert-danger is-invalid');
        }
        if($('#Semestre_Grad').val() === "" || isNaN($('#Semestre_Grad').val())){
            flag = false;
            $('#Semestre_Grad').addClass('alert alert-danger is-invalid');
        }
        if($('#Generacion').val() === "" || isNaN($('#Generacion').val())){
            flag = false;
            $('#Generacion').addClass('alert alert-danger is-invalid');
        }
        if($('#Titulacion').val() === ""){
            flag = false;
            $('#Titulacion').addClass('alert alert-danger is-invalid');
        }
        if($('#CorreoInstucional').val() === ""){
            flag = false;
            $('#CorreoInstucional').addClass('alert alert-danger is-invalid');
        }




        return flag;
    }

    $.ajax({
        url: '../php/getUniversities.php',
        success: function (response) {
            try{
                let universidades = JSON.parse(response);
                let universidades_object = {};

                universidades.forEach(universidad => {
                    $('#Universidades').append(CreateOptionComponent(universidad.nombre));
                    universidades_object[universidad.nombre] = universidad.idUniversidad;
                })

                localStorage.setItem(UNIVERSITIES, JSON.stringify(universidades_object));

            }catch (e){

            }

        }
    })
})