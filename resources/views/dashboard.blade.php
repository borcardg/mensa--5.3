@extends('home')

@push('stylesheets')

<link href="{{ asset("css/multi-select.css") }}" rel="stylesheet">
@endpush


@section('main_content')

    
    <?php
    $counter = 1;
    $boot_style = 'info';
    ?>

    @foreach($sites as $site)
        @if ($counter % 3 == 0)
            <div class="row">
                @endif
                <div class="col-sm-4">


                        <div class="card card-user">
                            <div class="image">
                            
                                <img src="{{ asset('img/bg/'.$site->id.'.jpg') }}" alt="...">
                            </div>
                            <div class="content">
                                <div class="author">
                                @if ($site->isCafet)
                                <img class="avatar border-white" src="{{ asset('img/faces/cafeteria.png') }}" alt="...">
                                @else
                                <img class="avatar border-white" src="{{ asset('img/faces/mensa.png') }}" alt="...">
                                @endif
                                  <h4 class="title">{{ $site->translate()->name }}<br>
                                     <a href="#"><small>{!! $site->address !!}</small></a>
                                  </h4>
                                </div> 
                          
                                <p class="description text-center"> 
                                @if (!$site->isCafet)
                                    @if($site->today)
                                Aujourd'hui:
                                    <table class="table table-striped">
                                    @foreach($site->today as $menu)
                                        <tr>
                                            <td>{{ $menu->translate()->title }}<small> {{ $menu->translate()->subtitle }}</small></td>
                                            <td> <small>({{ $menu->label }})</small></td>
                                        </tr> 
                                    @endforeach
                                    </table>
                                    @endif
                                @endif
                                </p>
                            </div>
                            <div class="text-center">
                                <div class="row">
                                    <div class="col-md-3 col-md-offset-1">
                                        <a class="btn btn-link btn-md btn-block btn-primary modalButton"  data-toggle="modal" data-item-type="sites" data-id="{{ $site->id }}" data-action-type="edit" role="button">
                                            <i class="ti-settings"></i>     
                                        </a>
                                        <br>
                                        <br>
                                    </div>
                                    <div class="col-md-4">

                                        @if (!$site->isCafet)
                                        <a class="btn btn-link btn-md btn-primary btn-block" href="{{ URL::to('generate-pdf/' . $site->id . '/'.date('d.m.Y')) }}" role="button">
                                            <i class="ti-import"></i> PDF
                                        </a>

                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        
                                        @if (!$site->isCafet)
                                            <a class="btn btn-default btn-md btn-primary btn-block"  href="{{ URL::to('sites/' . $site->id . '/'.date('d.m.Y')) }}" role="button">
                                                <i class="ti-calendar"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                </div>                                   
                


                @if ($counter % 3 == 0)
            </div>
        @endif
        <?php $counter++; ?>
    @endforeach


        <div class="col-sm-4">
            

            <div class="card card-user">
                <div class="content">
                    
                <h4 class="description text-center">
                    <a class="modalButton" data-toggle="modal" data-item-type="sites" data-id="0" data-action-type="create">Ajouter un site</a>
                </h4>
                <div class="text-center">
                </div>
            </div>
                  
          </div>

@endsection




@push('scripts')->
<script src="{{ asset("js/jquery.multi-select.js") }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        setModalListener();
    });

    function setModalListener(){
        $('.modalButton').on('click', function(){
            var this_id = $(this).attr('data-id');
            var this_action = $(this).attr('data-action-type');
            var this_type = $(this).attr('data-item-type');
            
                var url = "{{ url('/') }}/"+this_type+"/form/"+this_action+"/"+this_id;
                $.get(url, function( data ) {
                    $('#myModal').modal();
                    $('#myModal').on('shown.bs.modal', function(){
                        $('#myModal .load_modal').html(data);

                        $('#exportSelect').multiSelect({
                            selectableHeader: "<div class='custom-header'>Masqués</div>",
                            selectionHeader: "<div class='custom-header'>Affiché sur le document</div>",
                            keepOrder: true,
                            afterInit: function(ms){
                                // console.log($('#export').val());
                                var selection =  JSON.parse($('#export').val());
                                for(var i=0;i<selection.length;i++){
                                    // var sel = [];
                                    val = selection[i];
                                    // sel.push(val);
                                    $('#exportSelect').multiSelect('select', val);
                                }
                            },
                            afterSelect: function(values){
				    var val = JSON.parse($("#export").val());

                                if(val.indexOf(values[0]) !== -1){
                                    console.log("Value exists!")
                                } else{
                                    val.push(values[0]);
                                      console.log("Value does not exists! : " +values[0])
                                }

                                $("#export").val(JSON.stringify(val));
                            },
                            afterDeselect: function(values){
			      var val = JSON.parse($("#export").val());

                              var index = val.indexOf(values[0]);
                              if(index !== -1){
                                  val.splice(index, 1);
                                  console.log("Removed! : "+values[0]);
                              } else{
                                  val.push(values[0]);
                                    console.log("Doesnt exist!" );
                              }

                              $("#export").val(JSON.stringify(val));

                            }
                        });
                        $('.deleteButton').on('click', function(){
                            var url = "{{ url('/') }}/"+this_type+"/form/remove/"+this_id;
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
@endpush
