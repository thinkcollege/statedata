
(function($) {

// From http://stackoverflow.com/questions/13933000/how-to-check-if-twitter-bootstrap-is-loaded
// Will be true if bootstrap is loaded, false otherwise
var bootstrap_enabled = (typeof $().modal == 'function');

/**
 * Behaviors.
 */
Drupal.behaviors.BootstrapFieldgroup = {
  attach: function (context, settings) {

    if (!bootstrap_enabled) {

      // Try to hack in a little error message for the user to know there's a
      // problem.
      var message = Drupal.t('You are using <strong>bootstrap_fieldgroup</strong> on a non-bootstrap theme. The JavaScript has been disabled, however <strong>you should remove the bootstrap field groups appearing on this page (or change the theme)</strong>.');

      // Any error messages?
      var $messages = $('.messages.error');
      if ($messages.length) {

        // Only one? Create a list.
        var $list = $messages.find('ul');
        if (!$list.length) {
          var $heading = $messages.find('h2');
          $heading.remove();
          var previousMessage = $messages.text();
          $messages.html($heading);
          $list = $('<ul>');
          $list.append('<li>' + previousMessage + '</li>');
          $messages.append($list);
        }

        // Append to the list.
        $list.append('<li>' + message + '</li>');
      }

      // If not, create a new messages area.
      else {
        $('#content').prepend(
          $('<div class="messages error"></div>')
            .append('<h2 class="element-invisible">Error message</h2>')
            .append(message)
        );
      }

      return;
    }

    var mutateForm = function($nav_type) {

      switch ($nav_type.val()) {
        case 'tabs':
          $('.bootstrap-fieldgroup-orientation option:odd').show();
          break;
        default:
          $orientation = $('.bootstrap-fieldgroup-orientation');
          if (1 == $orientation.val() % 2) {
            $orientation.val(0);
          }
          $('.bootstrap-fieldgroup-orientation option:odd').hide();
          break;
      }
    };

    $('.bootstrap-fieldgroup-nav-type', context).on('change', function() {
      mutateForm($(this));
    });

    mutateForm($('.bootstrap-fieldgroup-nav-type'));

    // Check location hash against hrefs.
    function checkHashes() {

      function checkShow(selector, fn) {

        $(selector).each(function() {
          if (window.location.hash === $(this).attr('href')) {
            fn($(this));
          }
        });
      }

      checkShow('.nav a', function ($element) {
        $element.tab('show');
      });
      checkShow('.panel-group a', function ($element) {
        $element.closest('.panel').find('.panel-collapse').collapse('show');
      });
    }
    checkHashes();
    $(window).on('hashchange', checkHashes);
  }
};

/**
 * Implements Drupal.FieldGroup.processHook().
 */
Drupal.FieldGroup = Drupal.FieldGroup || {};
Drupal.FieldGroup.Effects = Drupal.FieldGroup.Effects || {};
Drupal.FieldGroup.Effects.processBootstrap_Fieldgroup_Nav = {
  execute: function (context, settings, type) {
    if (!bootstrap_enabled) return;

    if (type == 'form') {

      // Add required fields mark to any element containing required fields
      $('ul.nav', context).once('fieldgroup-effects', function(i) {

        $('li', this).each(function() {

          if ($(this).is('.required-fields')) {

            var $link = $('a', this);
            var $group = $(this).closest('.bootstrap-nav-wrapper');
            var $pane = $('.tab-content', $group).find($link.attr('href'));
            if ($pane.find('.form-required').length > 0) {
              $link.append(' ').append($('.form-required').eq(0).clone());
            }
          }
        });
      });
    }
  }
};

})(jQuery);