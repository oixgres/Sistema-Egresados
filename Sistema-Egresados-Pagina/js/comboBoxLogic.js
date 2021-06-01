$(document).ready(function (e) {
    function optionComponent(text){
        //<option></option>
        return $(`
            <option>${text}</option>    
        `)
    }

    //Obtener todos los empleos
    $.ajax({
        url: '../php/getJobs.php',
        type: 'POST',
        success: function (response) {

            try{

                let jobs = JSON.parse(response);

                jobs.forEach(job => {

                    $('#Empleos_list').append(optionComponent(job.Nombre));

                })

            }catch (e){

            }
        },
        error: function () {

        }
    })

    //obtener las empresas
    $.ajax({
        url: '../php/getEnterprises.php',
        type: 'POST',
        success: function (response) {

            try{

                let jobs = JSON.parse(response);

                jobs.forEach(job => {

                    $('#Empresa_list').append(optionComponent(job.Nombre));

                })

            }catch (e){

            }
        },
        error: function () {

        }
    })

    $.ajax({
        url: '../php/getPositions.php',
        type: 'POST',
        success: function (response) {

            try{

                let jobs = JSON.parse(response);

                jobs.forEach(job => {

                    $('#Puesto_list').append(optionComponent(job.Nombre));

                })

            }catch (e){

            }
        },
        error: function () {

        }
    })

    $.ajax({
        url: '../php/getCategories.php',
        type: 'POST',
        success: function (response) {

            try{

                let jobs = JSON.parse(response);

                jobs.forEach(job => {

                    $('#Categoria_list').append(optionComponent(job.Nombre));

                })

            }catch (e){

            }
        },
        error: function () {

        }
    })

    $.ajax({
        url: '../php/getDepartments.php',
        type: 'POST',
        success: function (response) {

            try{

                let jobs = JSON.parse(response);

                jobs.forEach(job => {

                    $('#Departamento_list').append(optionComponent(job.Nombre));

                })

            }catch (e){

            }
        },
        error: function () {

        }
    })
})