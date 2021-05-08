$(document).ready(function () {
    const WINDOW_HEIGHT = $(window).height();;

    let questionContainerForIsWorking = $('#questionContainerForIsWorking');

    $('.container').css({"height":`${WINDOW_HEIGHT}px`});

    $("#isWorkingYes,#isWorkingNo").on('click', function (e) {
        e.stopPropagation()
        if($(this).attr('id') === "isWorkingYes"){
            questionContainerForIsWorking.hide();
            questionContainerForIsWorking.removeClass('d-none');
            questionContainerForIsWorking.show(600);
        }
        else{
            questionContainerForIsWorking.hide(600);
        }
    })


    if($("#isWorkingYes").prop('checked'))
    {
        questionContainerForIsWorking.hide();
        questionContainerForIsWorking.removeClass('d-none');
        questionContainerForIsWorking.show(600);
    }


})