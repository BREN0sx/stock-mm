(function($) {
    $(document).ready(function() {
        setTimeout(function() {
        $('[id^="log_"]').on("click", function(event) {
            if (!$(event.target).is('a')) {
                $(this).find(".expand-history").toggleClass("open");
                $(this).closest("tr").next(".fold_history").toggleClass("open");
            }
        });
        }, 800)
    });
})(jQuery);