<?php $__env->startPush('stylesheets'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('main_container'); ?>

	<!-- page content -->
	<div class="container-fluid">
		<?php echo $__env->yieldContent('main_content'); ?>
	</div>
	<!-- /page content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>