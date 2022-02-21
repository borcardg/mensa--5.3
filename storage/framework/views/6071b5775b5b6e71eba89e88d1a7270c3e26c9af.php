<?php $__env->startPush('stylesheets'); ?>
<link rel="stylesheet" href="<?php echo e(asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-head'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('main_content'); ?>

    <!-- Weekly menus -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="content">
                    <div class="row">
                        <?php echo BootForm::open()->action(Request::url())->post()->addClass('form-inline'); ?>   
                        <div class="col-md-3">


                            <div class="form-group" style="width:100%">

                                <label for="sites">Site</label>
                                <select id="sites" class="form-control bigger-control" style="width:100%">
                                    <?php foreach($sites as $siteselect): ?>
                                        <?php if( $siteselect->id == $site->id): ?>
                                            <option value="<?php echo e($siteselect->id); ?>" selected><?php echo e($siteselect->translate()->name); ?> </option>
                                        <?php else: ?>
                                            <option value="<?php echo e($siteselect->id); ?>"><?php echo e($siteselect->translate()->name); ?> </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" id="DateDemo" style="width:100%">
                                <label for="startDate">Date :</label>
                                <input id="selected-date" style="width:100%" name="startDate" class="date-picker form-control bigger-control" />
                            </div>
                        </div>
                        <?php echo BootForm::close(); ?>

                        <div class="col-md-6"> 
                            <label>&nbsp; </label>
                            <a target="_blank" href="<?php echo e(url('/')); ?>/generate-pdf/1" id="download-word" class="btn btn-block btn-primary"> Télécharger le menu</a>
                        </div>
                        <!-- <div class="col-md-1"> 
                           
                        <label>&nbsp; </label>                            
                        
                            <a class="btn btn-link btn-md btn-block modalButton btn-primary"  data-toggle="modal" data-item-type="sites" data-id="<?php echo e($site->id); ?>" data-action-type="edit" role="button">
                                <i class="ti-settings"></i>     
                            </a>

                        </div> -->
                    </div>   
                </div>                   
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="col-md-2"><?php echo e(trans('messages.monday')); ?></th>
                            <th class="col-md-2"><?php echo e(trans('messages.tuesday')); ?></th>
                            <th class="col-md-2"><?php echo e(trans('messages.wednesday')); ?></th>
                            <th class="col-md-2"><?php echo e(trans('messages.thursday')); ?></th>
                            <th class="col-md-2"><?php echo e(trans('messages.friday')); ?></th>
                            <th><?php echo e(trans('messages.saturday')); ?></th>
                            <th><?php echo e(trans('messages.sunday')); ?></th>
                        </tr>
                    </thead>
                
                    <tbody id="weekly-body">

                    <?php echo $__env->yieldContent('weekly-body'); ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- / Weekly menus-->

    <!-- /Content -->
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script> -->
<script src="<?php echo e(asset("bower_components/bootstrap/js/transition.js")); ?>"></script>
<script src="<?php echo e(asset("bower_components/bootstrap/js/collapse.js")); ?>"></script>
<script src="<?php echo e(asset("bower_components/moment/min/moment-with-locales.min.js")); ?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/i18n/jquery-ui-i18n.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />



<!-- <script src="<?php echo e(asset("bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js")); ?>"></script> -->
<!-- <script src="<?php echo e(asset("js/convenience.js")); ?>"></script>
<script src="<?php echo e(asset("js/mensa-modals.js")); ?>"></script> -->

