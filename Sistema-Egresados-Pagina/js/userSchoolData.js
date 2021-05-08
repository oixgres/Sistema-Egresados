$(document).ready(function (e) {
    const WINDOW_HEIGHT = $(window).height(); //obtener el alto del dispositivo

    $('.main').css({'height': `${WINDOW_HEIGHT}px`}); //establecer el alto para el contenedor principal

    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });


})