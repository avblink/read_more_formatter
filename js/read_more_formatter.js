(function ($, Drupal) {
    Drupal.behaviors.read_more_formatter = {
        attach: function (context, settings) {

            $('.read-more-formatter .links .expand-link').once('read_more_formatter').on('click', function (e) {
                e.preventDefault();
                $(this).parents('.read-more-formatter').removeClass('collapsed').addClass('expanded');
            });

            $('.read-more-formatter .links .collapse-link').once('read_more_formatter').on('click', function (e) {
                e.preventDefault();
                $(this).parents('.read-more-formatter').removeClass('expanded').addClass('collapsed');
            });
        },
    };
})(jQuery, Drupal);