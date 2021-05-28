$(document).ready(function (e) {
    const JSON_FOR_CSV = "STUDENTS"

    checkSession('admin');
    function createCarouselItemUserHistory(Empleo, Empresa, Puesto, Departamento, Actividades, Tecnologias, CorreoLaboral, active) {

        return $(`
        <div class="carousel-item ${active}">
            <div class="row">
                <div class="col-md-4">
                    <label>Empleo:</label>
                </div>
                <div class="col-md-8">
                    <p>${Empleo}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label>Empresa:</label>
                </div>
                <div class="col-md-8">
                    <p>${Empresa}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label>Puesto:</label>
                </div>
                <div class="col-md-8">
                    <p>${Puesto}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label>Departamento:</label>
                </div>
                <div class="col-md-8">
                    <p>${Departamento}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label>Actividades:</label>
                </div>
                <div class="col-md-8">
                    <p>${Actividades}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label>Tecnologias:</label>
                </div>
                <div class="col-md-8">
                    <p>${Tecnologias}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label>Correo Laboral:</label>
                </div>
                <div class="col-md-8">
                    <p>${CorreoLaboral}</p>
                </div>
            </div>
        </div>
        `)
    }

    function UserRow(Matricula, Nombres, Apellidos, Campus, Facultad, Programa, Empresa, Puesto, Ciudad, Correo, id) {
        let node =  $(`
                <tr id="user_${id}">
                <td>${Matricula}</td>
                <td>${Nombres}</td>
                <td>${Apellidos}</td>
                <td>${Campus}</td>
                <td>${Facultad}</td>
                <td>${Programa}</td>
                <td>${Empresa}</td>
                <td>${Puesto}</td>
                <td>${Ciudad}</td>
                <td>${Correo}</td>
                <td>
                    <div class="btn-group">
                        <button class="btn mr-1 btn-success showProfileBtn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ver perfil">
                            <span class="fa fa-user"></span>
                        </button>
                        <button class="btn btn-info mr-1 sendEmailProfile" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Enviar correo">
                            <span class="fa fa-envelope"></span>
                        </button>
                        <button class="btn btn-danger deleteUser" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Eliminar usuario">
                            <span class="fa fa-times"></span>
                        </button>
                    </div>
                </td>
        </tr>  
        `)

        node.find('.showProfileBtn').on('click', function (e) {
            e.stopPropagation();
            let userId = $(this).parent().parent().parent().attr('id');
            let regex = RegExp('[0-9]+')
            let idUsuario = regex.exec(userId).pop();

            //AnimationLoadingContainer
            $('#AnimationLoadingContainer').show();
            $('#userProfileContainer').hide();


            $.ajax({
                url: '../php/getUserData.php',
                data: {idUsuario},
                type: 'POST',
                success: function (response) {
                    try{
                        $('#AnimationLoadingContainer').hide(600, function () {
                            $('#userProfileContainer').show(600);
                        });


                        let datosUsuario = JSON.parse(response);

                        $('#userName').text(datosUsuario.nombres + " " + datosUsuario.apellidos)
                        $('#department').text(datosUsuario.departamento);
                        $('#userName_info').text(datosUsuario.nombres + " " + datosUsuario.apellidos)
                        $('#userEmail_info').text(datosUsuario.correo);
                        $('#userPhone_number').text(datosUsuario.telefono)
                        $('#userLocation_info').text(datosUsuario.estado + ", " + datosUsuario.ciudad)
                        $('#userWork_info').text(datosUsuario.empleo)
                        $('#userCompany_info').text(datosUsuario.empresa)
                        $('#userTypeWork_info').text(datosUsuario.puesto)
                        $('#userDepartment_info').text(datosUsuario.departamento)

                    }catch (e){
                        console.log(e)
                    }
                },
                error: function () {
                    alert("Error al consultar usuario")
                }

            })
            $.ajax({
                url: '../php/getUserEmploymentHistory.php',
                data: {idUsuario},
                type: 'POST',
                success: function (response) {
                    try {
                        let historial = JSON.parse(response)
                        $('#HistorialLaboral').empty();

                        for(let i = 0; i < historial.length; i++){

                            if(i === 0){
                                $('#HistorialLaboral').append(createCarouselItemUserHistory(
                                    historial[i].empleo,
                                    historial[i].empresa,
                                    historial[i].puesto,
                                    historial[i].departamento ,
                                    historial[i].actividades,
                                    historial[i].tecnologias,
                                    historial[i].correo,
                                    "active",
                                ))
                            }else{
                                $('#HistorialLaboral').append(createCarouselItemUserHistory(
                                    historial[i].empleo,
                                    historial[i].empresa,
                                    historial[i].puesto,
                                    historial[i].departamento ,
                                    historial[i].actividades,
                                    historial[i].tecnologias,
                                    historial[i].correo,
                                    "",
                                ))
                            }

                        }


                    }catch (e){
                        console.log(e)
                    }
                }
                
            })

            $.ajax({
                url: '../php/getUserLinks.php',
                type: 'POST',
                data: {idUsuario},
                success: function (response){
                    console.log(response)
                    $('#userLinks').empty();
                    try{
                        let links = JSON.parse(response);
                        let userLinks = $('#userLinks');

                        links.forEach(link => {

                                /*
                                 <a href="">Github</a><br/>
                                 */

                            userLinks.append(`<a href="${link.Link}" target="_blank">${link.Nombre}</a>`);

                        })


                    }catch (e){
                       switch (parseInt(response, 10)){
                           case -1: break;

                           case -2: $('#userLinks').append('No tiene links')
                                    break;


                       }
                    }
                },
                error : function (){

                }
            })


            $.ajax({
                url: '../php/getUserAbilities.php',
                type: 'POST',
                data: {idUsuario},
                success: function (response){
                    console.log(response)
                    $('#userAbilities').empty();
                    try{
                        let links = JSON.parse(response);
                        let userAbilities = $('#userAbilities');

                        links.forEach(link => {

                            /*
                             <a href="">Github</a><br/>
                             */

                            userAbilities.append(`<a href="#">${link.Nombre}</a>`);

                        })


                    }catch (e){
                        switch (parseInt(response, 10)){
                            case -1: break;

                            case -2: $('#userAbilities').append('No hay habilidades registradas')
                                break;


                        }
                    }
                },
                error : function (){

                }
            })

            let estado = 0; //traer encuestas pendientes
            $.ajax({
                url: '../php/getSurveys.php',
                type: 'POST',
                data: {idUsuario, estado},
                success: function (response) {
                    console.log(response)
                    try{
                        let surveys = JSON.parse(response);
                        $('#SurveyPendingsContainer').empty();
                        surveys.forEach(survey => {
                            $('#SurveyPendingsContainer').append(`
                                <p>${survey.encuesta}</p>
                            `)
                        })


                    }catch (e){
                        $('#SurveyPendingsContainer').append(`
                                <p>No tiene encuestas pendientes</p>
                        `)
                    }

                },
                error: function () {

                }
            })

            estado = 1
            $.ajax({
                url: '../php/getSurveys.php',
                type: 'POST',
                data: {idUsuario, estado},
                success: function (response) {
                    console.log(response)
                    try{
                        let surveys = JSON.parse(response);
                        $('#SurverAnsweredContainer').empty();

                        surveys.forEach(survey => {

                            let node = $(`
                                <div class="">
                                    <div class="row mt-3">
                                        <div class="col-12 d-flex justify-content-start">
                                            <p>${survey.encuesta}</p>
                                            <button type="button" class="btn btn-info btn-sm  toggle_survey ml-3 mb-3 rounded-pill p-1" id="survey_${survey.idEncuesta}">Mostrar</button>
                                 
                                        </div>
                                    </div>
                                    
                                     <div class="answeredContainer"> 
                                    </div>
                                    
                               
                                </div>
                              
                            `)
                            let container = node.find('.answeredContainer');
                            node.find(`.toggle_survey`).on('click', function (e){
                                let regex = new RegExp("[0-9]+");


                                if($(this).text() === "Mostrar")
                                {
                                    let idEncuesta = regex.exec($(this).attr('id')).pop();
                                    $(this).text("Ocultar")

                                    container.empty();
                                    $.ajax({
                                        url: '../php/getuserAnswers.php',
                                        type: 'POST',
                                        data: {idUsuario, idEncuesta},
                                        success: function (response) {
                                            console.log("response = " + response)
                                            try{
                                                let questions = JSON.parse(response);

                                                console.log(questions)

                                                questions.forEach(question => {
                                                    container.append(`
                                                        <p>
                                                            Pregunta: ${question.pregunta}:<br>
                                                            Respuesta: <br>${question.respuestas}<br>
                                                        
                                                        </p>
                                                    `)
                                                })


                                            }catch (e){

                                            }
                                        }

                                    })
                                }
                                else{
                                    $(this).text("Mostrar")
                                    container.empty();
                                }
                            })


                            $('#SurverAnsweredContainer').append(node);
                        })


                    }catch (e){
                        $('#SurverAnsweredContainer').append(`
                            <p>No tiene encuestas pendientes</p>
                        `)
                    }

                },
                error: function () {

                }
            })

            UserProfile.toggle();
        })

        node.find('.sendEmailProfile').on('click', function (e) {
            e.stopPropagation();
            $('#userEmailSelected').val($(this).parent().parent().siblings('td:eq(9)').text())
            SendEmail.toggle();
        })
        
        node.find('.deleteUser').on('click', function (e) {
            e.stopPropagation();
            let modal = new bootstrap.Modal($('#deleteUserModal')[0]);
            let userId = $(this).parent().parent().parent().attr('id');
            let regex = RegExp('[0-9]+')


            $('#ConfirmDeleteUser').val(regex.exec(userId).toString());
            modal.show();
        })



        return node;
    }

    function initTooltips() {
        //habilitar los tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

    }

    function refreshTable() {
        //obtener todos los filtros

        //obtener los nombres
        let Nombres = "N_A"
        if($('#Names').val() !== "") //verificar que no está vacio
            Nombres = $('#Names').val();


        //obtener los apellidos
        let Apellidos = "N_A"
        if($('#SecondNames').val() !== "") //verificar que no está vacio
            Apellidos = $('#SecondNames').val();


        //obtener el campus
        let Campus = "N_A"
        if($('#CampusText').siblings().children().prop('checked')){ //verificar si está seleccionado
            if($('#CampusText').val() !== "") //verificar que no está vacio
                Campus = $('#CampusText').val();
        }

        //obtener la facultad
        let Facultad = "N_A";
        if($('#FacultyText').siblings().children().prop('checked')){
            if($('#FacultyText').val() !== "")
                Facultad = $('#FacultyText').val();
        }

        //obtener Plan_Estudio
        let Plan_Estudio = "N_A";
        if($('#Program').siblings().children().prop('checked')){
            if($('#Program').val() !== "")
                Plan_Estudio = $('#Program').val();
        }

        //obtener Empresa
        let Empresa = "N_A";
        if($('#Company').siblings().children().prop('checked')){
            if($('#Company').val() !== "")
                Empresa = $('#Company').val();
        }

        //obtener puesto
        let Puesto = "N_A";
        if($('#rol').siblings().children().prop('checked')){
            if($('#rol').val() !== "")
                Puesto = $('#rol').val();
        }

        //Obtener ciudad
        let Ciudad = "N_A";
        if($('#City').siblings().children().prop('checked')){
            if($('#City').val() !== "")
                Ciudad = $('#City').val();
        }

        //PRUEBA//
        let IdAdmin = getCookie('id');


        $.ajax({
            url: '../php/getFilteredUsers.php',
            type: 'POST',
            data: {Campus, Facultad, Plan_Estudio, Empresa, Puesto, Ciudad, Nombres, Apellidos, IdAdmin},
            success: function (response){
                try{
                        let users = JSON.parse(response);
                        localStorage.setItem(JSON_FOR_CSV, response);
                        $('#UsersContainer').children().remove('tr');
                        users.forEach(user => {
                            $('#UsersContainer').append(UserRow(user.Matricula, user.Nombres, user.Apellidos,
                                                                user.Campus, user.Facultad, user.Plan_Estudio,
                                                                user.Empresa, user.Puesto, user.Ciudad, user.Correo, user.idUsuario));
                            })

                        initTooltips();


                }catch (e){
                    console.log("Error + " + response)
                }
            },
            error:  function (jqXHR, textStatus, errorThrown) {
                alert("Error #1 = " + jqXHR)
                alert("Error #2 = " + textStatus)
                alert("Error #3 = " + errorThrown)

            }
        })


    }

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

    function deleteUser(userId) {

    }

    const filters = $('.custom-checkbox');
    const AdvanceSearch = $('#AdvanceSearch');
    const FiltersContainer =  $('#FiltersContainer');
    const UserProfile = new bootstrap.Offcanvas($('#UserProfile')[0]);
    const SendEmail = new bootstrap.Offcanvas($('#SendEmail')[0]);

    filters.parent().siblings().attr('disabled', true); //deshabilitar por default los filtros
    initTooltips();
    filters.on('click', function (e) {
        $(this).parent().siblings().attr('disabled', !$(this).prop('checked'))
    })


    FiltersContainer.hide();
    FiltersContainer.removeClass('d-none');
    
    AdvanceSearch.on('click', function (e) {
        const hideAdvanceSearch = 'Ocultar búsqueda avanzada';
        const showAdvanceSearch = 'Búsqueda avanzada'
        const FilterContainer = $('#FiltersContainer');

        if($(this).text() === hideAdvanceSearch){
            $(this).text(showAdvanceSearch)
        }else{

            $(this).text(hideAdvanceSearch)
        }
        FilterContainer.toggle(700);
    })

    $('#Names,#SecondNames,#CampusText,#FacultyText,#Program,#Company,#City,#rol').on('keyup', function (e) {
        refreshTable();
    })

    $('#ConfirmDeleteUser').on('click', function (e) {
        e.stopPropagation();

        let idUsuario = $(this).val();


        $.ajax({
            url: '../php/deleteUser.php',
            type: 'POST',
            data: {idUsuario},
            success: function (response) {
                if(parseInt(response, 10) === 0){
                    alert("Eliminado con exito");
                    refreshTable();
                }
            }
        })
    })

    $('#GoHome').on('click', function (e){

        window.location = "../php/menu.php";

    })

    $('#sendEmailToUser').on('click', function (e) {
        console.log("se dio click")
        let asunto = $('#Asunto').val();
        let mensaje = $('#message').val();
        let correoUsuario = $('#userEmailSelected').val()

        $.ajax({
            url: '../php/sendMail.php',
            type: 'POST',
            data: {correoUsuario, asunto, mensaje},
            success: function (response) {
                console.log("RESPUESTA CORREO " + response);
               if(parseInt(response, 10) === 0){
                   alert("Mensaje enviado con exito")
               }
               else
               {
                   alert("No se pudo enviar el mensaje")
               }
            }

        })


    })

    $('#generateCSV').on('click', function (e) {
        e.stopPropagation();
        
        let nombreArchivo = "Usuarios"
        let datos = localStorage.getItem(JSON_FOR_CSV);
        
        
        $.ajax({
            url: '../php/downloadAsCSV.php',
            data: {nombreArchivo, datos},
            type: 'POST',
            success:  function (data) {

                const downloadLink = document.createElement("a");
                const fileData = ['\ufeff' + data];

                const blobObject = new Blob(fileData, {
                    type: "text/csv;charset=utf-8;"
                });

                const url = URL.createObjectURL(blobObject);
                downloadLink.href = url;
                downloadLink.download = nombreArchivo;

                /*
                 * Actually download CSV
                 */
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);

            },
            error: function () {
                
            }
            
            
        })
        
    })
    refreshTable();
})