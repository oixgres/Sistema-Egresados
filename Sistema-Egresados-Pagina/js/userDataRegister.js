let mainSteper = {}

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
} //funcion para obtener un cookie

$(document).ready(function (){
    let stepper = new Stepper($('.bs-stepper')[0]) //stteper principal
    mainSteper["stepper"] = stepper;

    console.log(document.cookie)


    $('#avanzar').on('click', function (e) {
        e.stopPropagation();
        stepper.next();
    })
})


