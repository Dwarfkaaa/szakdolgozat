<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="display:block;  background-repeat: repeat;  background-attachment: fixed;  background-size: cover;
    background-position: center center; height: auto; min-height: 100vh;
    background-image: url({{asset('images/bg.jpeg')}});">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"> </script>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="{{ asset('/css/appbladekiegeszites.css') }}" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"></script>
    <script type="text/javascript">

        $(document).ready(function(){
            $('.menu-toggle').click(function(){
                $('nav').toggleClass('active')
            })

            $('ul li').click(function(){
                $(this).siblings().removeClass('active');
                $(this).toggleClass('active');
            })
        })


    </script>


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('css')

</head>
<body>
<style>
.p{
    color: white !important;
}
</style>
    <div id="app" >
        <header>
            <div class="logo">  <nav> Időjárás </nav>
            </div>
            <nav>
                <ul>
                    <li><a href="/">Kezdőlap</a></li>

                    <li class="sub-menu"><a href="#">Előrejelzés</a>
                        <ul>
                            <li><a href="/budapest">Budapest</a></li>
                            <li><a href="/debrecen">Debrecen</a></li>
                            <li><a href="/pecs">Pécs</a></li>
                            <li><a href="/sopron">Sopron</a></li>
                            <li><a href="/szeged">Szeged</a></li>
                            <li><a href="/threehours">3 óránkénti</a></li>
                            <li><a href="/fivedays">5 napos</a></li>

                        </ul>
                    </li>
                    <li><a href="/map">Térkép</a></li>
                    <li><a href="/gallery">Galéria</a></li>
                    <li><a href="/forums">Fórum</a></li>


                    @guest
                        <li class="nav-item">
                            <a class="" href="{{ route('login') }}">Bejelentkezés</a>
                        </li>

                    @else

                        <li class="sub-menu">

                            <a href="#" class="avatarmenu2" style=" position: relative;padding-left: 50px"><img class="avatar" src="images/avatars/{{Auth::user()->avatar}}" style="width: 32px; height: 32px;left: 10px;position: absolute;top:10px;border-radius: 50%;">
                                {{ Auth::user()->name }}</a>

                            <ul>
                                <a href="{{ url('/profile')  }}">
                                    Profilom
                                </a>
                                <a href="{{ url('/galleryupload')  }}">
                                    Képfeltöltés
                                </a>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Kijelentkezés
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                </form>
                            </ul>

                        </li>
                    @endguest




                </ul>
            </nav>
            <div class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>

        </header>


        <main style="">
            @yield('content')
        </main>
    </div>
    @yield('js')
</body>
</html>
