<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Subscription Boxes for Nerds | NerdBlock</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app" class=" bg-dark">
        <div class="fixed sidebar bg-dark"></div>
        <nav class="navbar navbar-default navbar-static-top bg-dark">
            <div class="container">
                <div class="navbar-header">
                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        NerdBlock
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Session::has('active_user'))
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-expanded="false">
                                    {{ Session()->get('first_name') . ' ' . Session()->get('last_name') }} <span
                                        class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <ul class="nav nav-pill fixed sidebar bg-dark">
            <li><a href="/catalogue" class="btn">View Catalogue</a></li>
            @if (Session::has('active_user'))
                <li><a href="/subscriptions" class="btn">View Subscriptions</a></li>
                @if (session()->get('user_type') == 'A' || session()->get('user_type') == 'E')
                    <li><a href="/users" class="btn">View Users</a></li>
                    <li><a href="/packages" class="btn">View Packages</a></li>
                    <li><a href="/products" class="btn">View Products</a></li>
                    <li><a href="/shipments" class="btn">View Shipments</a></li>
                    <li><a href="/sent_package" class="btn">Fulfill Order</a></li>
                @endif
                @if (session()->get('user_type') == 'A')
                    <li><a href="/reports" class="btn">Reports</a></li>
                @endif
            @endif
        </ul>
        <div class="d-flex content-space bg-light">
            <div class="center-block">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
