const SHOW_DELAY = 600;

$(document).ready(function (e) {

    function addListeners() {
        const main_container = $('.container');
        const SurveyScope = $('#SurveyScope');
        const dropdownItems = $('.dropdown-item');
        const SurveyName = $('#SurveyName');

        //temp
        const QuestionType = $('#QuestionType');
        ////////

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

        SurveyName.on('keyup', function (e) {

        })


        $(document).click(function (e) {
            $('.dropdown-menu').hide(SHOW_DELAY);
        })

        ////temp//////////////
        QuestionType.on('click', function (e) {
            e.stopPropagation();
            const dropdownMenu = $(this).siblings('.dropdown-menu');
            if(dropdownMenu.length)
                dropdownMenu.toggle(SHOW_DELAY);
        })

        /////////////
    }



    if(sessionStorage.getItem('Nombre') == null){
        sessionStorage.setItem('Nombre', 'Omar')
    }
    else
    {
        console.log(sessionStorage.getItem('Nombre'))
    }

    addListeners();
})