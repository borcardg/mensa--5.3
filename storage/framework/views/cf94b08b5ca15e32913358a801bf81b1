<div class="sidebar-wrapper">
    <div class="logo">
        <a class="simple-text">
        <img src="<?php echo e(asset('img/logo.png')); ?>" width="100%" />
        </a>
    </div>
    <ul class="nav">
    
       
        <li <?php echo e(Request::is('home') ? 'class=active' : ''); ?>>
            <a href="<?php echo e(url('home')); ?>">
                <i class="ti-home"></i>
                <p><?php echo e(trans('messages.dashboard')); ?></p>
            </a>
        </li>
        <li <?php echo e(Request::is('sites/*') ? 'class=active' : ''); ?>>
            <a href="<?php echo e(URL::to('sites/1/'.date('d.m.Y'))); ?>">
                <i class="ti-calendar"></i>
                <p><?php echo e(trans('messages.sites-weekly')); ?></p>
            </a>
        </li>
        <li <?php echo e(Request::is('labels') ? 'class=active' : ''); ?>>
            <a href="<?php echo e(URL::to('labels')); ?>">
                <i class="ti-tag"></i>
                <p><?php echo e(trans('messages.labels')); ?></p>
            </a>
        </li>
    </ul>
</div>

