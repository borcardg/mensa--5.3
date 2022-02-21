<div id="modal-menu-create-edit" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title title-create">{{ trans('messages.addmenu') }}</h4>
                <h4 class="modal-title title-edit">{{ trans('messages.edit') }} <small></small></h4>
            </div>
            
            <div class="modal-body">                    

                {!! BootForm::openHorizontal(['sm' => [0,12], 'md' => [0,12]])->action(route('menus.store')) !!}
                <div class="row">
                    <div class="col-sm-4 col-md-4"></div>
                    <div class="col-sm-8 col-md-8">
                            
                            {!! BootForm::text(trans('messages.title'), 'fr[title]')->placeholder('Spaghettis') !!}
                            {!! BootForm::hidden('de[title]', '') !!}
                            {{-- BootForm::text(trans('messages.title') . ' (de)', 'de[title]')->placeholder('Spaghettis') --}}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        {!! BootForm::textarea(trans('messages.accompaniment'), 'fr[accompaniment]') !!}
                        {!! BootForm::hidden('de[accompaniment]', '') !!}
                        {{-- BootForm::textarea(trans('messages.accompaniment') . ' (de)', 'de[accompaniment]') --}}
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <div>
                            <label for="dtp-start" class="control-label" for="date_start">{{ trans('messages.date_start') }}</label>
                                <div class="input-group dtpicker" id="dtp-start">
                                    <input name="date_start" type="text" class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <div>
                                <label class="control-label" for="date_end">{{ trans('messages.date_end') }}</label>
                                <div class="input-group dtpicker" id="dtp-end">
                                    <input name="date_end" type="text" class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        {!! BootForm::select(trans('messages.site'), 'site_id', []) !!}

                        {!! BootForm::hidden('period', false) !!}
                        {!! BootForm::checkbox(trans('messages.noon'), 'period') !!}

                        {!! BootForm::hidden('isMain', false) !!}
                        {!! BootForm::checkbox(trans('messages.isMain'), 'isMain') !!}

                        {!! BootForm::select(trans('messages.label'), 'label_id', []) !!}
                    </div>
                </div>


             

                {!! BootForm::close() !!}
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-close" data-dismiss="modal">{{ trans('messages.close') }}</button>
                <button type="submit" class="btn btn-success btn-create"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> {{ trans('messages.create') }}</button>
                <button type="submit" class="btn btn-success btn-update"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> {{ trans('messages.save') }}</button>
                <button type="submit" class="btn btn-danger btn-delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> {{ trans('messages.delete') }}</button>
            </div>
            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
