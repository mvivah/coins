<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config("app.name", "AH Consulting") }}</title>

    <!-- Styles -->
    <link href="{{ asset("css/app.css") }}" rel="stylesheet">
    <link href="{{ asset("css/dataTables.bootstrap4.css") }}" rel="stylesheet">
    <link href="{{ asset("css/fontawesome-all.min.css") }}" rel="stylesheet">
    <link href="{{ asset("css/style.css") }}" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset("/files/ahlogo.png") }}" type="image/png">
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-light shadow-sm">
        <div class="container-fluid">
            <a href="/" class="navbar-brand"><img src="{{ asset("files/ahlogo.png") }}" height="30px" margin-top="0"></a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapse">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a href="/contacts" class="nav-link"><i class="far fa-address-book"></i> Contacts</a></li>
                    <li class="nav-item"><a href="/associates" class="nav-link"><i class="fas fa-user-graduate"></i> Associates</a></li>
                    <li class="nav-item"><a href="/opportunities" class="nav-link"><i class="fa fa-th-list"></i> Opportunities</a></li>
                    <li class="nav-item"><a href="/projects" class="nav-link"><i class="fa fa-database"></i> Projects</a></li>
                    <li class="nav-item"><a href="/partners" class="nav-link"><i class="fas fa-users"></i> Partner Firms</a></li>
                    <li class="nav-item"><a href="/reports" class="nav-link"><i class="fa fa-clipboard-check"></i> Reports</a></li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user-circle-o"></i> {{ Auth::user()->name }}</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="/support"><i class="far fa-life-ring"></i> Support</a>
                            <a class="dropdown-item" href="/users/{{Auth::user()->id}}"><i class="fas fa-user-cog"></i> Profile</a>
                            @if(Gate::check('isAdmin') || Gate::check('isDirector'))
                            <a class="dropdown-item" href="/teams/{{Auth::user()->team_id}}"><i class="fas fa-sitemap"></i> My Team</a>
                            @endif
                            <a class="dropdown-item" href="/users"><i class="fa fa-users"></i>  Staff</a>
                                <a class="dropdown-item" href="/admin"><i class="fas fa-cogs"></i> Admin</a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-power"></i>
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Notifications Area --}}
    <div id="notices"></div>

    {{-- <main class=""> --}}
    <main class="container-fluid py-2">
        {{-- Content for all the pages --}}
        @yield("content")
        {{-- Forms and Modals --}}
        @include("partials.modals")
    </main>
    
    <!-- Scripts -->
    <script src="{{ asset("js/app.js") }}"></script>
    <script src="{{ asset("js/Chart.bundle.min.js") }}"></script>
    <script src="{{ asset("js/Chart.min.js") }}"></script>
    <script src="{{ asset("js/jquery.dataTables.js") }}"></script>
    <script src="{{ asset("js/dataTables.bootstrap4.js") }}"></script>
    <script src="{{ asset("js/jquery.js") }}"></script>
    <script src="{{ asset("js/datasource.js") }}"></script>
    <script src="{{ asset("js/script.js") }}"></script>
</body>
</html>