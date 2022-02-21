<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{{ trans('messages.edit') }} <small>{{ $notice->translate()->title }}</h4>
</div>
<div class="modal-body ">

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">

            <!-- if there are creation errors, they will show here -->
            {{ Html::ul($errors->all()) }}

            {!! Form::model($notice, ['method' => 'PUT', 'action' => ['NoticeController@update', $notice->id], 'autocomplete' => 'off']) !!}


            <div class="row">
                <div class="col-sm-12 col-md-12">
                    {!! Form::label('fr[title]', trans('messages.title')) !!}
                    {!! Form::text('fr[title]', $notice->title, ['class' => 'form-control']) !!}
                    <!-- {!! Form::hidden('de[title]', null, ['class' => 'form-control']) !!} -->
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    {!! Form::label('fr[content]', trans('messages.content')) !!}
                    {!! Form::text('fr[content]', $notice->content, ['class' => 'form-control']) !!}
                    <!-- {!! Form::hidden('de[content]', null, ['class' => 'form-control']) !!} -->
                </div>
            </div>

            <hr>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    {!! Form::hidden('site_id', null, ['class' => 'form-control', 'id' => 'site_id']) !!}
                </div>
                <div class="col-sm-6 col-md-6">
                    {!! Form::label('isImportant', trans('messages.isImportant')) !!}
                    {!! Form::select('isImportant', array('0' => 'Informatif', '1' => 'Important'), null, ['class' => 'form-control']) !!}
                </div>

                <div class="col-md-6">
                    <label for="daterange">Dates</label>
                    <input type="text" id="daterange" value="05/12/2018 - 10/12/2018" class="form-control" />
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-md-6">
                    {!! Form::hidden('date_start', null, ['class' => 'form-control', 'id' => 'date_start']) !!}
                </div>
                <div class="col-sm-6 col-md-6">
                    {!! Form::hidden('date_end', null, ['class' => 'form-control', 'id' => 'date_end']) !!}
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