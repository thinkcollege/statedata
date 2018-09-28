jQuery.noConflict();
(function(jQuery) {
  Drupal.behaviors.merciCopyFieldValue = {
    attach: function (context, settings) {

      // Repeat this for all fields as needed
      jQuery('#edit-field-merci-date-und-0-value-datepicker-popup-0', context).on('blur', function(){ 
        // above you can use change instead of blur if element is not changed by another js
        if(!jQuery('#edit-field-merci-date-und-0-value2-datepicker-popup-0').val() || 0 === jQuery('#edit-field-merci-date-und-0-value2-datepicker-popup-0').val().length) {
          jQuery('#edit-field-merci-date-und-0-value2-datepicker-popup-0').val(jQuery(this).val());
          // wrap line above in "if no value" like I did, or other condition you like
        }
      });
      // end of "repeat this"

    }
  };
});