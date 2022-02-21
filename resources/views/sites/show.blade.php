@extends('home')

@push('script-head')
@endpush

@section('main_content')

    <div class="row">
        <h1 class="page-header">{{ trans('messages.site') }} <small>{{ $site->name }}</small></h1>
    </div>

    <div class="row">
        <div class="col-sm-2">
            <p class="pull-right">
                <strong>{{ trans('messages.isCafet') }}</strong>
            </p>
        </div>
        <div class="col-sm-6">
            @if ($site->isCafet)
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
                <strong>{{ trans('messages.name') }}</strong>
            </p>
        </div>

        <div class="col-sm-6">
            {{ $site->translate('fr')->name }}<br />
            {{ $site->translate('de')->name }}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-2">
            <p class="pull-right">
                <strong>{{ trans('messages.address') }}</strong>
            </p>
        </div>
        <div class="col-sm-6">
            <div class="well">
                {!! $site->translate('fr')->address !!}
            </div>

            <div class="well">
                {!! $site->translate('de')->address !!}
            </div>
        </div>
    </div>


    <hr>

    <div class="row">
        <div class="col-sm-offset-2 col-sm-6">
            {!! BootForm::open()->action(route('sites.destroy', ['id' => $site->id]))->delete() !!}

            <a class="btn btn-small btn-default" href="{{ URL::previous() }}"><span class="glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span> {{ trans('messages.go_back') }}</a>
            <a class="btn btn-small btn-primary" href="{{ URL::to('sites/' . $site->id . '/edit') }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> {{ trans('messages.edit') }}</a>
            {!! BootForm::submit( '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> ' . trans('messages.delete'), 'btn-danger') !!}

            {!! BootForm::close() !!}
        </div>
    </div>


@endsection