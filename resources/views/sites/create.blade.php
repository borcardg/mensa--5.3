<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{{ trans('messages.addsite') }}</h4>
</div>
<div class="modal-body ">

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">

            <!-- if there are creation errors, they will show here -->
            {{ Html::ul($errors->all()) }}
            {!! Form::open(['action' => 'SiteController@store', 'autocomplete' => 'off']) !!}

            <div class="row">
                <div class="col-sm-6 col-md-6">
                    {!! Form::label('fr[name]', trans('messages.name')) !!}

                    {!! Form::text('fr[name]', null, ['class' => 'form-control']) !!}
                    {!! Form::hidden('de[name]', null, ['class' => 'form-control']) !!}
               
                </div>
                <div class="col-sm-6 col-md-6">
                    {!! Form::label('isCafet', trans('messages.isCafet')) !!}
                    {!! Form::select('isCafet', array('0' => 'Mensa', '1' => 'Cafétéria'), 0, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    {!! Form::label('fr[address]', trans('messages.address')) !!}
                    {!! Form::text('fr[address]', null, ['class' => 'form-control']) !!}
                    {!! Form::hidden('de[address]', null, ['class' => 'form-control']) !!}
                </div>

            </div>
<hr>
            <div class="row">
            <div class="form-group">
                <div class="col-md-12">
                    {!! Form::submit( "Créer", ['class' => 'btn btn-primary btn-block']) !!}
                </div>
            </div>
            </div>
            {!! Form::close() !!}  
        </div>
    </div>
</div>