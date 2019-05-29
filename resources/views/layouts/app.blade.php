<!doctype html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config("app.name") }}</title>

        <!-- Bootstrap core CSS -->
        <link href="{{ asset("css/app.css") }}" rel="stylesheet">
        <link href="{{ asset("css/dashboard.css") }}" rel="stylesheet">
        <link href="{{ asset("css/dataTables.bootstrap4.css") }}" rel="stylesheet">
        <link href="{{ asset("css/fontawesome-all.min.css") }}" rel="stylesheet">
        <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet">
        <!-- Favicon -->
        <link rel="icon" href="{{ asset("/files/ahlogo.png") }}" type="image/png">
    </head>

    <body>
        <nav class="navbar navbar-dark fixed-top bg-secondary flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="/"><span data-feather="home"></span> {{ config("app.name") }}</a>
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span data-feather="power"></span>
                        {{ __('Logout') }}
                    </a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </ul>
        </nav>
        <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="/users/{{Auth::user()->id}}"><span data-feather="user"></span> Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contacts"><span data-feather="file"></span> Contacts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/opportunities"><span data-feather="shopping-cart"></span> Opportunities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/projects"><span data-feather="package"></span> Projects</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/associates"><span data-feather="bar-chart-2"></span> Associates</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/users"><span data-feather="users"></span> Users</a>
                    </li>
                </ul>
                @if(Gate::check('isAdmin') || Gate::check('isDirector'))
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Settings</span>
                        <a class="d-flex align-items-center text-muted" href="#"><span data-feather="plus-circle"></span></a>
                    </h6>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="/teams/{{Auth::user()->team_id}}"><span data-feather="layers"></span> Team</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin"><span data-feather="settings"></span> Admin</a>
                        </li>
                    </ul>
                @endif
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Saved reports</span>
                    <a class="d-flex align-items-center text-muted" href="#"><span data-feather="plus-circle"></span></a>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link" href="/display/current_month"><span data-feather="file-text"></span> Current month</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/display/current_quarter"><span data-feather="file-text"></span> Last quarter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/display/current_year"><span data-feather="upload-cloud"></span> Full year</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/help"><span data-feather="life-buoy"></span> Help</a>
                    </li>
                </ul>
            </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-2 mt-2">
                {{-- Notifications Area --}}
                <div class="row">
                    <div class="col-md-6 offset-md-9 mb-0">
                        <div id="notices">
                            <div id="noticesPoint" class="pr-0"></div>
                        </div>
                    </div>
                </div>
                {{-- Content for all the pages --}}
                @yield("content")
            </main>
        </div>
            {{-- Footer Area --}}
            <footer id="footer" class="container-fluid fixed-bottom">
                <div class="row">
                <div class="col-lg-12">
                    <ul class="list-unstyled">
                        <li class="float-lg-right"><a href="#top"><i class="fas fa-angle-up" style="font-size:3rem;"></i></a></li>
                    </ul>
                </div>
                </div>
            </footer>
        </div>
        {{-- Forms and Modals --}}
        @include("partials.modals")
        <!-- Scripts -->
        <script src="{{ asset("js/app.js") }}"></script>
        <script src="{{ asset("js/popper.min.js") }}"></script>
        <script src="{{ asset("js/Chart.bundle.min.js") }}"></script>
        <script src="{{ asset("js/Chart.min.js") }}"></script>
        <script src="{{ asset("js/jquery.dataTables.js") }}"></script>
        <script src="{{ asset("js/dataTables.bootstrap4.js") }}"></script>
        <script src="{{ asset("js/jquery.js") }}"></script>
        <script src="{{ asset("js/axios.min.js") }}"></script>
        <script src="{{ asset("js/script.js") }}"></script>
        <script src="{{ asset("js/feather.min.js") }}"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
        <script>
          feather.replace()
        </script>
    </body>
</html>