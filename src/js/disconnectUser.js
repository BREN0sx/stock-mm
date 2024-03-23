(function($) {
    $('.logout-user').on('click', function(event) {
        $.ajax({
            url: '../../src/structures/user_disconnect.php',
            type: 'GET',
            success: function(response) {
                window.location.href = "../../views/auth/";
            }
        });
    });
})(jQuery);