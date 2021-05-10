$(document).ready(function () {
    const UNIVERSITIES = "universities"
    const CAMPUS = "campus";
    const FACULTADES = "facultades";
    const CARRERAS = "carreras";

    function CreateOptionComponent(value) {
        /*
            <option value="volvo" class="form-text">Volvo</option>
        */
        return $(`
            <option value="${value}" class="form-text">${value}</option>
        `);
    }


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