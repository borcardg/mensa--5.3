@extends('home')


@push('stylesheets')
<link rel="stylesheet" href="{{ asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}">
@endpush

@push('script-head')
<script src="{{ asset("bower_components/tinymce/tinymce.js") }}"></script>
<script src="{{ asset("js/convenience-head.js") }}"></script>
@endpush

@section('main_content')

    <!-- Content -->
    <div class="row">
        <!-- TODO: In notification instead -->
        @if (session('message'))
            <div class="card">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="alert alert-success alert-dismissible" role="alert">{{ session('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
            </div>
            </div>
        @endif
        <div class="col-md-12">
            <div class="card">
                <div class="page-header" data-site="{{ $site->id }}">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="siteSelect">Site </label>
                                <select id="siteSelect" class="form-control">
                                    <option>{{ $site->translate()->name }} </option>
                                    <option>A</option>
                                    <option>A</option>
                                    <option>A</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" id="DateDemo">
                                <label for="weeklyDatePicker">Semaine du </label>

                                <div class="form-group">
                                    <div class="input-group">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-chevron-left"></span></div>
                                    <input  type='text' class="form-control" id='weeklyDatePicker' placeholder="Select Week" />
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-chevron-right"></span></div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>        
                </div>
            </div>
        </div>  
    </div>
    <!-- will be used to show any messages -->
   


    <!-- Weekly menus -->
    
    <!-- <div class="row">
        <div class="col-md-8">
            <h2>{{ trans('messages.menus_of_the_week') }}
                {{ trans('messages.from') }}
                <span id="weekly-from" class="text-info">{{ $from }}</span>
                {{ trans('messages.to') }}
                <span id="weekly-to" class="text-info">{{ $to }}</span>
            </h2>
        </div>
        <div class="col-md-4">

            {!! BootForm::open()->action(Request::url())->post()->addClass('form-inline') !!}
            <div class="form-group">
                <div class="input-group dtpicker" id="dtp">
                    <input id="selected-date" name="selected-date" type="text" class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
            {!! BootForm::hidden('sites')->value($site->id)->id('site_id') !!}
            {!! BootForm::button(trans('messages.validate'), 'btn-sm btn-default')->id('change-date')->name('change-date') !!}
            {!! BootForm::close() !!}

        </div>
    </div> -->
    <div class="row">
    <style>

    .input-group-addon {
        background-color: #fff;
        border: 0px;
        border-radius: 4px;
        padding-left:0px;
    }

    .form-control{
        border:0px;
        -webkit-box-shadow: none!important;
        box-shadow: none!important;
        font-size:1.3em;
        padding:0px;
        width:auto;
    text-align: center;
    }

    .bootstrap-datetimepicker-widget .datepicker-days table tbody tr:hover {
        background-color: #eee;
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
    .addButton{
        background-color: transparent;
        font-size:0.8em;
        color:#666;
    }

    .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
        border: 1px solid #dcdcdc;
    }
    </style>
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th class="col-md-2">{{ trans('messages.monday') }}</th>
                    <th class="col-md-2">{{ trans('messages.tuesday') }}</th>
                    <th class="col-md-2">{{ trans('messages.wednesday') }}</th>
                    <th class="col-md-2">{{ trans('messages.thursday') }}</th>
                    <th class="col-md-2">{{ trans('messages.friday') }}</th>
                    <th>SA</th>
                    <th>DI</th>
                </tr>
            </thead>
            <tbody id="weekly-body">
                <!-- <tr style="background-color:#fffef6"> -->
                <tr>
                    <td><strong>Midi</strong><br>11:00-13:30</td>
                    <td>
                        <div class="list-group"> 
                            <a href=""  class="list-group-item"> 
                                <p class="list-group-item-heading">Panaché de poisson safrané aux petits légumes</p> 
                                <p class="list-group-item-text">
                                Menu 1 (CHF 8.-) 
                                </p> 
                            </a> 
                            <a href="#" class="list-group-item"> 
                                <p class="list-group-item-heading">Brochette de viande hachée</p> 
                                <p class="list-group-item-text">Menu 2 (CHF 9.-)</p> 
                            </a> 
                            <a  href="#" class="list-group-item addButton" style="text-align:center"> 
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a> 
                        </div>
                    </td>
                    <td>
                        <div class="list-group"> 
                            <a href="#" class="list-group-item"> 
                                <p class="list-group-item-heading">Epaule de veau (CH) à la sauge</p> 
                                <p class="list-group-item-text">Menu 2 (CHF 9.-)</p> 
                            </a> 
                            <a href="#" class="list-group-item addButton" style="text-align:center"> 
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a> 
                        </div>
                    </td>
                    <td>
                        <div class="list-group"> 
                            <a href="#" class="list-group-item addButton" style="text-align:center"> 
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a> 
                        </div>
                    </td>
                    <td>
                        <div class="list-group"> 
                            <a href="#" class="list-group-item"> 
                                <p class="list-group-item-heading">Epaule de veau (CH) à la sauge</p> 
                                <p class="list-group-item-text">Menu 2 (CHF 9.-)</p> 
                            </a> 
                            <a href="#" class="list-group-item addButton" style="text-align:center"> 
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a> 
                        </div>
                    </td>
                    <td>
                        <div class="list-group"> 
                            <a href=""  class="list-group-item"> 
                                <p class="list-group-item-heading">Panaché de poisson safrané aux petits légumes</p> 
                                <p class="list-group-item-text">
                                Menu 1 (CHF 8.-) 
                                </p> 
                            </a> 
                            <a href="#" class="list-group-item"> 
                                <p class="list-group-item-heading">Epaule de veau (CH) à la sauge</p> 
                                <p class="list-group-item-text">Menu 2 (CHF 9.-)</p> 
                            </a> 
                            <a href="#" class="list-group-item addButton" style="text-align:center"> 
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a> 
                        </div>
                    </td>
                    <td>
                        <div class="list-group"> 
                            <a href="#" class="list-group-item addButton" style="text-align:center"> 
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a> 
                        </div>
                    </td>
                    <td>
                        <div class="list-group"> 
                            <a href="#" class="list-group-item addButton" style="text-align:center"> 
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a> 
                        </div>
                    </td>
                </tr>
                <tr>
                <!-- <tr style="background-color:#f4fbff"> -->
                    <td><strong>Soir</strong><br>17:30-19:00</td>
                    <td>
                        <div class="list-group"> 
                            <a href="#" class="list-group-item"> 
                                <p class="list-group-item-heading">Poisson à la Bordelaise (Pacifique nord)</p> 
                                <p class="list-group-item-text">Soir (CHF 8.50)</p> 
                            </a> 
                            <a href="#" class="list-group-item addButton" style="text-align:center"> 
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a> 
                        </div>
                    </td>
                    <td>
                        <div class="list-group"> 
                            <a href="#" class="list-group-item"> 
                                <p class="list-group-item-heading">Poisson à la Bordelaise (Pacifique nord)</p> 
                                <p class="list-group-item-text">Soir (CHF 8.50)</p> 
                            </a> 
                            <a href="#" class="list-group-item addButton" style="text-align:center"> 
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a> 
                        </div>
                    </td>
                    <td>
                        <div class="list-group"> 
                            <a href="#" class="list-group-item"> 
                                <p class="list-group-item-heading">Poisson à la Bordelaise (Pacifique nord)</p> 
                                <p class="list-group-item-text">Soir (CHF 8.50)</p> 
                            </a> 
                            <a href="#" class="list-group-item addButton" style="text-align:center"> 
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a> 
                        </div>
                    </td>
                    <td>
                        <div class="list-group"> 
                            <a href="#" class="list-group-item addButton" style="text-align:center"> 
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a> 
                        </div>
                    </td>
                    <td>
                        <div class="list-group"> 
                            <a href="#" class="list-group-item"> 
                                <p class="list-group-item-heading">Poisson à la Bordelaise (Pacifique nord)</p> 
                                <p class="list-group-item-text">Soir (CHF 8.50)</p> 
                            </a> 
                            <a href="#" class="list-group-item addButton" style="text-align:center"> 
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a> 
                        </div>
                    </td>
                    <td>
                        <div class="list-group"> 
                            <a href="#" class="list-group-item addButton" style="text-align:center"> 
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a> 
                        </div>
                    </td>
                    <td>
                        <div class="list-group"> 
                            <a href="#" class="list-group-item addButton" style="text-align:center"> 
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a> 
                        </div>
                    </td>
                </tr>
                <tr style="background-color: fbfbfb;">
                    <td>Infos</td>
                    <td>
                        <div class="list-group"> 
                            <a href="#" class="list-group-item addButton" style="text-align:center"> 
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a> 
                        </div>
                    </td>
                    <td>
                        <div class="list-group"> 
                            <a href="#" class="list-group-item addButton" style="text-align:center"> 
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a> 
                        </div>
                    </td>
                    <td>
                        <div class="list-group"> 
                            <a href="#" class="list-group-item addButton" style="text-align:center"> 
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a> 
                        </div>
                    </td>
                    <td>
                        <div class="list-group"> 
                            <a href="#" class="list-group-item"> 
                                <p class="list-group-item-heading">Réserver pour la fondue</p> 
                            </a> 
                            <a href="#" class="list-group-item addButton" style="text-align:center"> 
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a> 
                        </div>
                    </td>
                    <td>
                        <div class="list-group"> 
                            <a href="#" class="list-group-item"> 
                                <p class="list-group-item-heading">Réserver pour la fondue</p> 
                            </a> 
                            <a href="#" class="list-group-item addButton" style="text-align:center"> 
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a> 
                        </div>
                    </td>
                    <td>
                        <div class="list-group"> 
                            <a href="#" class="list-group-item addButton" style="text-align:center"> 
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a> 
                        </div>
                    </td>
                    <td>
                        <div class="list-group"> 
                            <a href="#" class="list-group-item addButton" style="text-align:center"> 
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a> 
                        </div>
                    </td>
                </tr>

            <!-- @yield('weekly-body') -->

            </tbody>
        </table>
        </div>
    </div>
    <!-- / Weekly menus-->

    <!-- /Content -->
@endsection

@include('menus/modals/create-edit')
@include('notices/modals/create-edit')

@push('scripts')
<script src="{{ asset("bower_components/bootstrap/js/transition.js") }}"></script>
<script src="{{ asset("bower_components/bootstrap/js/collapse.js") }}"></script>
<script src="{{ asset("bower_components/moment/min/moment-with-locales.min.js") }}"></script>
<script src="{{ asset("bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js") }}"></script>
<script src="{{ asset("js/convenience.js") }}"></script>
<script src="{{ asset("js/mensa-modals.js") }}"></script>

<script type="text/javascript">

// Week select

        $(document).ready(function(){
            moment.locale('en', {
            week: { dow: 1 } // Monday is the first day of the week
            });

        //Initialize the datePicker(I have taken format as mm-dd-yyyy, you can     //have your owh)
        $("#weeklyDatePicker").datetimepicker({
            format: 'DD.MM.YYYY'
        });

        //Get the value of Start and End of Week
        $('#weeklyDatePicker').on('dp.change', function (e) {
            var value = $("#weeklyDatePicker").val();
            var firstDate = moment(value, "DD.MM.YYYY").day(1).format("DD.MM.YYYY");
            var lastDate =  moment(value, "DD.MM.YYYY").day(7).format("DD.MM.YYYY");
            $("#weeklyDatePicker").val(firstDate + " - " + lastDate);
        });
        });


        // Date

    $('#change-date').click(function(e) {
        var selected_date = $('#selected-date').val();
        var site_id = $('#site_id').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // get real data
        $.ajax({
            method: "POST",
            url: '{{ Request::url() }}',
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
                        <td colspan="7">{{ trans('messages.error') }}</td>\
                    </tr>';
                $(error_message).appendTo($('#weekly-body'));
                console.log(error);
            },
            success: function(data) {
                // get table body and remove it
                $('#weekly-body').empty();
                $(data).appendTo($('#weekly-body'));
                // update date from/to in title
                $('#weekly-from').html(data.from);
                $('#weekly-to').html(data.to);
            }
        })
    });
</script>
@endpush