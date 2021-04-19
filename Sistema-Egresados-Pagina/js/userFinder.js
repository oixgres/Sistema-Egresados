$(document).ready(function (e) {
    const filters = $('.custom-checkbox');
    const AdvanceSearch = $('#AdvanceSearch');
    const FiltersContainer =  $('#FiltersContainer');
    const OffCanvas = new bootstrap.Offcanvas($('#UserProfile')[0]);

    filters.parent().siblings().attr('disabled', true); //deshabilitar por default los filtros
    $('[data-toggle="tooltip"]').tooltip() //habilitar los tooltips

    filters.on('click', function (e) {
        $(this).parent().siblings().attr('disabled', !$(this).prop('checked'))
    })

    $('.showOffCanvas').on('click', function (e) {
        e.stopPropagation();
        OffCanvas.toggle();
    })

    FiltersContainer.hide();
    FiltersContainer.removeClass('d-none');
    
    AdvanceSearch.on('click', function (e) {
        const hideAdvanceSearch = 'Ocultar búsqueda avanzada';
        const showAdvanceSearch = 'Búsqueda avanzada'
        const FilterContainer = $('#FiltersContainer');

        if($(this).text() === hideAdvanceSearch){
            $(this).text(showAdvanceSearch)
        }else{

            $(this).text(hideAdvanceSearch)
        }
        FilterContainer.toggle(700);
    })
})