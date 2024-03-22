(function($) {
    $('[id^="export_pdf"]').on('click', function(event) {
        var urlParams = new URLSearchParams(window.location.search);
        var roomValue = urlParams.get('room');

        var idNumero = this.id.match(/\d+/)[0];
    
        window.open("../src/includes/_pdf.php?type=" + idNumero + "&room=" + roomValue, "_blank");
    });
})(jQuery);