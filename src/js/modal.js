(function($) {
    /* VIEW */

    $('._modal_view_close').on('click', function(event) {
        let modal = document.getElementById('modal_view');
        modal.style.cssText = 'display: none;';

        history.replaceState(null, null, window.location.href.split('&item=')[0]);
    });

    /* ADD */
    $('._modal_add_open').on('click', function(event) {
        let modal = document.getElementById('modal_add');
        modal.style.cssText = 'display: flex;';

        displayInfo(0)
    });

    $('._modal_add_close').on('click', function(event) {
        let modal = document.getElementById('modal_add');
        modal.style.cssText = 'display: none;';

        displayInfo(1)
    });

    /* EDIT */

    $('._modal_edit_close').on('click', function(event) {
        let modal = document.getElementById('modal_edit');
        modal.style.cssText = 'display: none;';

        displayInfo(1)
        history.replaceState(null, null, window.location.href.split('&item=')[0]);
    });

    /* DEL */

    $('._modal_delete_close').on('click', function(event) {
        let modal = document.getElementById('modal_delete');
        modal.style.cssText = 'display: none;';

        history.replaceState(null, null, window.location.href.split('&item=')[0]);
    });

    let modalElements = document.querySelectorAll('[id*="modal_"][style*="display: flex"]');

    document.addEventListener("click", function (e) {
        modalElements.forEach(modalElement => {
            if (!e.target.closest('.add-section')) {
                modalElement.style.display = "none";

                displayInfo(1)
                history.replaceState(null, null, window.location.href.split('&item=')[0]);
            }
        });
    });


    function displayInfo(type) {
        let type1 = 'display: none;';
        if (type == 1) {
            type1 = 'display: block;';
            type = 'display: none;';
            if (document.getElementById("form-add")) document.getElementById("form-add").reset();
        } else {
            type = 'display: block;';
        }

        if (document.querySelector('.drop-zone__thumb')) document.querySelector('.drop-zone__thumb').style.cssText = type1;
        if (document.querySelector(".drop-zone__prompt")) document.querySelector(".drop-zone__prompt").style.cssText = type;
        if (document.querySelector(".drop-zone__prompt.support")) document.querySelector(".drop-zone__prompt.support").style.cssText = type;
        if (document.querySelector(".drop-zone__prompt.editor-viewer")) document.querySelector(".drop-zone__prompt.editor-viewer").style.cssText = type;
    }

})(jQuery);