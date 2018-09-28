/**
 * Smooth scrolling to anchor item.
 */

(function ($) {
  Drupal.behaviors.scrolltoanchors = {
    attach: function (context, settings) {
      // On page load, smooth scroll.
      var hash = window.location.hash;
      var heightDifference = $(document).height() - $(window).height();
      if(hash){
        scrollToDestination($(hash).offset().top, heightDifference);
      }

      // On click, smooth scroll this baby!
      $('a[href^="#"], a[href^="/#"]').click(function (event) {
        event.preventDefault();
        var hrefValue = $(this).attr('href').replace('/', '');
        var strippedHref = hrefValue.replace('#', '').replace('/', '');

        if (validateSelector(hrefValue)) {
          if ($(hrefValue).length > 0) {
            var linkOffset = $(this.hash).offset().top;
            scrollToDestination(linkOffset, heightDifference);
          }
          else if ($('a[name=' + strippedHref + ']').length > 0) {
            var linkOffset = $('a[name=' + strippedHref + ']').offset().top;
            scrollToDestination(linkOffset, heightDifference);
          }
        }
      });
    }
  };

  // Validates selector.
  function validateSelector(a) {
    return /^#[a-z]{1}[a-z0-9_-]*$/i.test(a);
  }

  // Scrolls to destination.
  function scrollToDestination(a, b) {
    if (a > b) {
      destination = b;
    } else {
      destination = a;
    }
    $('html,body').animate({scrollTop: destination}, 800, 'swing');
  }
}(jQuery));
