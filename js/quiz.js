$(document).ready(function () {
    radios = $('input[type="radio"]');

    radios.removeAttr("checked");

    $('.container').hide(0, function (e) {
        $(this).show(700);
    });

    $('#Q2_OP5').hide();
    $('#Q1_OP5').hide();
})


function hideCustomOption(input, show) {
    if(show){
        $(input).show(500);
    }
    else{
        $(input).hide(500);
    }
}