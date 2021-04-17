class QuestionCreator{
    constructor(parent) {
        this.question_id = 0;
        this.answer_id = 0;
        this.parent = parent;
        
        
        /*
        <div class="col-12">
                <h3>Pregunta #1</h3>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" id="customRadio_${this.num_id}" name='checkbox' class="custom-control-input">
                    <label class="custom-control-label" for="customRadio_${this.num_id}">Respuesta 1</label>
                </div>
            </div>
         */
        this.createCheckBoxQuestion = function (title, answers = []) {
            let parentNode = $(`<div class="col-12"></div>`); //create parent node
            let titleNode = $(`<h3 class="Question_title">${title}</h3>`);// create title node
            parentNode.append(titleNode); //append title node to the parentNode
            for(let i = 0; i < answers.length; i++){
                //create a answer node
                let answerNode = $(` 
                    <div class="custom-control custom-checkbox">
                    <input type="checkbox" id="customRadio_${this.answer_id}" class="custom-control-input Answer">
                    <label class="custom-control-label" for="customRadio_${this.answer_id}">${answers[i]}</label>
                </div>
                `)

                parentNode.append(answerNode); //append answer to the question
                this.answer_id++; //increment answer id
                this.parent.append(parentNode); //append the question to the container
            }
        }

        this.createInputQuestion = function (title, answers) {
            let parentNode = $(`<div class="col-12"></div>`); //create parent node
            let titleNode = $(`<h3 class="Question_title">${title}</h3>`);// create title node
            parentNode.append(titleNode); //append title node to the parentNode
            for(let i = 0; i < answers.length; i++){
                //create a answer node
                let answerNode = $(`
                    <div class="form-group">
                        <input type="text" class="form-control Answer" placeholder="${answers[i]}">
                    </div>
                `)
                parentNode.append(answerNode); //append answer to the question
                this.answer_id++; //increment answer id
                this.parent.append(parentNode); //append the question to the container
            }
        }
        
        this.createTextareaQuestion = function (title, answers) {
            let parentNode = $(`<div class="col-12"></div>`); //create parent node
            let titleNode = $(`<h3 class="Question_title">${title}</h3>`);// create title node
            parentNode.append(titleNode); //append title node to the parentNode
            for(let i = 0; i < answers.length; i++){
                //create a answer node
                let answerNode = $(`
                    <div class="form-group">
                        <textarea type="text" class="form-control Answer" placeholder="${answers[i]}"></textarea>
                    </div>
                `)
                parentNode.append(answerNode); //append answer to the question
                this.answer_id++; //increment answer id
                this.parent.append(parentNode); //append the question to the container
            }
        }

        this.createRadioAnswer = function (title, answers) {
            let parentNode = $(`<div class="col-12"></div>`); //create parent node
            let titleNode = $(`<h3 class="Question_title">${title}</h3>`);// create title node
            parentNode.append(titleNode); //append title node to the parentNode
            for(let i = 0; i < answers.length; i++){
                //create a answer node
                let answerNode = $(`
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio_${this.answer_id}" name="radio_${this.question_id}" class="custom-control-input">
                        <label class="custom-control-label" for="customRadio_${this.answer_id}">${answers[i]}</label>
                    </div>
                `)
                parentNode.append(answerNode); //append answer to the question
                this.answer_id++; //increment answer id
                this.parent.append(parentNode); //append the question to the container
            }
            this.question_id++;
        }
    }
}

$(document).ready(function (e) {
    let questionCreator = new QuestionCreator($('#QuestionsContainer'));

    questionCreator.createCheckBoxQuestion('Pregunta 1',Array("R1", "R2", "R3"));
    questionCreator.createInputQuestion('Pregunta 2',Array("R1", "R2", "R3"));
    questionCreator.createTextareaQuestion('Pregunta 3',Array("R1", "R2", "R3"));
    questionCreator.createRadioAnswer('Pregunta 4',Array("R1", "R2", "R3"));





})