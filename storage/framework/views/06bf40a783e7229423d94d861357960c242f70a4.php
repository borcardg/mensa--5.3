<!doctype html>
<html>
<head><?php echo $__env->make('includes.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  <?php echo $__env->yieldContent('stylesheets'); ?>
</head>
<body>
        
    <div class="wrapper">
        <div class="sidebar"  data-background-color="brown" data-active-color="info"><?php echo $__env->make('includes.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></div>
            <div class="main-panel">


            <?php echo $__env->make('includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="content">
                 <?php echo $__env->yieldContent('main_container'); ?>
            </div>

            <footer class="footer">
              <?php echo $__env->make('includes.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </footer>
        </div>

    </div>
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content load_modal">
                      
            </div>
        </div>
    </div>
</body>


 <!--   Core JS Files   -->
 <script src="<?php echo e(asset('js/jquery.min.js')); ?>" type="text/javascript"></script>
  <script src="<?php echo e(asset('js/jquery-ui.js')); ?>"></script>
	<script src="<?php echo e(asset('js/bootstrap.min.js')); ?>" type="text/javascript"></script>

	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="<?php echo e(asset('js/bootstrap-checkbox-radio.js')); ?>"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>


	<!--  Charts Plugin -->
	  <script src="<?php echo e(asset('js/chartist.min.js')); ?>"></script>

    <!--  Notifications Plugin    -->
    <script src="<?php echo e(asset('js/bootstrap-notify.js')); ?>"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
	<script src="<?php echo e(asset('js/paper-dashboard.js')); ?>"></script>



  <?php echo $__env->yieldContent('scripts'); ?>


<script>
        
      <?php if(session('msg')): ?>
          $.notify({
              icon: 'ti-check',
              message: "<?php echo e(session('msg')); ?>"

          },{
              type: 'info',
              timer: 4000
          });
      <?php endif; ?>

</script>
</html>
