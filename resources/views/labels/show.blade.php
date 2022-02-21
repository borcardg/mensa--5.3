@extends('home')

@push('script-head')
@endpush

@section('main_content')

    <div class="row">
        <h1 class="page-header">{{ trans('messages.label') }} <small>{{ $label->name }}</small></h1>
    </div>

    <div class="row">
        <div class="col-sm-2 col-md-2">
            <p class="pull-right">
                <strong>{{ trans('messages.name') }}</strong>
            </p>
        </div>
        <div class="col-sm-8 col-md-8">
            <p>
                {{ $label->translate('fr')->name }}
            </p>
            <p>
                {{ $label->translate('de')->name }}
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2 col-md-2">
            <p class="pull-right">
                <strong>{{ trans('messages.price') }}</strong>
            </p>
        </div>
        <div class="col-sm-8 col-lg-8">
            <p>
                {{ $label->price }}
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2 col-md-2">
            <p class="pull-right">
                <strong>{{ trans('messages.order') }}</strong>
            </p>
        </div>
        <div class="col-sm-8 col-lg-8">
            <p>
                {{ $label->order }}
            </p>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-sm-offset-2 col-sm-8 col-mc-offset-2 col-lg-8">
            {!! BootForm::open()->action(route('labels.destroy', ['id' => $label->id]))->delete() !!}
            <a class="btn btn-small btn-default" href="{{ URL::previous() }}"><span class="glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span> {{ trans('messages.go_back') }}</a>
            <a class="btn btn-small btn-primary" href="{{ URL::to('labels/' . $label->id . '/edit') }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> {{ trans('messages.edit') }}</a>
            {!! BootForm::submit( '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> ' . trans('messages.delete'), 'btn-danger') !!}
            {!! BootForm::close() !!}
        </div>
    </div>

@endsection