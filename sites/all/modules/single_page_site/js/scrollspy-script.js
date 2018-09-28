/**
 * On scroll, set active menu item.
 */

(function($) {
  Drupal.behaviors.Scrollspy = {
    attach: function(context, settings) {
      var lastScrollTop = 0;
      if ($('body').find('.single-page-wrapper').length) {
        $(window).scroll(function(event) {
          var st = $(this).scrollTop();
          var id = null;
          $('.single-page-wrapper').each(function(i) {
            var is_menu_item = $(this).attr('data-menu-item');
            if(is_menu_item === 'menu-item'){
                if (st > lastScrollTop) {
                  // Downscroll code.
                  if ($(this).offset().top - $(window).scrollTop() <= Drupal.settings.singlePage.distanceDown) {
                    id = $(this).attr('data-active-item');
                    $(Drupal.settings.singlePage.menuClass + ' li a').removeClass('active');
                    $(Drupal.settings.singlePage.menuClass + ' li a[data-active-item="' + id + '"]').addClass('active');
                  }
                } else {
                  // Upscroll code.
                  if ($(this).offset().top - $(window).scrollTop() <= Drupal.settings.singlePage.distanceUp) {
                    id = $(this).attr('data-active-item');
                    $(Drupal.settings.singlePage.menuClass + ' li a').removeClass('active');
                    $(Drupal.settings.singlePage.menuClass + ' li a[data-active-item="' + id + '"]').addClass('active');
                  }
                }
            }
          });
          lastScrollTop = st;
        });
      }
    }
  };
})(jQuery);
