<!-- top navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">UNIFR | Mensa</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ url('home') }}">{{ trans('messages.dashboard') }}</a></li>
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" id="dropdownMenuUser">
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span> {{ Auth::user()->name }}
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenuUser">
                        <li><a href="{{ url('/auth/logout') }}"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- /top navigation -->