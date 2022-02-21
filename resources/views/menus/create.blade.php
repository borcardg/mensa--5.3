<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{{ trans('messages.addmenu') }} </h4>
</div>
<div class="modal-body ">
<div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">

        <!-- if there are creation errors, they will show here -->
        {{ Html::ul($errors->all()) }}

        {!! Form::open(['action' => 'MenuController@store', 'autocomplete' => 'off']) !!}

        <div class="row">
            <div class="col-md-6">
                {!! Form::label('fr[title]', trans('messages.title')) !!}
                {!! Form::text('fr[title]', null, ['class' => 'form-control']) !!}
                {!! Form::hidden('de[title]', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('fr[subtitle]', trans('messages.subtitle')) !!}
                {!! Form::text('fr[subtitle]',null, ['class' => 'form-control']) !!}
                {!! Form::hidden('de[subtitle]', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {!! Form::label('fr[accompaniment]', trans('messages.accompaniment')) !!}
                {!! Form::textarea('fr[accompaniment]',null, ['class' => 'form-control']) !!}
                {!! Form::hidden('de[accompaniment]', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {!! Form::label('fr[veg]', trans('messages.veg')) !!}
                {!! Form::text('fr[veg]',null, ['class' => 'form-control']) !!}
                {!! Form::hidden('de[veg]', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {!! Form::label('fr[specialprice]', trans('messages.specialprice')) !!}
                {!! Form::text('fr[specialprice]',null, ['class' => 'form-control']) !!}
                {!! Form::hidden('de[specialprice]', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-4">
                {!! Form::label('label_id', trans('messages.label')) !!}
                {!! Form::select('label_id', $labels, null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-4">
                {!! Form::label('isMain', trans('messages.isMain')) !!}
                {!! Form::select('isMain', array('0' => 'Non principal', '1' => 'Menu principal'), null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-4">
                <label for="daterange">Dates</label>
                <input type="text" id="daterange" value="05/12/2018 - 10/12/2018" class="form-control" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! Form::hidden('date_start', null, ['class' => 'form-control', 'id'=>'date_start']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::hidden('date_end', null, ['class' => 'form-control', 'id'=>'date_end']) !!}
            </div>
            </div>
            <div class="row">
            <div class="col-md-6">
                {!! Form::hidden('site_id', null, ['class' => 'form-control', 'id' => 'site_id']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::hidden('period', null, ['class' => 'form-control', 'id' => 'period']) !!}
            </div>
        </div>

        <hr>
        <div class="form-group">
            <div class="col-md-12">
            {!! Form::submit( trans('messages.save'), ['class' => 'btn btn-block btn-primary']) !!}
            </div>
        </div>

        {!! Form::close() !!}




    </div>
</div>

</div>
