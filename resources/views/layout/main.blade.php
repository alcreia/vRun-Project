<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title'){{ config('app.name') }}</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Scripts -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        @yield('jquery')

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/design.css') }}" rel="stylesheet">
    </head>
    <body>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

        <div id="app">
            <!-- Header -->
            <nav class="navbar navbar-light navbar-expand-md bg-light border-bottom">
                <div class="container">
                    <a class="navbar-brand" href="/"><img src="{{ asset('img/logo.png') }}" width=80px alt="Logo"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navigation">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="/">Home</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="/info">Info</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="/results">Results</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="modal" data-target="#comingSoon">Gallery</a>
                            </li>

                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="modal fade" id="comingSoon" tabindex="-1" role="dialog" aria-labelledby="comingSoonText" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body" id="comingSoonText">
                        Coming Soon :)
                    </div>
                </div>
                </div>
            </div>

            <main>
                @yield('content')
            </main>

            <!-- Footer -->
            <div class="page-footer">
                <footer class="p-4 bg-dark text-light border-top">
                    <div class="row">
                        <div class="links col-md-4">
                            <h5>Halaman</h4>
                            <ul class="list-unstyled">
                                <li><a href="/">Home</a></li>
                                <li><a href="/info">Info</a></li>
                                <li><a href="/results">Results</a></li>
                                <li><a href="#">Gallery</a></li>
                            </ul>
                        </div>
                        <div class="socmed col-md-4">
                            <h5>Kunjungi media sosial kami</h4>
                            <ul class="list-unstyled">
                                <li><a href="https://facebook.com">Facebook</a></li>
                                <li><a href="https://instagram.com">Instagram</a></li>
                                <li><a href="#">Email</a></li>
                            </ul>
                        </div>
                        <div class="sponsor col-md-4">
                            <h5>Event ini disponsori oleh</h5>
                        </div>
                    </div>
                </footer>
                <div class="footer-copyright">
                    <p class="py-1 text-light">©alc.AM 2020</p>
                </div>
            </div>
        </div>
    </body>
</html>
