(function($) {

    $(document).on('click', 'tr[id^="item_"]', function(event) {
        var idElementoClicado = $(this).attr('id');
        var numeroItem = idElementoClicado.replace('item_', '');
        var currentUrl = window.location.href;

        var urlObj = new URL(currentUrl);

        var roomID = urlObj.searchParams.get('room');

        if (currentUrl.includes('&item=')) {
            var newUrl = currentUrl.replace(/&item=[^&]*/, '&item=' + numeroItem);
        } else {
            var newUrl = currentUrl + '&item=' + numeroItem;
        }

        $.ajax({
            type: 'GET',
            url: '../../src/structures/item_viewer.php',
            data: { item: numeroItem, room: roomID, tab: 1, by: 0 },
            success: function(response) {
                let modalView = $('[id^="modal_"]:not(#modal_add)');
                
                if (modalView) {
                    modalView.remove();
                }

                $('#modal_add').before(response);

                scriptReloader()

                history.replaceState(null, null, newUrl);
            }
        });
    });

    $(document).on('click', '[id^="type_tab_"]', function(event) {
        var idElementoClicado = $(this).attr('id');
        var numeroTab = idElementoClicado.replace('type_tab_', '');
        var currentUrl = window.location.href;

        var urlObj = new URL(currentUrl);

        var roomID = urlObj.searchParams.get('room');
        var itemID = urlObj.searchParams.get('item');

        if (currentUrl.includes('&tab=')) {
            var newUrl = currentUrl.replace(/&tab=[^&]*/, '&tab=' + numeroTab);
        } else {
            var newUrl = currentUrl + '&tab=' + numeroTab;
        }

        if (numeroTab == 1) {
            return window.location.href = currentUrl.split('&tab=')[0];
        }

        if (numeroTab == 2) var loca = ["item_edit", "modal_edit"];
        else var loca = ["item_remove", "modal_delete"];

        $.ajax({
            type: 'GET',
            url: `../../src/structures/${loca[0]}.php`,
            data: { item: itemID, room: roomID, tab: numeroTab, by: 0 },
            success: function(response) {
                let modalView = $('[id^="modal_"]:not(#modal_add)');

                modalView.html(response);

                modalView.attr('id', loca[1]);

                scriptReloader()

                history.replaceState(null, null, newUrl);
            }
        });

        history.replaceState(null, null, newUrl);
    })


    function scriptReloader() {
        let modalScriptReload = document.createElement('script')
        modalScriptReload.src = '../../src/js/modal.js';
        let modalScript = document.querySelector('script[src="../../src/js/modal.js"]');
        modalScript.before(modalScriptReload)
        modalScript.remove();

        let fileImportScriptReload = document.createElement('script')
        fileImportScriptReload.src = '../../src/js/fileImport.js';
        let fileImportScript = document.querySelector('script[src="../../src/js/fileImport.js"]');
        fileImportScript.before(fileImportScriptReload)
        fileImportScript.remove();
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