let answerCreator = null;
let answerPreviewCreator = null;

function createRadioButtonNode(parent, id, name, text, spawnTime = 500) {
    let node = $(`
        <div class="row">
            <div class="col-12 offset-1">
                 <div class="custom-control custom-radio mb-1">
                    <input type="radio" id="preview_${id}" name="${name}" class="custom-control-input">
                    <label class="custom-control-label" for="preview_${id}">${text}</label>
                </div>
            </div>
        </div>
    `);
    node.hide()
    parent.append(node);
    node.show(spawnTime);
}

function createTextAreaNode(parent, id, placeholder) {

}

function createInputNode(parent, id, placeholder) {
    let node = $(`
        <div class="row">
            <div class="col-11 offset-1">
                <div class="form-group">
                    <input type="text" id="input_" + ${id} placeholder="${placeholder}" class="form-control">
                </div>
            </div>
        </div>
    `)
    parent.append(node);
}

function createTitleNode(parent, text, spawnTime = 500){
    const node = $(`
        <h6 class="mt-2 mb-2">${text}</h6>
    `);

    node.hide()
    parent.append(node);
    node.show(spawnTime);
}

$(document).ready(function (e) {
    const SHOW_TIME = 600;

    answerCreator = new AnswerCreator($('#answers_container'));
    answerPreviewCreator = new AnswerPreviewCreator($('#answer_container_preview'));

    $('.container').hide(0, function (e) {
        $(this).show(SHOW_TIME);
        $(this).on('click', function (e) {
            $('.dropdown-menu').hide(SHOW_TIME);
        })
    })

    $('#add_answer').on('click', function (e) {
        e.stopPropagation();
        answerCreator.createAnswerField();
    })

    $('#clear_answers').on('click', function (e) {
        e.stopPropagation();
        answerCreator.clearAnswerField();

    })

    $('#addPreviewQuestion').on('click', function (e) {
        answerPreviewCreator.addQuestionPreview(answerCreator.num_id);
    })

    $('#discardQuestionPreview').on('click', function (e) {
        e.stopPropagation();
        answerPreviewCreator.clearPreview();
    })

    answerCreator.createAnswerField();
    answerCreator.createAnswerField();
    answerCreator.createAnswerField();

})

class AnswerCreator{

    constructor(parent) {
        this.num_id = 0;
        this.parent = parent;
        this.spawnTime = 500;

        this.createAnswerField = function () {
            let spawnTime = this.spawnTime;

            const node = $(`
            <div class="row" id="answer_row_${this.num_id}">
                <div class="col-8">
                    <div class="form-group">
                        <input type="text" placeholder="Respuesta" class="form-control" id="answer_option_text_${this.num_id}">
                    </div>
                </div>
    
                <div class="col-4">
                    <div class="form-group">
                        <div class="dropdown">
                            <button type="button" class="btn btn-outline-success btn-block dropdown-toggle" id="answer_option_button_${this.num_id}">Radio</button>
                            <div class="dropdown-menu" id="answer_option_dropdown_${this.num_id}">
                                <a class="dropdown-item">Radio</a>
                                <a class="dropdown-item">Input</a>
                                <a class="dropdown-item">Text Area</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`);

            node.hide();
            parent.append(node);
            node.show(this.spawnTime);

            node.find('#answer_option_button_' + this.num_id).on('click', function (e) {
                e.stopPropagation();
                $(this).siblings('.dropdown-menu').toggle(spawnTime);
            });

            node.find('.dropdown-item').on('click', function (e) {
                e.stopPropagation();
                $(this).parent().siblings('button').text((this).text);
                $(this).parent().toggle(spawnTime);
            })


            this.num_id++;
        }
        this.clearAnswerField = function () {
            this.answerNodes = [];
            parent.children().hide(this.spawnTime, function (){
                parent.empty();
            })

            this.num_id = 0;
        }
    }
}

class AnswerPreviewCreator{
    constructor(parent) {
        this.parent = parent;
        this.spawnTime = 500;

        this.addQuestionPreview = function (num_answers) {
            let answer_type;
            let question_title;
            let answer_text;

            question_title = $('#question_tittle').val();
            createTitleNode(this.parent, question_title);

            for (let i = 0; i < num_answers; i++) {
                answer_type = $('#answer_option_button_' + i).text();
                answer_text = $('#answer_option_text_' + i).val();

                switch (answer_type) {
                    case 'Radio' :
                        createRadioButtonNode(this.parent, i, 'preview', answer_text);
                        break;

                    case 'Input' :
                        createInputNode(this.parent, i, answer_text);
                        break;
                }
            }
        }

        this.clearPreview = function (e) {
            let spawnTime = this.spawnTime;

            parent.children().hide(spawnTime, function (e) {
                parent.empty();
            });

        }
    }
}

