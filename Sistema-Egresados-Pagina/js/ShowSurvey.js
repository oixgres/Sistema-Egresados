class QuestionCreator{


    constructor(parent) {
        this.question_id = 0;
        this.answer_id = 0;
        this.parent = parent;
        

        this.createCheckBoxQuestion = function (title, answers = [], id = 0) {
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
        this.createInputQuestion = function (title, answers, id = 0) {
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
        this.createTextareaQuestion = function (title, answers, id = 0) {
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
        this.createRadioAnswer = function (title, answers, id = 0) {
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
}

$(document).ready(function (e) {
    //cookie de prueba del php
    const id = "id";
    document.cookie = "id=1"
    ///

    const idUsuario = getCookie(id);
    let questionCreator = new QuestionCreator($('#QuestionsContainer'));

    $.ajax({
        url: '../php/getToken.php',
        async: false,
        data:   {idUsuario},
        type:   'POST',
        success: function (response) {
            console.log(response)
        }
    })

})