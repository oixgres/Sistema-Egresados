$(document).ready(function (e) {

    const SHOW_DELAY = 600;

    class QuestionControler{
        constructor(parent) {
            this.parent = parent;
            this.num_id = 0;

            this.createQuestion = function () {
                let item_active;

                if(this.num_id === 0)
                    item_active = 'active'
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
                                            <label for="QuestionTittle">Titulo de la pregunta</label>
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
                                        
                                        <div class="col-12 mt-3"> <!--  Texto de respuesta -->
                                            <div class="form-group">
                                                <input type="text" class="form-control Answer" placeholder="Texto de la Respuesta">
                                            </div>
                                        </div>
                                        
                                    </div>


                                    <div class="col-6 mt-2">
                                        <button type="button" class="btn btn-warning btn-block rounded-pill" id="AddAnswer_${this.num_id}">Añadir Respuesta</button>
                                    </div>

                                    <div class="col-6 mt-2">
                                        <button type="button" class="btn btn-danger btn-block rounded-pill" id="DiscardAnswer_${this.num_id}">Descartar Respuestas</button>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- Estructura de una pregunta -->
                    </div>
                </div>`)

                node.find(`#QuestionType_${this.num_id}`).on('click', function (e) {
                    e.stopPropagation();
                    let dropdownMenu = $(this).siblings('.dropdown-menu');
                    dropdownMenu.toggle(SHOW_DELAY);
                })
                
                node.find(`.dropdown-item`).on('click', function (e) {
                    let button = $(this).parent().siblings();
                    button.text((this).text);
                })

                node.find(`#AddAnswer_${this.num_id}`).on('click', function (e) {
                    e.stopPropagation();

                    let node = $(`
                        <div class="col-12 mt-3"> <!--  Texto de respuesta -->
                            <div class="form-group">
                                <input type="text" class="form-control Answer" placeholder="Texto de la Respuesta">
                            </div>
                        </div>
                    `);
                    let id = $(this).attr('id');
                    let regex = new RegExp('[0-9]+')
                    let num_id = regex.exec(id);
                    node.hide();
                    $('#AnswersContainer_' + num_id).append(node);
                    node.show(SHOW_DELAY);
                })

                this.parent.append(node);
                this.num_id++;

                $('.carousel').carousel({
                    interval: false,
                });
            }
        }
    }
    let questionControler = new QuestionControler($('#QuestionContainer')); //crear un controlador para agregar preguntas

    function addListeners() {
        const main_container = $('.container');
        const SurveyScope = $('#SurveyScope');
        const dropdownItems = $('.dropdown-item');
        const AddQuestion = $('#AddQuestion');
        const CleanQuestions = $('#CleanQuestions');

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
            if(button.length){
                button.text((this).text)
                $(this).parent().hide(SHOW_DELAY)
            }
        })

        AddQuestion.on('click', function (e) {
            e.stopPropagation();
            questionControler.createQuestion();
            $('#QuestionCarousel').carousel('next');

        })

        CleanQuestions.on('click', function (e) {
            e.stopPropagation();

        })

        $(document).click(function (e) {
            $('.dropdown-menu').hide(SHOW_DELAY);
        })
    }

    addListeners();
    questionControler.createQuestion();

})