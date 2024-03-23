(function($) {
    var eventsHandler;
    eventsHandler = {
        haltEventListeners: ['touchstart', 'touchend', 'touchmove', 'touchleave', 'touchcancel'], init: function(options) {
            var instance = options.instance, initialScale = 1, pannedX = 0, pannedY = 0

            this.hammer = Hammer(options.svgElement, {
            inputClass: Hammer.SUPPORT_POINTER_EVENTS ? Hammer.PointerEventInput : Hammer.TouchInput
            })

            this.hammer.get('pinch').set({enable: true})

            this.hammer.on('doubletap', function(ev){
            instance.zoomIn()
            })

            this.hammer.on('panstart panmove', function(ev){
                if (ev.type === 'panstart') {
                    pannedX = 0
                    pannedY = 0
                }

                instance.panBy({x: ev.deltaX - pannedX, y: ev.deltaY - pannedY})
                pannedX = ev.deltaX
                pannedY = ev.deltaY
            })

            this.hammer.on('pinchstart pinchmove', function(ev){
                if (ev.type === 'pinchstart') {
                    initialScale = instance.getZoom()
                    instance.zoomAtPoint(initialScale * ev.scale, {x: ev.center.x, y: ev.center.y})
                }

                instance.zoomAtPoint(initialScale * ev.scale, {x: ev.center.x, y: ev.center.y})
            })

            options.svgElement.addEventListener('touchmove', function(e){ e.preventDefault(); });
        }, destroy: function(){
            this.hammer.destroy()
        }
    }
    var beforePan

    beforePan = function(oldPan, newPan){
        var stopHorizontal = false, 
        stopVertical = false,
        gutterWidth = 700,
        gutterHeight = 300,
        sizes = this.getSizes(),
        leftLimit = -((sizes.viewBox.x + sizes.viewBox.width) * sizes.realZoom) + gutterWidth,
        rightLimit = sizes.width - gutterWidth - (sizes.viewBox.x * sizes.realZoom),
        topLimit = -((sizes.viewBox.y + sizes.viewBox.height) * sizes.realZoom) + gutterHeight,
        bottomLimit = sizes.height - gutterHeight - (sizes.viewBox.y * sizes.realZoom)

        customPan = {}
        customPan.x = Math.max(leftLimit, Math.min(rightLimit, newPan.x))
        customPan.y = Math.max(topLimit, Math.min(bottomLimit, newPan.y))

        return customPan
    }

    var added = false;

    function setViewerMap(mapCfg) {
        if (mapCfg == 1 ) {
            mapCfg = ["#svg_map_01", 281, 127, 3.5, '70rem', '100vw', 115, 50, 1.2]
        } else {
            mapCfg = ["#svg_map_02", 281, 127, 3.5, '70rem', '100vw', 115, 50, 1.2]
        }
        if (window.matchMedia("(orientation: portrait)").matches) {
            panZoomInstance = svgPanZoom(mapCfg[0], {
                zoomEnabled: true,
                controlIconsEnabled: false,
                fit: true,
                center: false,
                zoomScaleSensitivity: 0.5,
                contain: false,
                maxZoom: 10,
                minZoom: 0.8,
                refreshRate: 'auto',
                customEventsHandler: eventsHandler,
                beforePan: beforePan
            });

            panZoomInstance.resetZoom()
            panZoomInstance.resetPan()
    
            panZoomInstance.pan({x: mapCfg[1], y: mapCfg[2]});
            panZoomInstance.zoom(mapCfg[3]);
    
            var svgAtivo = document.querySelector('.active-map-floor svg');
    
            if (svgAtivo) {
                svgAtivo.setAttribute('height', mapCfg[4]);
                svgAtivo.setAttribute('width', mapCfg[5]);
            }
        } else {
            panZoomInstance = svgPanZoom(mapCfg[0], {
                zoomEnabled: true,
                controlIconsEnabled: false,
                fit: true,
                center: false,
                zoomScaleSensitivity: 0.5,
                contain: false,
                maxZoom: 10,
                minZoom: 0.8,
                refreshRate: 'auto',
                customEventsHandler: eventsHandler,
                beforePan: beforePan
            });

            panZoomInstance.resetZoom()
            panZoomInstance.resetPan()

            panZoomInstance.pan({x: mapCfg[6], y: mapCfg[7]});
            panZoomInstance.zoom(mapCfg[8]);

            
        }
    }

    setViewerMap(1);

    $('.floor_01').on('click', function(event) {
        setFloor(1);
        setViewerMap(1)
    });
    $('.floor_02').on('click', function(event) {
        setFloor(2);
        setViewerMap(2)
    });

    var fragmentoAtual = window.location.hash;
    
    if (fragmentoAtual === '#terreo') {
        setFloor(1);
        setViewerMap(1)
    } else if (fragmentoAtual === '#andar') {
        setFloor(2);
        setViewerMap(2)
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