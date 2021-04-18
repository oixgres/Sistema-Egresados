const RADIO = 0;
const TEXT_AREA = 1;
const INPUT = 2;
const CHECKBOX = 3;

//$('#customRadio_21').prop('checked') para checar radio o checkboxes

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
    }
}
class AnswersToDatabase{
    constructor(totalQuestions) {
        this.progressBar = $('#ProgressBarDatabase');
        this.progressBarTick = 100/totalQuestions;
        this.num_regex = RegExp('[0-9]+'); //extraer el numero de id de los componenets
        this.currentProgress = 0;


        this.ajaxRequestForSaveAnswer = function(idPregunta, idUsuario, respuesta){
            $.ajax({
                url: '../php/setUserAnswer.php',
                async: false,
                data: {idPregunta, idUsuario, respuesta},
                type: 'POST',
                success: function (response) {
                    if(parseInt(response) > 0){
                        //exito

                    }else{
                        //error

                    }
                }
            })


        }

        this.SaveAnswersToDatabase = function (idUsuario) {
            this.currentProgress = 0;
            this.SaveRadioAnswersToDatabase(idUsuario)
            this.SaveInputAnswersToDatabase(idUsuario);
            this.SaveCheckBoxAnswersToDatabase(idUsuario);
            this.saveTextAreaAnswersToDatabase(idUsuario);

        }
        this.SaveInputAnswersToDatabase = function(idUsuario){
            let inputQuestions = $('.input_question');

            for(let i = 0; i < inputQuestions.length; i++){
                let title_id = inputQuestions[i].children[0].getAttribute('id');
                let idPregunta = this.num_regex.exec(title_id).pop();

                let answers = $(`#${title_id}`).siblings().children();

                for(let j = 0; j < answers.length; j++){

                    if(answers[j].value !== ""){
                        this.ajaxRequestForSaveAnswer(idPregunta, idUsuario, answers[j].value);
                    }
                    else{

                    }
                }
                this.currentProgress += this.progressBarTick;
                this.progressBar.css('width', `${this.currentProgress}%`)
            }

        }
        this.saveTextAreaAnswersToDatabase = function(idUsuario){
            let textAreaQuestions = $('.textArea_question');

            for(let i = 0; i < textAreaQuestions.length; i++){

                let title_id = textAreaQuestions[i].children[0].getAttribute('id');
                let idPregunta = this.num_regex.exec(title_id).pop();

                let answers = $(`#${title_id}`).siblings().children();

                for(let j = 0; j < answers.length; j++){

                    if(answers[j].value !== ""){
                        this.ajaxRequestForSaveAnswer(idPregunta, idUsuario, answers[j].value);
                    }
                    else{

                    }
                }
                this.currentProgress += this.progressBarTick;
                this.progressBar.css('width', `${this.currentProgress}%`)
            }


        }
        this.SaveRadioAnswersToDatabase = function (idUsuario) {
            //traerme todas las preguntas tipo radio
            let questions = $('.radio_question');

            for(let i = 0; i < questions.length; i++){ //recorrer pregunta por pregunta
                let title_id = questions[i].children[0].getAttribute('id'); //obtener un id de referencia
                let idPregunta = this.num_regex.exec(title_id).pop();//obtener id para la base de datos
                let respuesta = null;

                let answers = $(`#${title_id}`).siblings().children('.Answer');//obtener todas las respuestas (labels)

                for(let j = 0; j < answers.length; j++){
                    let radio = $(`#${answers[j].getAttribute('for')}`); //traerme el radio de la primera respuesta

                    if(radio.prop('checked')) {
                        respuesta = answers[j].textContent;
                        break;
                    }
                }

                this.ajaxRequestForSaveAnswer(idPregunta, idUsuario, respuesta);
                this.currentProgress += this.progressBarTick;
                this.progressBar.css('width', `${this.currentProgress}%`)
            }

        }
        this.SaveCheckBoxAnswersToDatabase = function (idUsuario) {
            let checkBoxQuestions = $('.checkbox_question') //obtener todas las preguntas tipo checkbox

            for(let i = 0; i < checkBoxQuestions.length; i++){

                let title_id = checkBoxQuestions[i].children[0].getAttribute('id');
                let idPregunta = this.num_regex.exec(title_id).pop();

                let answers = $(`#${title_id}`).siblings().children('.Answer');//obtener todas las respuestas (labels)

                for(let j = 0; j < answers.length; j++){
                    let checkbox = $(`#${answers[j].getAttribute('for')}`); //traerme la checkbox de la primera respuesta

                    if(checkbox.prop('checked')){
                        this.ajaxRequestForSaveAnswer(idPregunta, idUsuario, answers[j].textContent)
                    }
                }

                this.currentProgress += this.progressBarTick;
                this.progressBar.css('width', `${this.currentProgress}%`)
            }

        }
    }
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

$(document).ready(function (e) {

    const survey_selected_id = 'survey_selected_id'; //nombre para guardar el ID de la encuesta seleccionada

    //cookie de prueba del php
    const id = "id";
    document.cookie = "id=1"
    ///

    const container = $('.container');
    const QuestionsContainer = $('#QuestionsContainer');
    const idUsuario = getCookie(id); //obtener el id de usuario
    let questionCreator = new QuestionCreator(QuestionsContainer); //creador de prguntas
    let answersToDatabase = null; //clase para guardar las preguntas en la base de datos
    const showSelectedSurvey = $('#showSelectedSurvey'); //boton para mostrar el contenido de la encuesta
    const SaveAnswersToDatabase = $('#SaveAnswersToDatabase');



    container.on('click', function (e) { //evento principal para el contenedor
        $('.dropdown-menu').hide(500);
    })
    container.hide(0, function (e) {
        container.show(700);
    })

    SaveAnswersToDatabase.on('click', function (e) {
        answersToDatabase =  new AnswersToDatabase(questionCreator.totalQuestions);
        answersToDatabase.SaveAnswersToDatabase(idUsuario);
    })

    showSelectedSurvey.on('click', function (e) {
      //mostrar todas las preguntas y respuestas
        let idEncuesta = sessionStorage.getItem(survey_selected_id);
        QuestionsContainer.empty();
        QuestionsContainer.hide();

        //peticion para mostrar las rpreguntas y respuestas
        $.ajax({
            url: '../php/getQuestions.php',
            data: {idEncuesta},
            type: 'POST',
            success: function (response){

                try{
                    let questions = JSON.parse(response);
                    if(questions.length > 0){
                        //mostrar las preguntas
                        questions.forEach(question => {
                            let idPregunta = question.idPregunta; //obtener id de la pregunta
                            let questionTitle = question.pregunta;//obtener titulo de la pregunta
                            let questionType = question.tipo; //obtener el tipo de respuestas
                            let answers_text = []; //arreglo para almacenar las respuestas
                            let answers_id = [];//arreglo para almacenar als id


                            //obtener las respuestas por cada pregunta
                            $.ajax({
                                url: '../php/getAnswers.php',
                                async: false,
                                data: {idPregunta},
                                type: 'POST',
                                success: function (response) {
                                    try {
                                        let answers_response = JSON.parse(response);
                                        answers_response.forEach(answer_response =>{
                                            answers_id.push(answer_response.idRespuesta);
                                            answers_text.push(answer_response.respuesta);
                                        });
                                    }
                                    catch (e) {
                                        console.log(response)
                                    }
                                }

                            })

                            switch (parseInt(questionType)) {
                                case RADIO: questionCreator.createRadioAnswer(questionTitle, answers_text, idPregunta, answers_id);
                                            break;

                                case INPUT:  questionCreator.createInputQuestion(questionTitle, answers_text, idPregunta, answers_id);
                                             break;

                                case TEXT_AREA: questionCreator.createTextareaQuestion(questionTitle, answers_text, idPregunta, answers_id);
                                                break;

                                case CHECKBOX:  questionCreator.createCheckBoxQuestion(questionTitle, answers_text, idPregunta, answers_id);
                                                break;

                            }

                            answers_text = [];
                            answers_id = [];

                        });
                        QuestionsContainer.show(900);
                    }
                    else{
                        alert("La encuesta está vacia")
                    }


                }catch (e) {
                    console.log(response)
                }
            }

        });

    });
    //peticion para obtener las encuestas
    $.ajax({
        url: '../php/getSurveys.php', //obtener las encuestas
        data:   {idUsuario}, //mandar el idUsuario
        type:   'POST',
        success: function (response) {
            try{
                let node = null;
                let AvailableSurveysMenu = $('#AvailableSurveysMenu');
                let surveys = JSON.parse(response); //si la respuesta es un json pasarlo a arreglo

                console.log(surveys)
                surveys.forEach(survey => { //para cada encuesta encontrada
                    //<a class="dropdown-item">Action</a>
                    node = $(`
                        <a class="dropdown-item" id="${survey.idEncuesta}">${survey.encuesta}-${survey.alcance}</a>
                    `);
                    node.on('click', function (e) {
                        e.stopPropagation();
                        sessionStorage.setItem(survey_selected_id, $(this).attr('id')) //colocalr la id de la encuesta seleccionada
                        $(this).parent().siblings('button').text((this).text) //colocar el nombre de la encuesta en el boton
                        $(this).parent().hide(400); //ocultar dropdon
                    })
                    AvailableSurveysMenu.append(node); //agregar encuesta
                })


                let button = $('#AvailableSurveysButton'); //obtener el boton de referenca
                let spinner = button.children('span'); //obtener la barra de progreso

                button.on('click', function (e) {
                    e.stopPropagation();
                    let dropdownMenu = $(this).siblings('.dropdown-menu'); //mostrar dropdown
                    dropdownMenu.toggle(400);
                })

                spinner.addClass('d-none'); //ocultar el spinner
                button.text('Seleccione una encuesta') //cambiar el texto del dropdown


            }catch (e) {
                let button = $('#AvailableSurveysButton'); //obtener el boton de referenca
                let spinner = button.children('span'); //obtener la barra de progreso
                spinner.addClass('d-none'); //ocultar el spinner
                button.text('No hay encuestas disponibles') //cambiar el texto del dropdown
                $('#showSelectedSurvey').hide(500);
                //dependiendo el error tomar una decicion
            }
        }
    });



})