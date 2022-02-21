<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{{ trans('messages.editsite') }}</h4>
</div>
<div class="modal-body ">

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">

            <!-- if there are creation errors, they will show here -->
            {{ Html::ul($errors->all()) }}

            {!! Form::model($site, ['method' => 'PUT', 'action' => ['SiteController@update', $site->id], 'autocomplete' => 'off']) !!}
            <div class="row">
                <div class="col-md-4">
                    {!! Form::label('name', trans('messages.name')) !!}

                    {!! Form::text('name', $site->name, ['class' => 'form-control']) !!}
                    {!! Form::hidden('de[name]', null, ['class' => 'form-control']) !!}

                </div>
                <div class="col-md-4">
                {!! Form::label('opentimenoon', trans('messages.opentimenoon')) !!}
                {!! Form::text('opentimenoon', $site->opentimenoon, ['class' => 'form-control']) !!}
                </div>

                <div class="col-md-4">
                {!! Form::label('opentimeevening', trans('messages.opentimeevening')) !!}
                {!! Form::text('opentimeevening', $site->opentimeevening, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">

                <div class="col-md-4">
                {!! Form::label('isCafet', trans('messages.isCafet')) !!}
                {!! Form::select('isCafet', array('0' => 'Mensa', '1' => 'Cafétéria'), $site->isCafet, ['class' => 'form-control']) !!}
                </div>
                <div class="col-md-8">
                    {!! Form::label('address', trans('messages.address')) !!}
                    {!! Form::text('address', $site->address, ['class' => 'form-control']) !!}
                    {!! Form::hidden('de[address]', null, ['class' => 'form-control']) !!}
                </div>



            </div>

            <div class="row">
                <div class="col-md-12">
                    <!-- {!! Form::label('image', 'Photo') !!} -->
                    {!! Form::hidden('image', $site->address, ['class' => 'form-control']) !!}
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                {!! Form::label('exportSelect', 'Libellés pour l\'export Word') !!}
                {!! Form::select('exportSelect', $labels, null, ['class' => 'form-control','multiple' => 'multiple','name' => 'exportSelect[]']) !!}
                {!! Form::hidden('export', $site->export, ['class' => 'form-control','id' => 'export']) !!}
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    {!! Form::label('texte', trans('messages.texte')) !!}
                    {!! Form::text('texte', $site->texte, ['class' => 'form-control']) !!}
                    {!! Form::hidden('de[texte]', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    {!! Form::label('remark', trans('messages.remark')) !!}
                    {!! Form::text('remark', $site->remark, ['class' => 'form-control']) !!}
                    {!! Form::hidden('de[remark]', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <hr>
            <div class="row">
            <div class="form-group">
                <div class="col-md-6">
                        <a class="btn btn-block deleteButton">
                            <i class="ti ti-trash"></i> {{ trans('messages.delete') }}
                        </a>
                </div>
                <div class="col-md-6">
                    {!! Form::submit( trans('messages.save'), ['class' => 'btn btn-block btn-primary']) !!}
                </div>
            </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
