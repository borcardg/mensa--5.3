<div class="sidebar-wrapper">
    <div class="logo">
        <a class="simple-text">
        <img src="{{ asset('img/logo.png') }}" width="100%" />
        </a>
    </div>
    <ul class="nav">
    
       
        <li {{{ Request::is('home') ? 'class=active' : '' }}}>
            <a href="{{ url('home') }}">
                <i class="ti-home"></i>
                <p>{{ trans('messages.dashboard') }}</p>
            </a>
        </li>
        <li {{{ Request::is('sites/*') ? 'class=active' : '' }}}>
            <a href="{{ URL::to('sites/1/'.date('d.m.Y')) }}">
                <i class="ti-calendar"></i>
                <p>{{ trans('messages.sites-weekly') }}</p>
            </a>
        </li>
        <li {{{ Request::is('labels') ? 'class=active' : '' }}}>
            <a href="{{ URL::to('labels') }}">
                <i class="ti-tag"></i>
                <p>{{ trans('messages.labels') }}</p>
            </a>
        </li>
    </ul>
</div>

