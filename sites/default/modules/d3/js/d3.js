/**
 * @file
 * Javascript file that initiates the d3 and behaviors globals.
 */

/**
 * Integrates D3 library and functionality with D7 core javascript
 */
(function($) {
  Drupal.d3 = {

    draw : function(element, settings) {
      // type of chart
      var vType = settings.type;

      // invoke javascript library function
      Drupal.d3[vType](element, settings);
    },

  }
})(jQuery);

(function($) {
Drupal.behaviors.d3 = {
  attach: function(context, settings) {
    // check to see if there are visualizations that have been set
    if (settings.d3.inventory) {
      var vis = new Object;

      // for each of the visualizations set in inventory
      for (var visId in settings.d3.inventory) {
        // if the container for this visualization exists on the page
        if (jQuery('#' + visId, context).length) {
          Drupal.d3.draw(visId, settings.d3.inventory[visId]);
        }
      }
    }
  }
}
})(jQuery);

// initialize global object
Drupal.settings.d3 = (Drupal.settings.d3 | []);
