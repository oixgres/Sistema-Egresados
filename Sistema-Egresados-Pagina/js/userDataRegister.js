$(document).ready(function (e) {
    let stepper = new Stepper($('.bs-stepper')[0])

    $('#button').on('click', function (e) {

        stepper.next();
    })
})