<script type="text/javascript">

        $(document).ready(function(){
            moment.locale('fr', {
            week: { dow: 1 } // Monday is the first day of the week
            });


            var startDate;
            var endDate;
            var options = $.extend(
                {},                                  // empty object
                $.datepicker.regional["fr"],         // fr regional
                { dateFormat: "d M y",firstDay: 1 } // your custom options
            );

            $.datepicker.setDefaults(options);
            var date = "<?php echo e($from); ?>";
            var dt1   = parseInt(date.substring(0,2));
            var mon1  = parseInt(date.substring(3,5));
            var yr1   = parseInt(date.substring(6,10));
            var date1 = new Date(yr1, mon1-1, dt1);


            $('.date-picker').datepicker( {
                changeMonth: true,
                firstDay: 1,
                dateFormat: "d.m.yy",
                changeYear: true,
                showButtonPanel: false,
                onSelect: function(dateText, inst) {
                    var date = $(this).datepicker('getDate');
                        startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay()+1);
                        endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 7);
                        var dateFormat = inst.settings.dateFormat || $.datepicker._defaults.dateFormat;
                    $(this).val($.datepicker.formatDate( dateFormat, startDate, inst.settings ) + " - " + $.datepicker.formatDate( dateFormat, endDate, inst.settings ));
                    updatevView();
                }
            }).datepicker("setDate", date1);
            $('.ui-datepicker-current-day').click();

            $('#sites').on('change', function (e) {
                updatevView();
            });
            setModalListener();
        });



    function updatevView(){
        var selected_date = $('#selected-date').val();
        var site_id = $('#sites').find(":selected").val();
        var selected_date = selected_date.split(" - ")[0];
        $("#download-word").attr("href", "<?php echo e(url('/')); ?>/generate-pdf/"+site_id+"/"+selected_date);
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // get real data
        $.ajax({
            method: "POST",
            url: '<?php echo e(Request::url()); ?>',
            //contentType: 'application/json; charset=UTF-8',
            //dataType: 'json',
            data: {
                "sites": site_id,
                "selected_date": selected_date,
                "_token": $('input[name="_token"]').val()
            },
            // results on ERROR or SUCCESS
            error: function(xhr, status, error){
                $('#weekly-body').empty();
                var error_message = '\
                    <tr class="danger">\
                        <td colspan="7"><?php echo e(trans('messages.error')); ?></td>\
                    </tr>';
                $(error_message).appendTo($('#weekly-body'));
                console.log(error);
            },
            success: function(data) {
                // get table body and remove it
                $('#weekly-body').empty();
                $(data).appendTo($('#weekly-body'));
                setModalListener();
            }
        });
    }
</script>



<script type="text/javascript">
function setModalListener(){

    $('.modalButton').on('click', function(){
        var this_id = $(this).attr('data-id');
        var this_action = $(this).attr('data-action-type');
        var this_type = $(this).attr('data-item-type');
        var this_site = $(this).attr('data-site');
        var this_noon = $(this).attr('data-noon');
        var url = "<?php echo e(url('/')); ?>/"+this_type+"/form/"+this_action+"/"+this_id+"?noon="+this_noon;

        var nbDay = $(this).attr('data-day');
        var dt = $('.date-picker').datepicker('getDate');
        dt.setDate(dt.getDate() + parseInt(nbDay));
        

        $.get(url, function( data ) {
            $('#myModal').modal();
            $('#myModal').on('shown.bs.modal', function(){
                $('#myModal .load_modal').html(data);
                
                    var start = $("#date_start").val();
                    var end = $("#date_end").val();
                    console.log(this_site);
                    
                    if(!$("#site_id").val()){
                        console.log("empty");
                        $("#site_id").val(this_site);
                    }

                    if(this_type == "menu"){
                        if(!$("#period").val()){
                            $("#period").val(this_noon);
                        }
                    }
                    // var start = $("#date_start").val() ? $("#date_start").val() : '2018-12-12';
                    // var end = $("#date_end").val() ? $("#date_end").val() : '2018-12-11';
                    if(!start){
                        var formdt = $.datepicker.formatDate('yy-m-dd', dt);
                        start = formdt;
                        end = formdt;
                    }

                    $("#date_start").val(start);
                    $("#date_end").val(end);
                    
                    $("#daterange").val($.datepicker.formatDate('dd/m/yy', new Date(start)) + " - "+ $.datepicker.formatDate('dd/m/yy', new Date(end)));

                     $('#daterange').daterangepicker({
                        opens: 'top'
                        }, function(start, end, label) {
                            $("#date_start").val(start.format('YYYY-MM-DD'));
                            $("#date_end").val(end.format('YYYY-MM-DD'));
                            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                        });


                    
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

 <style>
.addButton{
    text-align:center;
}
.input-group-addon {
    background-color: #fff;
    border: 0px;
    border-radius: 4px;
    padding-left:0px;
}


.ui-datepicker-calendar tr:hover {
    background-color: #ccc;
}

.list-group{
    font-size:0.8em
}


.list-group-item.active{
    background-color: #f3f3f3;
    border-color: #ddd;
    color:#111;
}
.list-group-item.active:hover{
    background-color: #ddd;
    border-color: #ccc;
    color:#111;
}
.list-group-item.active .list-group-item-text, .list-group-item.active:focus .list-group-item-text, .list-group-item.active:hover .list-group-item-text{
    color:#555;
}

.list-group {
   margin-bottom: 0px;
}
.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    border: 1px solid #dcdcdc;
}
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('home', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>