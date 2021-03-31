$(document).ready(function () {
    var Q1_inputs_radio = $('input[name = "Q1"]');
    var Q2_inputs_radio = $('input[name = "Q2"]');

    $('.container').hide(0, function (e) {
        $(this).fadeIn(500);
    });

    Q1_inputs_radio.click(function () {
        var id = $(this).attr("id")
        var custom_option = $('#Q1_custom_option');

        if(id === "Q1_OP4"){
            custom_option.show(300);
        }
        else{
            custom_option.hide(200);
        }

    });

    Q2_inputs_radio.click(function () {
        var id = $(this).attr("id")
        var custom_option = $('#Q2_custom_option');

        if(id === "Q2_OP4"){
            custom_option.show(300);
        }
        else{
            custom_option.hide(200);
        }
    })



    $('#Q1_custom_option').hide();
    $('#Q2_custom_option').hide();



})
