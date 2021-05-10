let mainSteper = {}

$(document).ready(function (){
    let stepper = new Stepper($('.bs-stepper')[0]) //stteper principal
    document.cookie ="id=1" //cookie temporal
    mainSteper["stepper"] = stepper;

})


