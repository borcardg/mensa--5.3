<?php $__env->startSection('weekly-body'); ?>

            <?php if(count($menusAM) == 0): ?>
                <tr>
                    <td colspan="7">
                        <p class="text-center"><?php echo e(trans('messages.no_data')); ?></p>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td>
                        <strong><?php echo e(trans('messages.noon')); ?></strong> <br>
                        <!-- <?php echo e(ucfirst(trans('messages.from2'))); ?> 11:00 <?php echo e(trans('messages.to2')); ?> 13:30 -->
                    </td>
                    <?php $__currentLoopData = $menusAM; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <td class="<?php echo e($key); ?>">
                            <div class="list-group"> 
                                <?php if(!empty($value)): ?>
                                    <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                        <a  class="list-group-item modalButton"  data-toggle="modal" data-target="#modal-menu-create-edit" data-noon="1" data-item-type="menu" data-action-type="edit" data-id="<?php echo e($v->id); ?>" class="list-group-item"> 
                                            <p class="list-group-item-heading"><?php echo e($v->translate()->title); ?> <small><?php echo e($v->translate()->subtitle); ?></small></p> 
                                            <p class="list-group-item-text"><small><?php echo e($v->label->translate()->name); ?> (<?php echo e($v->label->price); ?> CHF)</small></p> 
                                        </a> 
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                <?php endif; ?>
                                <a  class="list-group-item addButton modalButton" data-toggle="modal" data-target="#modal-menu-create-edit" data-noon="1" data-item-type="menu" data-site="<?php echo e($site->id); ?>" data-day="<?php echo e($key); ?>" data-id="0" data-action-type="create"> 
                                
                                <i class="ti-plus"></i>    
                                </a> 
                            </div>
                        </td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                </tr>

            <?php endif; ?>

            <?php if(count($menusPM) == 0): ?>
                <tr>
                    <td colspan="7">
                        <p class="text-center"><?php echo e(trans('messages.no_data')); ?></p>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td><strong><?php echo e(trans('messages.evening')); ?></strong> <br>
                        <!-- <?php echo e(ucfirst(trans('messages.from2'))); ?> 17:30 <?php echo e(trans('messages.to2')); ?> 19:30 -->
                    </td>
                    
                    <?php $__currentLoopData = $menusPM; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <td class="<?php echo e($key); ?>">
                            <div class="list-group"> 
                                <?php if(!empty($value)): ?>
                                    <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                        <a  class="list-group-item modalButton"  data-toggle="modal" data-target="#modal-menu-create-edit" data-item-type="menu" data-action-type="edit" data-noon="0" data-id="<?php echo e($v->id); ?>" class="list-group-item"> 
                                            <p class="list-group-item-heading"><?php echo e($v->translate()->title); ?> <small><?php echo e($v->translate()->subtitle); ?></small></p> 
                                            <p class="list-group-item-text"><small><?php echo e($v->label->translate()->name); ?> (<?php echo e($v->label->price); ?> CHF)</small></p> 
                                        </a> 
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                <?php endif; ?>
                                <a  class="list-group-item addButton modalButton" data-toggle="modal" data-target="#modal-menu-create-edit" data-noon="0" data-item-type="menu" data-day="<?php echo e($key); ?>" data-id="0" data-site="<?php echo e($site->id); ?>" data-action-type="create"> 
                                    <i class="ti-plus"></i>    
                                </a> 
                            </div>
                        </td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                </tr>

            <?php endif; ?>

            <tr style="background-color: fbfbfb;">
            <td><?php echo e(trans('messages.notice')); ?></td>
                <?php $__currentLoopData = $notices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <td class="<?php echo e($key); ?>">
                            <div class="list-group"> 
                                <?php if(!empty($value)): ?>
                                    <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                        <a  class="list-group-item modalButton"   data-toggle="modal" data-item-type="notice" data-day="<?php echo e($key); ?>" data-action-type="edit" data-id="<?php echo e($v->id); ?>" class="list-group-item"> 
                                            <p class="list-group-item-heading"><?php echo e($v->translate()->title); ?></p> 
                                        </a> 
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                <?php endif; ?>
                                <a  class="list-group-item addButton modalButton" data-toggle="modal" data-item-type="notice" data-important="false" data-day="<?php echo e($key); ?>" data-id="0" data-site="<?php echo e($site->id); ?>" data-year="2018" data-action-type="create"> 
                                   <i class="ti-plus"></i>    
                                </a> 
                            </div>
                        </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            </tr>

    <?php $__env->stopSection(); ?>

<?php echo $__env->make('sites.weekly-menus', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>