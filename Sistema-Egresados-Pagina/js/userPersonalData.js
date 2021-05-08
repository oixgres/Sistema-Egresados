$(document).ready(function (e) {
    const WINDOW_HEIGHT = $(window).height();

    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    $('.main').css({"height" : `${WINDOW_HEIGHT}px`})

})