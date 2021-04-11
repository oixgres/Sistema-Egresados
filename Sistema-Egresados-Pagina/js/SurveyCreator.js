$(document).ready(function (e) {

    const SHOW_DELAY = 600;

    class QuestionControler{
        constructor(parent, previewController) {
            this.parent = parent;
            this.num_id = 0;
            this.previewController = previewController;

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
                                            <input type="text" class="form-control" placeholder="Introduce el tema de la pregunta" id="QuestionTopic_${this.num_id}">
                                        </div>
                                    </div>
                                   
                                    <div class="col-12"> <!-- Titulo de la pregunta -->
                                        <div class="form-group">
                                            <label for="QuestionTittle_${this.num_id}">Titulo de la pregunta</label>
                                            <input type="text" class="form-control" placeholder="Introduce el título de la pregunta" id="QuestionTittle_${this.num_id}">
                                        </div>
                                    </div>
                                   

                                    <div class="col-12"> <!-- Tipo de respuestas -->
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-info btn-block dropdown-toggle rounded-pill" id="QuestionType_${this.num_id}">Tipo de respuestas</button>
                                            <div class="dropdown-menu col col-12" id="Answer_items_${this.num_id}">
                                                <a class="dropdown-item">Radio</a>
                                                <a class="dropdown-item">Input</a>
                                                <a class="dropdown-item">Text Area</a>
                                                <a class="dropdown-item">Checkbox</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12" id="AnswersContainer_${this.num_id}"> <!-- Componente padre de las respuestas -->
         
                                        
                                    </div>


                                    <div class="col-6 mt-2">
                                        <button type="button" class="btn btn-info btn-block rounded-pill" id="AddAnswer_${this.num_id}">Añadir Respuesta</button>
                                    </div>

                                    <div class="col-6 mt-2">
                                        <button type="button" class="btn btn-danger btn-block rounded-pill" id="DiscardAnswer_${this.num_id}">Descartar Respuestas</button>
                                    </div>
                                    
                                    <div class="col-12 mt-2">
                                        <button type="button" class="btn btn-warning btn-block rounded-pill" id=DeleteQuestion_${this.num_id}>Eliminar Pregunta</button>
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


                node.find(`#AddAnswer_${this.num_id}`).on('click', function (e) { //listener para agregar una respuesta a la pregunta
                    e.stopPropagation();

                    let node = $(`
                        <div class="col-12">
                            <div class="input-group">
                                <input type="text" class="form-control Answer" placeholder="Texto de la Respuesta">
                                 <span class="input-group-btn">
                                    <button class="btn btn-secondary" type="button"><img class="img-fluid" src="../img/Icons/eliminar-simbolo.png" alt="Eliminar"/></button>
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
            this.getAnswersText = function (num_id) {
                let answersInputs = $(`#AnswersContainer_${num_id} .Answer`);
                let answersArray = [];

                for(let i = 0; i < answersInputs.length; i++){
                    answersArray.push(answersInputs[i].value);
                }

                return answersArray;
            }

        }
    }

    class PreviewController{
        constructor(QuestionParent, AnswerParent) {
            this.QuestionParent = QuestionParent;
            this.AnswerParent = AnswerParent;
            this.num_id = 0;

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

        main_container.hide(0, function (e) {
            $(this).show(SHOW_DELAY);
        });

        SurveyScope.on('click', function (e) {
            e.stopPropagation();
            const dropdownMenu = $(this).siblings('.dropdown-menu');
            if(dropdownMenu.length)
                dropdownMenu.toggle(SHOW_DELAY);

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

        $(document).click(function (e) {
            $('.dropdown-menu').hide(SHOW_DELAY);
        })


    } //agregar listeners para elementos UNICOS



    addListeners();
    questionController.createQuestion();

})