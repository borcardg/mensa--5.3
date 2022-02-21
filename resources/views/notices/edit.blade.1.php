<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{{ trans('messages.edit') }} <small>{{ $notice->translate()->title }}</small></h4>
</div>
<div class="modal-body ">

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">

            <!-- if there are creation errors, they will show here -->
            {{ Html::ul($errors->all()) }}

            {!! BootForm::openHorizontal(['sm' => [4, 8], 'md' => [4, 8]])->action(route('notices.update', ['id' => $notice->id]))->put() !!}
            {!! BootForm::bind($notice) !!}

            <div class="row">
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                        <label class="col-sm-4 col-md-4 control-label" for="date_start">{{ trans('messages.date_start') }}</label>
                        <div class="input-group dtpicker" id="dtp-start">
                            <input name="date_start" type="text" class="form-control" value="{{ $notice->date_start }}" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 col-md-4 control-label" for="date_end">{{ trans('messages.date_end') }}</label>
                        <div class="input-group dtpicker" id="dtp-end">
                            <input name="date_end" type="text" class="form-control" value="{{ $notice->date_end }}" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-md-6">
                    {!! BootForm::select(trans('messages.site'), 'site_id', $sites, $notice->site_id) !!}

                    {!! BootForm::checkbox(trans('messages.isImportant'), 'isImportant') !!}
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-sm-6 col-md-6">
                    {!! BootForm::text(trans('messages.title'), 'fr[title]')->placeholder('Réservation') !!}
                </div>
                <div class="col-sm-6 col-md-6">
                    {!! BootForm::hidden('de[title]') !!}
                    {{-- BootForm::text(trans('messages.title') . ' (de)', 'de[title]')->placeholder('Buchung') --}}
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-md-6">
                    {!! BootForm::textarea(trans('messages.content'), 'fr[content]') !!}
                </div>
                <div class="col-sm-6 col-md-6">
                    {!! BootForm::hidden('de[content]') !!}
                    {{-- BootForm::text(trans('messages.content') . ' (de)', 'de[content]') --}}
                </div>
            </div>


            <hr>

            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-6">
                    <a class="btn btn-small btn-default" href="{{ URL::previous() }}"><span class="glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span> {{ trans('messages.go_back') }}</a>
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> {{ trans('messages.save') }}</button>
                </div>
            </div>

            {!! BootForm::close() !!}
        </div>
    </div>
</div>