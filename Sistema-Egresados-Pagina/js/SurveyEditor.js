$(document).ready(function () {
    const RADIO = 0;
    const TEXT_AREA = 1;
    const INPUT = 2;
    const CHECKBOX = 3;

    class TableManager{ //clase para manejar las filas de las encuestas
        constructor(container) {
            this.ShowSurveyOffcanvas = new bootstrap.Offcanvas($('#SurveyContainerShow')[0]);
            this.ShowEditSurveyCanvas = new bootstrap.Offcanvas($('#SurveyContainerEdit')[0]);
            this.ConfirmDeleteModal = new bootstrap.Modal($('#ConfirmDeleteDialog')[0]);
            this.numberRegex = RegExp('[0-9]+')
            this.container = container; //contenedor padre
            this.scopeTypes = ["UNIVERSIDAD", "CAMPUS", "FACULTAD", "PROGRAMA ACADEMICO"]

            //funcion para mostrar una nueva encuesta
            this.createSurveyDataRow =  function (surveyId,surveyName, type_scope, scope_name, num_questions) {
                let regex = this.numberRegex
                let showSurveyCanvas = this.ShowSurveyOffcanvas;
                let showEditCanvas = this.ShowEditSurveyCanvas;
                let showConfirmDeleteModal = this.ConfirmDeleteModal;
                //Nodo html para crear una nueva fila
                let node = $(`
                    <tr id="surveyNumber_${surveyId}">
                        <td>${surveyName}</td>
                        <td>${this.scopeTypes[type_scope]}</td>
                        <td>${scope_name}</td>
                        <td>${num_questions}</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn mr-1 btn-success showSurvey" data-bs-toggle="tooltip" data-bs-placement="left" title="Ver">
                                    <span class="fa fa-search"></span>
                                    <span class="spinner-border spinner-border-sm float-right d-none" role="status"></span>
                                </button>
                                <button class="btn btn-info mr-1 showEditSurvey" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar">
                                    <span class="fa fa-edit"></span>
                                    <span class="spinner-border spinner-border-sm float-right d-none" role="status"></span>
                                </button>
                                <button class="btn btn-danger deleteSurvey" data-bs-toggle="tooltip" data-bs-placement="right" title="Eliminar">
                                    <span class="fa fa-times"></span>
                                    <span class="spinner-border spinner-border-sm float-right d-none" role="status"></span>
                                </button>
                            </div>
                        </td>
                    </tr>
                `);

                node.find('.showSurvey').on('click', function (e) {
                    //click the show survey
                    e.stopPropagation();
                    let row = $(this).parent().parent().parent() //Obtener la fila
                    let idEncuesta = regex.exec(row.attr('id')).pop(); //obtener id de la encuesta
                    let searchIcon = $(this).children().first();
                    let spinner = $(this).children().last();


                    searchIcon.addClass('d-none');
                    spinner.removeClass('d-none');

                    //peticion ajax para mostrar la enceusta
                    showSurveyFromDatabase(idEncuesta);
                    /*********************************/

                    showSurveyCanvas.toggle(); //mostrar offcanvas

                    spinner.addClass('d-none');
                    searchIcon.removeClass('d-none');

                })

                node.find('.showEditSurvey').on('click', function (e) {
                    e.stopPropagation();
                    let row = $(this).parent().parent().parent() //Obtener la fila
                    let idEncuesta = regex.exec(row.attr('id')).pop(); //obtener id de la encuesta
                    let searchIcon = $(this).children().first();
                    let spinner = $(this).children().last();

                    searchIcon.addClass('d-none');
                    spinner.removeClass('d-none');

                    //peticion ajax

                    //

                    showEditCanvas.toggle(); //mostrar offcanvas

                    spinner.addClass('d-none');
                    searchIcon.removeClass('d-none');

                })

                node.find('.deleteSurvey').on('click', function (e) {
                    e.stopPropagation();
                    let row = $(this).parent().parent().parent() //Obtener la fila
                    let idEncuesta = regex.exec(row.attr('id')).pop(); //obtener id de la encuesta
                    let searchIcon = $(this).children().first();
                    let spinner = $(this).children().last();
                    let ConfirmDeleteSurvey = $('#ConfirmDeleteSurvey');
                    let ConfirmDeleteDialog = $('#ConfirmDeleteDialog');

                    searchIcon.addClass('d-none');
                    spinner.removeClass('d-none');

                    //Quitar listener
                    ConfirmDeleteSurvey.off('click');

                    //agregar nuevo listener
                    ConfirmDeleteSurvey.on('click', function (e) {
                        e.stopPropagation()
                        showConfirmDeleteModal.hide();
                        deleteSurvey(idEncuesta);

                    })

                    //peticion ajax para mostrar la enceusta
                    showConfirmDeleteModal.show();
                    /*********************************/

                    ConfirmDeleteDialog.off('hidden.bs.modal')
                    ConfirmDeleteDialog.on('hidden.bs.modal', function (e) {

                        spinner.addClass('d-none');
                        searchIcon.removeClass('d-none');
                    })

                })



                this.container.append(node); //insertamos el nodo al contenedor
            }
            this.cleanContainer = function () {
                $('#surveyDataContainer').children().remove('tr')
            }

        }
    }
    class QuestionCreator{

        constructor(parent) {
            this.question_id = 0;
            this.parent = parent;
            this.totalQuestions = 0;

            this.createCheckBoxQuestion = function (title, answers_text = [], question_id, answers_id = []) {
                this.totalQuestions++;
                let parentNode = $(`<div class="col-12 checkbox_question mt-3"></div>`); //create parent node
                let titleNode = $(`<h3 class="Question_title" id="Question_${question_id}">${title}</h3>`);// create title node
                parentNode.append(titleNode); //append title node to the parentNode
                for(let i = 0; i < answers_text.length; i++){
                    //create a answer node
                    let answerNode = $(` 
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" id="customRadio_${answers_id[i]}" class="custom-control-input">
                        <label class="custom-control-label Answer" for="customRadio_${answers_id[i]}">${answers_text[i]}</label>
                    </div>
                `)

                    parentNode.append(answerNode); //append answer to the question
                }
                this.parent.append(parentNode); //append the question to the container
            } //funcion para crear una pregunta checkbox
            this.createInputQuestion = function (title, answers_text = [], question_id, answers_id = []) {
                this.totalQuestions++;
                let parentNode = $(`<div class="col-12 input_question mt-3"></div>`); //create parent node
                let titleNode = $(`<h3 class="Question_title" id="Question_${question_id}">${title}</h3>`);// create title node
                parentNode.append(titleNode); //append title node to the parentNode
                for(let i = 0; i < answers_text.length; i++){
                    //create a answer node
                    let answerNode = $(`
                    <div class="form-group">
                        <input type="text" class="form-control Answer" id="answer_${answers_id[i]}" placeholder="${answers_text[i]}">
                    </div>
                `)
                    parentNode.append(answerNode); //append answer to the question
                }
                this.parent.append(parentNode); //append the question to the container
            } //funcion para crear una pregunta tipo input
            this.createTextareaQuestion = function (title, answers_text = [], question_id, answers_id = []) {
                this.totalQuestions++;
                let parentNode = $(`<div class="col-12 textArea_question mt-3"></div>`); //create parent node
                let titleNode = $(`<h3 class="Question_title" id="Question_${question_id}">${title}</h3>`);// create title node
                parentNode.append(titleNode); //append title node to the parentNode
                for(let i = 0; i < answers_text.length; i++){
                    //create a answer node
                    let answerNode = $(`
                    <div class="form-group">
                        <textarea type="text" class="form-control Answer" id="answer_${answers_id[i]}" placeholder="${answers_text[i]}"></textarea>
                    </div>
                `)
                    parentNode.append(answerNode); //append answer to the question
                }
                this.parent.append(parentNode); //append the question to the container
            } //funcion para crear una funcion tipo text area
            this.createRadioAnswer = function (title, answers_text = [], question_id, answers_id = []) {
                this.totalQuestions++;

                let parentNode = $(`<div class="col-12 radio_question mt-3"></div>`); //create parent node
                let titleNode = $(`<h3 class="Question_title" id="Question_${question_id}">${title}</h3>`);// create title node
                parentNode.append(titleNode); //append title node to the parentNode
                for(let i = 0; i < answers_text.length; i++){
                    //create a answer node
                    let answerNode = $(`
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio_${answers_id[i]}" name="radio_${this.question_id}" class="custom-control-input">
                        <label class="custom-control-label Answer" id="answer_${answers_id[i]}" for="customRadio_${answers_id[i]}">${answers_text[i]}</label>
                    </div>
                `)
                    parentNode.append(answerNode); //append answer to the question

                }
                this.parent.append(parentNode); //append the question to the container
                this.question_id++;
            } //funcion para crear una funcion tipo radio
            this.cleanContainer = function () {
                parent.empty();
            }
        }
    }
    class QuestionEditorManager{
        constructor(parent) {
            this.parent = parent;
            this.offCanvas = $('#QuestionEdit');

        }
    }

    function initializeTooltips() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')); //initialize tooltips
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    }
    function refreshTable() {
        tableManager.cleanContainer();
        $.ajax({
            url: '../php/getAdminSurveys.php',
            data:   {idAdmin},
            type: 'POST',
            success: function (response) {
                try{
                    let json = JSON.parse(response);

                    json.forEach(survey => {
                        tableManager.createSurveyDataRow(survey.idEncuesta, survey.nombre, survey.tipoAlcance, survey.alcance, survey.numPreguntas)
                    });

                    initializeTooltips(); //inicializar tooltips
                }catch (e) {

                }
            },
            error:  function (jqXHR, textStatus, errorThrown) {
                alert("error")
            }
        })
    }
    function showSurveyFromDatabase(idEncuesta){
        const QuestionContainer = $('#QuestionContainer')
        const questionCreator = new QuestionCreator(QuestionContainer)

        questionCreator.cleanContainer();

        //peticion ajax para obtener las preguntas
        $.ajax({
            url: '../php/getQuestions.php',
            async: false,
            data: {idEncuesta},
            type: 'POST',
            success: function (response) {

                try {
                    let questions = JSON.parse(response); //convetir el json a array
                    questions.forEach(question => {
                        let idPregunta = question.idPregunta;
                        let title = question.pregunta;
                        let type = question.tipo;
                        let answers_text = [];
                        let answers_id = [];
                        
                        //peticion ajax para obtener las respuestas
                        $.ajax({
                            url: '../php/getAnswers.php',
                            async: false,
                            data: {idPregunta},
                            type: 'POST',
                            success: function (response) {
                                try{
                                    let answers = JSON.parse(response);

                                    answers.forEach(answer => {
                                        answers_id.push(answer.idRespuesta);
                                        answers_text.push(answer.respuesta);
                                    })


                                }catch (e) {
                                    alert("error")
                                }

                            },
                            error:  function (jqXHR, textStatus, errorThrown) {
                                alert("error")
                            }
                        })
                        switch(type){
                            case 0: questionCreator.createRadioAnswer()
                        }

                        switch (parseInt(type, 10)){

                            case RADIO: questionCreator.createRadioAnswer(title, answers_text, idPregunta, answers_id);
                                        break;

                            case INPUT: questionCreator.createInputQuestion(title, answers_text, idPregunta, answers_id);
                                        break;

                            case TEXT_AREA: questionCreator.createTextareaQuestion(title, answers_text, idPregunta, answers_id);
                                            break;

                            case CHECKBOX: questionCreator.createCheckBoxQuestion(title, answers_text, idPregunta, answers_id);
                                            break;

                        }

                    })
                } catch (e) {

                }
            },
            error:  function (jqXHR, textStatus, errorThrown) {
                alert("error")
            }

        })

    }
    function deleteSurvey(idEncuesta) {


        $.ajax({
            url: '../php/deleteSurvey.php',
            data: {idEncuesta},
            async: false,
            type: 'POST',
            success: function (response) {
                if(parseInt(response, 10) === 0){
                    refreshTable();
                }
                else{
                    console.log(response)
                }
            },
            error:  function (jqXHR, textStatus, errorThrown) {
                alert("error")
            }

        })
    }


    const idAdmin = 1;
    const tableManager = new TableManager($('#surveyDataContainer'));

    $(document).ready(function(){
        $(".owl-carousel").owlCarousel({
            responsive: {
                0:{
                    items: 1
                },
                575: {
                    items: 2
                },
                767: {
                    items: 3
                },

            }
        });
    });

    refreshTable();
})