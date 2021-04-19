$(document).ready(function (e) {
    /*
        case 'Radio':   return 0;
        case 'Text Area':   return 1;
        case 'Input':   return 2;
        case 'Checkbox':    return 3;
        default:    return -1;
     */
    $('#QuestionContainerController,#QuestionContainerPreview').hide();
    const SHOW_DELAY = 600;
    const toast = $('.toast');
    //<source src="../sounds/ShowSuccessToast.ogg" type="audio/ogg">
    let ShowSuccessToastSound = new Audio('../sounds/definite-555.ogg');
    let ShowFaildedSound = new Audio('../sounds/dont-think-so-556.ogg');

    toast.toast('hide');

    class QuestionControler{
        constructor(parent, previewController) {
            this.parent = parent;
            this.num_id = 0;

            this.createQuestion = function () {
                let item_active;

                if(this.num_id === 0)
                    item_active = 'active' //en caso que sea el primer item creado
                else
                    item_active = '';

                let node = $(`
                 <div class="carousel-item ${item_active}" id="carousel_item_${this.num_id}">
                    <div class="row"><!-- Estructura de una pregunta -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-title mt-2">
                                    <h4 class="text-center">Pregunta y respuestas</h4>
                                </div>

                                <div class="card-body row"> <!-- Contenedor principal de preguntas  -->

                                    <div class="col-12"> <!-- Tema de la pregunta -->
                                        <div class="form-group">
                                            <label for="QuestionTopic_${this.num_id}">Tema</label>
                                            <input type="text" class="form-control QuestionTopic" placeholder="Introduce el tema de la pregunta" id="QuestionTopic_${this.num_id}">
                                             <div class="valid-feedback"> <!-- Para habilitarlo agregar clase is-valid al input -->
                                                Correcto
                                            </div>
                                            <div class="invalid-feedback"> <!-- Para habilitarlo agregar clase is-invalid al input -->
                                                Favor de llenar el campo
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="col-12"> <!-- Titulo de la pregunta -->
                                        <div class="form-group">
                                            <label for="QuestionTittle_${this.num_id}">Titulo de la pregunta</label>
                                            <input type="text" class="form-control QuestionTitle" placeholder="Introduce el título de la pregunta" id="QuestionTittle_${this.num_id}">
                                            <div class="valid-feedback"> <!-- Para habilitarlo agregar clase is-valid al input -->
                                                Correcto
                                            </div>
                                            <div class="invalid-feedback"> <!-- Para habilitarlo agregar clase is-invalid al input -->
                                                Favor de llenar el campo
                                            </div>
                                        </div>
                                    </div>
                                   

                                    <div class="col-12"> <!-- Tipo de respuestas -->
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-info btn-block dropdown-toggle rounded-pill QuestionType" id="QuestionType_${this.num_id}">Tipo de respuestas</button>
                                            <div class="dropdown-menu col col-12" id="Answer_items_${this.num_id}">
                                                <a class="dropdown-item">Radio</a>
                                                <a class="dropdown-item">Input</a>
                                                <a class="dropdown-item">Text Area</a>
                                                <a class="dropdown-item">Checkbox</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 AnswerContainer" id="AnswersContainer_${this.num_id}"> <!-- Componente padre de las respuestas -->
         
                                        
                                    </div>


                                    <div class="col-6 mt-2">
                                        <button type="button" class="btn btn-info btn-block rounded-pill" id="AddAnswer_${this.num_id}">Añadir Respuesta</button>
                                    </div>

                                    <div class="col-6 mt-2">
                                        <button type="button" class="btn btn-danger btn-block rounded-pill" id="DiscardAnswer_${this.num_id}">Descartar Respuestas</button>
                                    </div>
                                    
                                    <div class="col-12 mt-2">
                                        <button type="button" class="btn btn-danger btn-block rounded-pill mb-5" id=DeleteQuestion_${this.num_id}>Eliminar Pregunta</button>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- Estructura de una pregunta -->
                    </div>
                </div>`)

                node.find(`#QuestionType_${this.num_id}`).on('click', function (e) { //Agregar listener al boton de questionType
                    e.stopPropagation();
                    let dropdownMenu = $(this).siblings('.dropdown-menu');
                    dropdownMenu.toggle(SHOW_DELAY);
                })

                node.find(`#QuestionTopic_${this.num_id},#QuestionTittle_${this.num_id}`).on('keyup', function (e) {
                    e.stopPropagation();
                    previewController.updatePreview();
                })
                
                node.find(`.dropdown-item`).on('click', function (e) { //agregar listeners a los items
                    let button = $(this).parent().siblings();
                    button.text((this).text);
                    previewController.updatePreview();
                })

                let num_id = this.num_id;
                node.find(`#DiscardAnswer_${this.num_id}`).on('click', function (e) {
                    e.stopPropagation();
                    $(`#AnswersContainer_${num_id}`).hide(SHOW_DELAY, function (e) {
                        $(this).empty();
                        $(this).show();
                        previewController.updatePreview();
                    })
                })

                node.find(`#DeleteQuestion_${this.num_id}`).on('click', function (e) {
                    e.stopPropagation();
                    let carousel = $('#QuestionCarousel');
                    let current = carousel.find('.carousel-item.active');

                    if($('#QuestionContainer').children().length > 1){
                        current.hide(0, function (e) {
                            current.remove();
                            let next = carousel.find('.carousel-item').last();
                            next.addClass('active');
                        })
                    }

                })


                node.find(`#AddAnswer_${this.num_id}`).on('click', function (e) { //listener para agregar una respuesta a la pregunta
                    e.stopPropagation();

                    let node = $(`
                        <div class="col-12 mt-1">
                            <div class="input-group">
                                <input type="text" class="form-control Answer" placeholder="Texto de la Respuesta">
                                 <span class="input-group-btn">
                                    <button class="btn btn-secondary deleteAnswer" type="button"><img class="img-fluid" src="../img/Icons/eliminar-simbolo.png" alt="Eliminar"/></button>
                                 </span>
                            </div>                                   
                        </div>
                    `); //nodo de la pregunta

                    let id = $(this).attr('id'); //obtener atributo ID
                    let regex = new RegExp('[0-9]+') //expresion regular
                    let num_id = regex.exec(id); //obtener el numero de id
                    node.hide(); //ocultar
                    $('#AnswersContainer_' + num_id).append(node); //agregar
                    node.show(SHOW_DELAY); //aplicar efecto

                    node.find('.Answer').on('keyup', function (e) {
                        e.stopPropagation();
                        previewController.updatePreview();
                    })

                    node.find('button').on('click', function (e) {
                        e.stopPropagation();
                        $(this).parent().parent().parent().hide(300, function (e){
                            $(this).remove();
                            previewController.updatePreview();
                        });
                    })


                    previewController.updatePreview();
                })

                this.parent.append(node); //agregar nodo a la componente padre
                this.num_id++;

                $('.carousel').carousel({
                    interval: false,
                });
            }
            this.getTopicOfQuestion = function (num_id) {
                let topic = $(`QuestionTopic_${num_id}`);

                if(topic)
                    return topic;
                else
                    return 'N/A';
            }
            this.getTittleOfQuestion = function (num_id) {

                let tittle = $(`#QuestionTittle_${num_id}`).val();

                if(tittle)
                    return tittle;
                else
                    return "Sin Titulo"
            }
            this.getTypeOfanswers = function (num_id) {
                let type = $(`#QuestionType_${num_id}`).text();
                if(type !== 'Tipo de respuestas')
                    return type;
                else
                    return 'NO_TYPE'
            }
            this.getAllAnswerCount = function (e) {
                return $('#QuestionContainer .Answer').length;
            }
            this.getAnswersText = function (num_id) {
                let answersInputs = $(`#AnswersContainer_${num_id} .Answer`);
                let answersArray = [];

                for(let i = 0; i < answersInputs.length; i++){
                    answersArray.push(answersInputs[i].value);
                }

                return answersArray;
            }
            this.getAllQuestionTittles = function(){
                let QuestionItems = $('#QuestionContainer .QuestionTitle')//traerme todas las preguntas de #QuestionContainer
                let questionArray = Array();

                for(let i = 0; i < QuestionItems.length; i++){
                    questionArray.push(QuestionItems[i].value); //obtener todos los textos de las preguntas
                    //aqui validar que todas las preguntas tengan titulo
                }
                return questionArray; //retornar el arreglo de las preguntas
            }
            this.getAllQuestionsType = function (){
                let QuestionTypes = $('#QuestionContainer .QuestionType');
                let typesArray = Array();

                for(let i = 0; i < QuestionTypes.length; i++)
                    typesArray.push(this.getNumericalType(QuestionTypes[i].textContent));
                
                return typesArray;
            }
            this.getAllQuestionTopics = function () {
                let QuestionTopics = $('#QuestionContainer .QuestionTopic');
                let topicsArray = Array();

                for(let i = 0; i < QuestionTopics.length; i++){
                    topicsArray.push(QuestionTopics[i].value);
                }

                return topicsArray;
            }
            this.getNumOfQuestions = function (){
                return(parent.children().length);
            }
            this.getAllAnswersByQuestion = function () {
                let answerContainers = $('#QuestionContainer .AnswerContainer')
                let AnswerArrayGroup = Array();
                let AnswerArray = Array();

                for(let i = 0; i < answerContainers.length; i++){
                    AnswerArray = answerContainers[i].getElementsByClassName('Answer');
                    let group = Array();
                    for(let j = 0; j < AnswerArray.length; j++){
                        group.push(AnswerArray[j].value);
                    }

                    AnswerArrayGroup.push(group);
                }

                return AnswerArrayGroup;

            }
            this.getNumericalType = function (type_text) {
                switch (type_text) {
                    case 'Radio':   return 0;
                    case 'Text Area':   return 1;
                    case 'Input':   return 2;
                    case 'Checkbox':    return 3;
                    default:    return -1;
                }
            }
        }
    }

    class PreviewController{
        constructor(QuestionParent, AnswerParent) {
            this.QuestionParent = QuestionParent;
            this.AnswerParent = AnswerParent;
            this.num_id = 0;

            this.createCheckboxAnswer = function (text){
                let node = $(`
                    <div class="col-12" >
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="customRadio_${this.num_id}" name='checkbox' class="custom-control-input">
                            <label class="custom-control-label" for="customRadio_${this.num_id}">${text}</label>
                        </div>
                    </div>`
                );
                this.num_id++;
                return node;
            }
            this.createRadioAnswer = function (text, name) {
                let node = $(`
                     <div class="col-12" >
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio_${this.num_id}" name=${name} class="custom-control-input">
                            <label class="custom-control-label" for="customRadio_${this.num_id}">${text}</label>
                        </div>
                    </div>
                `);

                this.num_id++;
                return node;
            }
            this.createInputAnswer = function (text) {
                let node = $(`
                    <div class="col-12">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="${text}" id="preview_input_${this.num_id}">
                        </div>
                    </div>
                `);

                this.num_id++;
                return node;
            }
            this.createTextAreaAnswer = function (text) {
                let node = $(`
                    <div class="col-12">
                        <div class="form-group">
                            <textarea type="text" class="form-control" placeholder="${text}" id="preview_textArea_${this.num_id}"></textarea>
                        </div>
                    </div>
                `);

                this.num_id++;
                return node;
            }
            this.setTitle = function (title) {
                $('#QuestionTittlePreview').text(title);
            }
            this.setPreviewAnswes = function (type = "", answers = []) {
                let i;
                for(i = 0; i < answers.length; i++){
                    switch(type)
                    {
                        case 'Radio':   let R_node = this.createRadioAnswer(answers[i], 'preview');
                                        this.AnswerParent.append(R_node);
                                        R_node.show();
                                        break;

                        case 'Input':   let I_node = this.createInputAnswer(answers[i]);
                                        this.AnswerParent.append(I_node);
                                        I_node.show();
                                        break;

                        case 'Text Area':   let TA_node = this.createTextAreaAnswer(answers[i]);
                                            this.AnswerParent.append(TA_node);
                                            TA_node.show();
                                            break;

                        case 'Checkbox':    let CB_node = this.createCheckboxAnswer(answers[i]);
                                            this.AnswerParent.append(CB_node);
                                            CB_node.show();
                                            break;
                    }

                }

            }
            this.cleanPreview = function () {
                this.setTitle('')
                this.AnswerParent.empty();
                this.num_id = 0;
            }
            this.updatePreview = function () {
                this.cleanPreview();
                const activeItem_num_id = $('#QuestionContainer .carousel-item.active').attr('id');
                const regex = RegExp('[0-9]+');
                const num_id = regex.exec(activeItem_num_id);

                const title = questionController.getTittleOfQuestion(num_id);
                const type = questionController.getTypeOfanswers(num_id);
                const answers = questionController.getAnswersText(num_id);


                this.setTitle(title);
                this.setPreviewAnswes(type, answers);
            }
        }
    }

    let previewController = new PreviewController($('#PreviewQuestionContainer'), $('#AnswerPreviewContainer')); //componente padre del preview
    let questionController = new QuestionControler($('#QuestionContainer'), previewController); //crear un controlador para agregar preguntas

    function addListeners() {
        const main_container = $('.container');
        const SurveyScope = $('#SurveyScope');
        const dropdownItems = $('.dropdown-item');
        const AddQuestion = $('#AddQuestion');
        const CleanQuestions = $('#CleanQuestions');
        const QuestionCarousel = $('#QuestionCarousel');
        const AddSurvey = $('#AddSurvey');
        const SaveToDatabase = $(`#SaveToDatabase`);
        const questionFinder = $('#questionFinder');

        main_container.hide(0, function (e) {
            $(this).show(SHOW_DELAY);
        });

        SurveyScope.on('click', function (e) {
            e.stopPropagation();
            const dropdownMenu = $(this).siblings('.dropdown-menu');
            if(dropdownMenu.length)
                dropdownMenu.toggle(SHOW_DELAY);

        })

        questionFinder.on('keydown', function (e) {
            let value = $(this).val();

            if(e.key === 'Enter'){
               if(parseInt(value, 10)){
                   QuestionCarousel.carousel(parseInt(value, 10));
               }
            }
        })

        dropdownItems.on('click', function (e) {
            e.stopPropagation();
            const button = $(this).parent().siblings('button');
            const SurveyTopicLabel = $('#SurveyTopicLabel');
            const SurveyTopic = $('#SurveyTopic');

            if(button.length){
                button.text((this).text)
                $(this).parent().hide(SHOW_DELAY)

                switch(button.text()){
                    case 'Universidad': SurveyTopicLabel.text('Nombre de la Universidad')
                                        SurveyTopic.attr('placeholder', 'Introduce el nombre de la Universidad');
                                        break;

                    case 'Campus' : SurveyTopicLabel.text('Nombre del Campus')
                                    SurveyTopic.attr('placeholder', 'Introduce el nombre del campus');
                                    break;

                    case 'Facultad':    SurveyTopicLabel.text('Nombre de la Facultad')
                                        SurveyTopic.attr('placeholder', 'Introduce el nombre de la facultad');
                                        break;

                    case 'Programa Académico':  SurveyTopicLabel.text('Nombre del Programa Academico')
                                                SurveyTopic.attr('placeholder', 'Introduce el nombre del programa académico');
                                                break;
                }
            }
        })

        AddQuestion.on('click', function (e) {
            e.stopPropagation();
            questionController.createQuestion();
            $('#QuestionCarousel').carousel('next');

        })

        CleanQuestions.on('click', function (e) {
            e.stopPropagation();

        })

        QuestionCarousel.on('slid.bs.carousel', function (e) {
            e.stopPropagation();
            previewController.updatePreview();
        })

        AddSurvey.on('click', function (e) { //guardar en base de datos
            e.stopPropagation();
            $(this).children('span').removeClass('d-none')
            let surveyName = $('#SurveyName').val(); //obtener el nombre de la encuesta

            let university = "NULL";
            let campus = "NULL";
            let faculty = "NULL";
            let program = "NULL";

            let SurveyTopic = $('#SurveyTopic').val(); //obtener el alcance

            $('#SurveyName').removeClass('alert alert-success is-valid');
            $('#SurveyTopic').removeClass('alert alert-success is-valid');
            $('#SurveyName').removeClass('alert alert-danger is-invalid');
            $('#SurveyTopic').removeClass('alert alert-danger is-invalid');

            switch ($('#SurveyScope').text())
            {
                case 'Universidad': university = SurveyTopic;
                                    break;

                case 'Campus':      campus = SurveyTopic;
                                    break;

                case 'Facultad':    faculty = SurveyTopic;
                                    break;

                case 'Programa Académico': program = SurveyTopic;
                                            break;

            }

            $.ajax({
                url:    '../php/createSurvey.php',
                data:   {surveyName, campus, faculty, program, university},
                type: 'POST',
                success: function (response) {
                    console.log(response)
                    if(parseInt(response, 10) > 0){
                        //encuesta insertada con exito
                        sessionStorage.setItem('surveyId', response);//guardar llave primaria de la encuesta
                        $('#QuestionContainerController,#QuestionContainerPreview').show(SHOW_DELAY);//mostrar las herramientas
                        toast.toast('show');
                        $('#AddSurvey').children('span').addClass('d-none')

                        $('#SurveyName').addClass('alert alert-success is-valid');
                        $('#SurveyTopic').addClass('alert alert-success is-valid');

                        ShowSuccessToastSound.play().then(r => function () { });

                    }
                    else
                    {
                        ShowFaildedSound.play();
                        $('#AddSurvey').children('span').addClass('d-none')

                        switch (parseInt(response, 10)){
                            case -1:    $('#SurveyName').addClass('alert alert-danger is-invalid');
                                        break;
                            case -2:     $('#SurveyTopic').addClass('alert alert-danger is-invalid');
                                        break;
                        }

                    }
                }
            })
        })

        SaveToDatabase.on('click', function (e) {

            e.stopPropagation();
            let progressBar = $(`#ProgressBarDatabase`);
            let currentProgress = 0;

            //insertar pregunta
            let questionsTittles = questionController.getAllQuestionTittles() //obtener todos los titulos
            let questionThemes = questionController.getAllQuestionTopics();//obtener todos los temas
            let questionTypes = questionController.getAllQuestionsType();//obtener todos los tipos
            let questionAnswers = questionController.getAllAnswersByQuestion(); //obtener todos los grupos de respuestas
            let ProgressBarIncrement = 100 / (questionController.getNumOfQuestions() + questionController.getAllAnswerCount());
            let ModalDatabaseSuccess = $('#ModalDatabaseSuccess');

            let surveyId = sessionStorage.getItem('surveyId'); //obtener la llave primaria de la encuesta creada


            for(let i = 0; i < questionController.getNumOfQuestions(); i++){

                let title = questionsTittles[i];
                let theme = questionThemes[i];
                let type = questionTypes[i];

                if(validateAllFields()){
                    $.ajax({ //insertar pregunta en la base de datos
                        url:    '../php/createQuestion.php',
                        async:  false,
                        data:   {surveyId, title, theme, type},
                        type:   'POST',
                        error:  function (xhr, status, error) { // en caso de error
                            alert(error)
                        },
                        success:    function (response) {
                            console.log(`Pregunta creada #ID = ${response}`);
                            let questionId = response;
                            currentProgress += ProgressBarIncrement;
                            progressBar.css('width',`${currentProgress}%`);
                            progressBar.text(parseInt(currentProgress));

                            for(let j = 0; j < questionAnswers[i].length; j++){
                                let answerText = questionAnswers[i][j];
                                $.ajax({ //instertar respuestas
                                    url:    '../php/createAnswer.php',
                                    async: false,
                                    data:   {questionId, answerText},
                                    type:   'POST',
                                    success: function (response) {
                                        console.log(currentProgress)
                                        currentProgress += ProgressBarIncrement;
                                        progressBar.css('width',`${currentProgress}%`);
                                        progressBar.text(parseInt(currentProgress));
                                        console.log('respuesta creada = ' + response)
                                    },
                                    error:  function (xhr, status, error){
                                        alert(error)
                                        break;
                                    }
                                })
                            }
                        }
                    });

                    $(this).attr('disabled', true);
                    ModalDatabaseSuccess.modal('show');
                }else{
                    alert("Favor de verificar las preguntas y respuestas")
                }

            }
        })
        $(document).click(function (e) {
            $('.dropdown-menu').hide(SHOW_DELAY);
        })


    } //agregar listeners para elementos UNICOS
    function validateAllFields(){ //funcion para validar todas las preguntas y respuestas, tambien los campos
        let fields = $('.QuestionTopic,.QuestionTitle,.Answer'); //todos los campos de tema
        let status = true;

        cleanValidates()//limpiar campos

        //validar los topic fields
        fields.each(function (){
            if($(this).val() === ""){
                $(this).addClass("alert alert-danger is-invalid");
                status = false;
            }
            else{
                $(this).addClass("alert alert-success is-valid");
            }
        })



        return status
    }

    function cleanValidates() {
        let fields = $('.QuestionTopic,.QuestionTitle,.Answer'); //todos los campos de tema
        fields.removeClass('alert alert-danger alert-success is-valid is-invalid');
    }

    addListeners();
    questionController.createQuestion();

})