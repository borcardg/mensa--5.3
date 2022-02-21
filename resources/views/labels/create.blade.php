<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{{ trans('messages.addlabel') }}</h4>
</div>
<div class="modal-body ">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">


            <!-- if there are creation errors, they will show here -->
            {{ Html::ul($errors->all()) }}
            {!! Form::open(['action' => 'LabelController@store', 'autocomplete' => 'off']) !!}

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        {!! Form::label('fr[name]', trans('messages.namemenu')) !!}

                        {!! Form::text('fr[name]', null, ['class' => 'form-control']) !!}
                        {!! Form::hidden('de[name]', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-12 col-md-6">
                        {!! Form::label('description', trans('messages.description')) !!}
                        {!! Form::text('description', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-4">
                        {!! Form::label('price', trans('messages.price')) !!}
                        {!! Form::text('price', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-4 col-md-4">
                        {!! Form::label('order', trans('messages.order')) !!}
                        {!! Form::selectRange('order', 0, 10, 0, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-4 col-md-4">
                        {!! Form::label('noon', trans('messages.period')) !!}                
                        {!! Form::select('noon', array('1' => 'Midi', '0' => 'Soir'), null, ['class' => 'form-control']) !!}

                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group">

                        <div class="col-md-12">
                            {!! Form::submit( trans('messages.create'), ['class' => 'btn btn-primary btn-blocks']) !!}
                        </div>

                
                    {!! Form::close() !!}  
                    </div>
                </div>
        </div>
    </div>
</div>