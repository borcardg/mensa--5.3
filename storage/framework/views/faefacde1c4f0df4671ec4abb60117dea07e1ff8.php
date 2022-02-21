<?php $__env->startPush('script-head'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('main_content'); ?>

    <!-- Content -->

    <!-- will be used to show any messages -->
    <?php if(session('message')): ?>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="alert alert-success alert-dismissible" role="alert"><?php echo e(session('message')); ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            </div>
        </div>
    <?php endif; ?>




    <div class="row">
        <div class="col-md-12">
            <h3>Libellés</h3>
        </div>
        <div class="col-md-4">



            <div class="card">
                <div class="header">
                    <h4 class="title">Midi</h4>
                </div>
                <div class="content">
                    <ul class="list-unstyled team-members">
                        <?php foreach($labelsNoon as $key => $value): ?>
                        <li>
                            <div class="row">
                                <div class="col-xs-8">
                                    <?php echo e($value->translate()->name); ?> 
                                    <?php if($value->description): ?>
                                        <br>
                                        <small><?php echo e($value->description); ?></small>
                                    <?php endif; ?>
                                    <br>
                                    <span class="text-muted"><small><?php echo e($value->price); ?>.- CHF</small></span>
                                </div>
                                <div class="col-xs-4 text-right">
                                    <a class="addButton modalButton btn btn-sm btn-primary btn-icon"  data-toggle="modal"  data-item-type="label" data-id="<?php echo e($value->id); ?>" data-action-type="edit"><i class="fa fa-pencil"></i></a>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="header">
                    <h4 class="title">Soir</h4>
                </div>
                <div class="content">
                    <ul class="list-unstyled team-members">
                        <?php foreach($labelsEvening as $key => $value): ?>
                        <li>
                            <div class="row">
                            <div class="col-xs-8">
                                    <?php echo e($value->translate()->name); ?> 
                                    <?php if($value->description): ?>
                                        <br>
                                        <small><?php echo e($value->description); ?></small>
                                    <?php endif; ?>
                                    <br>
                                    <span class="text-muted"><small><?php echo e($value->price); ?>.- CHF</small></span>
                                </div>
                                <div class="col-xs-4 text-right">
                                    <a class="addButton modalButton btn btn-sm btn-primary btn-icon"  data-toggle="modal"  data-item-type="label" data-id="<?php echo e($value->id); ?>" data-action-type="edit"><i class="fa fa-pencil"></i></a>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; ?>

                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <a class="addButton modalButton btn btn-primary btn-block" data-toggle="modal"  data-item-type="label" data-id="0" data-action-type="create"> 
                <i class="ti ti-plus"></i>Ajouter un libellé
            </a>
        </div>


         
    </div>


    <!-- /Content -->
<?php $__env->stopSection(); ?>





<?php $__env->startPush('scripts'); ?>

<script type="text/javascript">
    $(document).ready(function(){
            setModalListener();

    });
</script>

<script type="text/javascript">
function setModalListener(){
$('.modalButton').on('click', function(){
    var this_id = $(this).attr('data-id');
    var this_action = $(this).attr('data-action-type');
    var this_type = $(this).attr('data-item-type');

        var url = "<?php echo e(url('/')); ?>/"+this_type+"/form/"+this_action+"/"+this_id;
        $.get(url, function( data ) {
            $('#myModal').modal();
            $('#myModal').on('shown.bs.modal', function(){
                $('#myModal .load_modal').html(data);
                $('.deleteButton').on('click', function(){
                    var url = "<?php echo e(url('/')); ?>/"+this_type+"/form/remove/"+this_id;
                    $.get(url, function( data ) {
                        $('#myModal .load_modal').html(data);
                    });
                });
            });
            $('#myModal').on('hidden.bs.modal', function(){
                $('#myModal .modal-body').data('');
            });

        });
    });

}
</script>


<?php $__env->stopPush(); ?>
<?php echo $__env->make('home', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>