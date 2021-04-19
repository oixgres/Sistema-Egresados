$(document).ready(function (e) {
    const filters = $('.custom-checkbox');

    filters.parent().siblings().attr('disabled', true); //deshabilitar por default los filtros
    $('[data-toggle="tooltip"]').tooltip() //habilitar los tooltips

    filters.on('click', function (e) {
        $(this).parent().siblings().attr('disabled', !$(this).prop('checked'))  //dependiendo el estado de los checkbox
    })
})