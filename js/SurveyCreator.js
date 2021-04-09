$(document).ready(function (e) {

    const SHOW_DELAY = 600;
    let questionControler = null;

    class QuestionControler{
        constructor(parent) {
            this.parent = parent;
            this.num_id = 0;

        }
    }


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

        })

        CleanQuestions.on('click', function (e) {
            e.stopPropagation();

        })

        $(document).click(function (e) {
            $('.dropdown-menu').hide(SHOW_DELAY);
        })
    }

    addListeners();
    questionControler = new QuestionControler($('#QuestionContainer')); //crear un controlador para agregar preguntas
})