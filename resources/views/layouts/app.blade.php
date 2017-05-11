<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                        @permission('user-*')
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Użytkownicy <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                            @permission(['user-create','user-crud'])
                                <li><a href="{{ route('register') }}">Dodaj</a></li>
                            @endpermission
                            @permission(['student-retrive','student-crud'])
                                <li><a href="{{ url('user/student') }}">Kursanci</a></li>
                            @endpermission
                            @permission(['instructor-retrive','instructor-crud'])
                                <li><a href="{{ url('user/instructor') }}">Instruktorzy</a></li>
                            @endpermission
                            @permission(['officce-retrive','officce-crud'])
                                <li><a href="{{ url('user/officce') }}">Pracownicy biurowi</a></li>
                            @endpermission
                            @permission(['admin-retrive','admin-crud'])
                                <li><a href="{{ url('user/admin') }}">Admini</a></li>
                            @endpermission
                            </ul>
                        </li>
                        @endpermission
                        @permission(['drive-retrive','drive-crud'])
                        <li><a href="{{route('drive.index')}}">Jazdy</a></li>
                        @endpermission
                        @permission(['hour-retrive','hour-crud'])
                        <li><a href="{{route('hour.index')}}">Godziny</a></li>
                        @endpermission
                        @permission(['payment-retrive','payment-crud'])
                        <li><a href="{{route('payment.index')}}">Płatności</a></li>
                        @endpermission
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->roles[0]['display_name'] }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        @include('partials._notifications')
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
