<div id="page-top" class="index">
	<?php if ($page['navigation']): ?>
		<?php print render($page['navigation']); ?>
	<?php endif; ?>
    <!-- Header -->
	<?php if ($page['header']): ?>
		<?php print render($page['header']); ?>
	<?php endif; ?>
	
	<?php if ($messages): ?>
	<div id="messages"><div class="section clearfix">
		<?php print $messages; ?>
	</div></div> <!-- /.section, /#messages -->
	<?php endif; ?>
	
  <?php print render($page['content']); ?>
    
	<?php if ($page['footer']): ?>
		<?php print render($page['footer']); ?>
	<?php endif; ?>
</div>