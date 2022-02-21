@extends('home')

@push('script-head')
@endpush

@section('main_content')

    <!-- Content -->

    <!-- will be used to show any messages -->
    @if (session('message'))
        <div class"row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="alert alert-success alert-dismissible" role="alert">{{ session('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        </div>
        </div>
    @endif

    <div class="row">
        <h1 class="page-header">{{ trans('messages.menus') }}</h1>
        <p><!-- Show button -->
            <a class="btn btn-small btn-default" href="{{ URL::to('menus/create') }}"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> {{ trans('messages.add') }}</a>
        </p>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th></th>
                    <th>#</th>
                    <th>{{ trans('messages.title') }}</th>
                    <th>{{ trans('messages.subtitle') }}</th>
                    <th>{{ trans('messages.accompaniment') }}</th>
                    <th>{{ trans('messages.veg') }}</th>
                    <th>{{ trans('messages.date_start') }}</th>
                    <th>{{ trans('messages.date_end') }}</th>
                    <th>{{ trans('messages.period') }}</th>
                    <th>{{ trans('messages.isMain') }}</th>
                    <th>{{ trans('messages.label') }}</th>
                    <th>{{ trans('messages.site') }}</th>
                    <th>{{ trans('messages.actions') }}</th>
                </tr>
                </thead>

                <tbody>
                @if ($menus->count() == 0)
                    <tr>
                        <td colspan="11">
                            <p class="text-center">{{ trans('messages.no_data') }}</p>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @else
                    @foreach($menus as $key => $value)
                        <tr>
                            <td></td>
                            <td>{{ $value->id }}</td>
                            <td>
                                {{ $value->translate()->title }}
                            </td>
                            <td>
                                {{ $value->translate()->subtitle }}
                            </td>
                            <td>
                                {!! $value->translate()->accompaniment !!}
                            </td>
                            <td>
                                {{ $value->translate()->veg }}
                            </td>
                            <td>
                                {{ $value->date_start }}
                            </td>
                            <td>
                                {{ $value->date_end }}
                            </td>
                            <td>
                                @if ($value->period)
                                    <span class="label label-success">{{ trans('messages.noon') }}</span>
                                @else
                                    <span class="label label-primary">{{ trans('messages.evening') }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($value->isMain)
                                    <span class="label label-success">{{ trans('messages.yes') }}</span>
                                @else
                                    <span class="label label-danger">{{ trans('messages.no') }}</span>
                                @endif
                            </td>
                            <td>
                                {{ $value->label->name }}
                            </td>
                            <td>
                                {{ $value->site->name }}
                            </td>
                            <td>
                                {!! BootForm::open()->action(route('menus.destroy', ['id' => $value->id]))->delete() !!}
                                <!-- Show button -->
                                <a class="btn btn-sm btn-default" href="{{ URL::to('menus/' . $value->id) }}"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
                                <!-- Edit button -->
                                <a class="btn btn-sm btn-primary" href="{{ URL::to('menus/' . $value->id . '/edit') }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                <!-- Delete button -->
                                {!! BootForm::submit('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>', 'btn-sm btn-danger') !!}
                                {!! BootForm::close() !!}
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>

            </table>
        </div>

        {!! $menus->render() !!}
    </div>


    <!-- /Content -->
@endsection

