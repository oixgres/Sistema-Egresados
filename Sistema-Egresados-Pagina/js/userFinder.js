$(document).ready(function (e) {
    const filters = $('.custom-checkbox');
    const AdvanceSearch = $('#AdvanceSearch');
    const FiltersContainer =  $('#FiltersContainer');
    const UserProfile = new bootstrap.Offcanvas($('#UserProfile')[0]);
    const SendEmail = new bootstrap.Offcanvas($('#SendEmail')[0]);

    filters.parent().siblings().attr('disabled', true); //deshabilitar por default los filtros


    //habilitar los tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });


    filters.on('click', function (e) {
        $(this).parent().siblings().attr('disabled', !$(this).prop('checked'))
    })

    $('.showProfileBtn').on('click', function (e) {
        e.stopPropagation();
        UserProfile.toggle();
    })

    $('.sendEmailProfile').on('click', function (e) {
        e.stopPropagation();
        SendEmail.toggle();
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