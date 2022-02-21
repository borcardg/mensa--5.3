<!-- sidebar menu -->
<div class="col-sm-3 col-md-2 sidebar">
    <ul class="nav nav-sidebar">
        <li {{ Request::is('home') ? 'class=active' : '' }}><a href="{{ url('home') }}">{{ trans('messages.dashboard') }}</a></li>
        <li {{ Request::is('weekly') ? 'class=active' : '' }}><a href="{{ URL::to('sites/1/weekly') }}">{{ trans('messages.sites-weekly') }}</a></li>
    </ul>
    <ul class="nav nav-sidebar">
        <li {{ Request::is('sites') ? 'class=active' : '' }}><a href="{{ url('sites') }}">{{ trans('messages.sites') }}</a></li>
        <li {{ Request::is('labels') ? 'class=active' : '' }}><a href="{{ url('labels') }}">{{ trans('messages.labels') }}</a></li>
        <li {{ Request::is('menus') ? 'class=active' : '' }}><a href="{{ url('menus') }}">{{ trans('messages.menus') }}</a></li>
        <li {{ Request::is('notices') ? 'class=active' : '' }}><a href="{{ url('notices') }}">{{ trans('messages.notices') }}</a></li>
    </ul>
</div>
<!-- /sidebar menu -->