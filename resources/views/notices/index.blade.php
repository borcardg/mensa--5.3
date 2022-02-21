@extends('home')

@push('script-head')
<script>
    $(document).ready(function(){
        $('#datatable-checkbox').DataTable();
    });
</script>
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
        <h1 class="page-header">{{ trans('messages.notices') }}</h1>
        <p><!-- Show button -->
            <a class="btn btn-small btn-default" href="{{ URL::to('notices/create') }}"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> {{ trans('messages.add') }}</a>
        </p>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th></th>
                    <th>#</th>
                    <th>{{ trans('messages.title') }}</th>
                    <th>{{ trans('messages.date_start') }}</th>
                    <th>{{ trans('messages.date_end') }}</th>
                    <th>{{ trans('messages.isImportant') }}</th>
                    <th>{{ trans('messages.name') }}</th>
                    <th>{{ trans('messages.actions') }}</th>
                </tr>
                </thead>

                <tbody>
                @if ($notices->count() == 0)
                    <tr>
                        <td colspan="8">
                            <p class="text-center">{{ trans('messages.no_data') }}</p>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @else
                    @foreach($notices as $key => $value)
                        <tr>
                            <td></td>
                            <td>{{ $value->id }}</td>
                            <td>
                                {{ $value->translate()->title }}
                            </td>
                            <td>
                                {{ $value->date_start }}
                            </td>
                            <td>
                                {{ $value->date_end }}
                            </td>
                            <td>
                                @if ($value->isImportant)
                                    <span class="label label-success">{{ trans('messages.yes') }}</span>
                                @else
                                    <span class="label label-danger">{{ trans('messages.no') }}</span>
                                @endif
                            </td>
                            <td>
                                {{ $value->site->name }}
                            </td>
                            <td>
                                {!! BootForm::open()->action(route('notices.destroy', ['id' => $value->id]))->delete() !!}
                                <!-- Show button -->
                                <a class="btn btn-sm btn-default" href="{{ URL::to('notices/' . $value->id) }}"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
                                <!-- Edit button -->
                                <a class="btn btn-sm btn-primary" href="{{ URL::to('notices/' . $value->id . '/edit') }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
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

        {!! $notices->render() !!}

    </div>


    <!-- /Content -->
@endsection

