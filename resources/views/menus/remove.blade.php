<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{{ trans('messages.delete') }}</h4>
</div>
<div class="modal-body ">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

            <p>Êtes-vous sûr de vouloir supprimer le menu "<strong>{{ $menu->title }}</strong>" ?</p>
            <!-- if there are creation errors, they will show here -->
            {{ Html::ul($errors->all()) }}
                {!! Form::model($menu, ['method' => 'DELETE', 'action' => ['MenuController@destroy', $menu->id], 'autocomplete' => 'off']) !!}

            
                <hr>
                <div class="row">
                    <div class="form-group">

                        <div class="col-md-6">
                            <a class="btn btn-primary form-control"  data-dismiss="modal" aria-hidden="true">{{ trans('messages.discard') }}</a>
                        </div>
                        <div class="col-md-6">
                            {!! Form::submit( trans('messages.delete'), ['class' => 'btn btn-danger form-control']) !!}
                        </div>

                
                    </div>
                </div>
                {!! Form::close() !!}  
        </div>
    </div>
</div>
