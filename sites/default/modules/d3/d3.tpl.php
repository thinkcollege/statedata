<?php
/**
 * @file
 * Default theme file for d3 visualizations.
 */
    // include('/usr/lib/php/drupal/7.x_sites/statedata.info/modules/d3/modules/d3_statepages/chart1.php');
 ?><?php print isset($somestuff) ? $somestuff : ''; ?>
 <?php print isset($charttable) ? $formbutton : ''; ?>
 <?php print isset($chartlegend) ? $chartlegend : ''; ?>
<div <?php print $attributes ?> class="<?php print implode(' ', $classes_array); ?>"></div><?php print isset($somestuff_two) ? $somestuff_two : ''; print isset($forms) ? $forms : ''; ?>
<?php if (isset($somestuff)): ?><div id="stateDropdown"><h4>Go to another state overview</h4>
<?php 
$block = module_invoke('views', 'block_view', 'statepages_dropdown-block');
print render($block['content']); 
 ?></div><?php endif; if (isset($charttable)) print "$charttable<div>" . ($recentblock != '' ? $recentblock : '' ) . "</div><div id=\"formRedo\">$repeatform</div>"; ?>