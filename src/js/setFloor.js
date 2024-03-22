(function($) {
    $('.floor_01').on('click', function(event) {
        setFloor(1);
    });
    $('.floor_02').on('click', function(event) {
        setFloor(2);
    });

    var fragmentoAtual = window.location.hash;
    
    if (fragmentoAtual === '#terreo') {
        setFloor(1);
    } else if (fragmentoAtual === '#andar') {
        setFloor(2);
    }

    function setFloor(number) {
        if (number === 1) {
            $('.map_floor_01').addClass('active-map-floor');
            $('.map_floor_02').removeClass('active-map-floor');
    
            $('.floor_01').addClass('active-floor-btn');
            $('.floor_02').removeClass('active-floor-btn');
        } else {
            $('.map_floor_02').addClass('active-map-floor');
            $('.map_floor_01').removeClass('active-map-floor');
    
            $('.floor_02').addClass('active-floor-btn');
            $('.floor_01').removeClass('active-floor-btn');
        }
    }
})(jQuery);