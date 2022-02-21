@extends('home')

@push('script-head')
@endpush

@section('main_content')

    <div class="row">
        <h1 class="page-header">{{ trans('messages.notice') }} <small>{{ $notice->title }}</small></h1>
    </div>

    <div class="row">
        <div class="col-sm-2">
            <p class="pull-right">
                <strong>{{ trans('messages.date_start') }}</strong>
            </p>
        </div>
        <div class="col-sm-6">{{ $notice->date_start }}</div>
    </div>

    <div class="row">
        <div class="col-sm-2">
            <p class="pull-right">
                <strong>{{ trans('messages.date_end') }}</strong>
            </p>
        </div>
        <div class="col-sm-6">{{ $notice->date_end }}</div>
    </div>


    <div class="row">
        <div class="col-sm-2">
            <p class="pull-right">
                <strong>{{ trans('messages.site') }}</strong>
            </p>
        </div>
        <div class="col-sm-6">
            {{ $notice->site->name }}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-2">
            <p class="pull-right">
                <strong>{{ trans('messages.isImportant') }}</strong>
            </p>
        </div>
        <div class="col-sm-6">
            @if ($notice->isImportant)
                <span class="label label-success">{{ trans('messages.yes') }}</span>
            @else
                <span class="label label-danger">{{ trans('messages.no') }}</span>
            @endif
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-sm-2">
            <p class="pull-right">
                <strong>{{ trans('messages.title') }}</strong>
            </p>
        </div>

        <div class="col-sm-6">
            {{ $notice->translate('fr')->title }}<br />
            {{ $notice->translate('de')->title }}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-2">
            <p class="pull-right">
                <strong>{{ trans('messages.content') }}</strong>
            </p>
        </div>
        <div class="col-sm-6">
            <div class="well">
                {!! $notice->translate('fr')->content !!}
            </div>

            <div class="well">
                {!! $notice->translate('de')->content !!}
            </div>
        </div>
    </div>


    <hr>

    <div class="row">
        <div class="col-sm-offset-2 col-sm-6">
            {!! BootForm::open()->action(route('notices.destroy', ['id' => $notice->id]))->delete() !!}

            <a class="btn btn-small btn-default" href="{{ URL::previous() }}"><span class="glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span> {{ trans('messages.go_back') }}</a>
            <a class="btn btn-small btn-primary" href="{{ URL::to('notices/' . $notice->id . '/edit') }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> {{ trans('messages.edit') }}</a>
            {!! BootForm::submit( '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> ' . trans('messages.delete'), 'btn-danger') !!}

            {!! BootForm::close() !!}
        </div>
    </div>

@endsection