$(document).ready(function () {
    const HEIGHT = $(document).height();
    const WIDTH = $(document).width();


    $('.container').css({
        'height' : HEIGHT
    })

    $(window).resize(function () {
        let height = $(document).height();
        $('.container').css({
            'height' : height
        })

    })



})