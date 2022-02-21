@extends('layouts.blank')

@push('stylesheets')

@endpush

@section('main_container')

	<!-- page content -->
	<div class="container-fluid">
		@yield('main_content')
	</div>
	<!-- /page content -->
@endsection