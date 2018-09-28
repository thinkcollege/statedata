<div id="statedata"><h1>Charts</h1><?php print $content; ?> </div>
<?php
/**
 * @file
 * Default theme file for d3 visualizations.
 */
    // include('/usr/lib/php/drupal/7.x_sites/statedata.info/modules/d3/modules/d3_statepages/chart1.php');
 ?><?php print isset($somestuff) ? $somestuff : ''; ?>
<div <?php print $attributes ?> class="<?php print implode(' ', $classes_array); ?>"></div><?php print isset($somestuff_two) ? $somestuff_two : ''; print isset($forms) ? $forms : '';
