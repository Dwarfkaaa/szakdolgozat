<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"> </script>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>


<header style="z-index: 2;">
    <div class="logo">  <nav> Időjárás </nav></div>
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
                            <a class="menupaddingzero" href="#" style="position: relative;padding-left: 50px"><img class="avatarimage"  src="images/avatars/{{Auth::user()->avatar}}" style="width: 32px; height: 32px;left: 10px;position: absolute;top:10px;border-radius: 50%;">
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

<script src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous">

</script>
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



<div class="page page-home" id="page" style="display:block;  background-repeat: no-repeat;  background-attachment: fixed;  background-size: cover;
    background-position: center center; height: auto; min-height: 100vh;
    background-image: url({{asset('images/bg.jpeg')}})">
    <div class="overlay" style="height: 100%; min-height: 100vh">
        <div class="panel panel-time">
            <div class="span time" id="time">
                <script>
                    var time, h, m, s;
                    window.onload = function() { setInterval( timeNow, 100); }
                    function timeNow() {
                        time = new Date();
                        h = time.getHours();
                        m = time.getMinutes();
                        s = time.getSeconds();
                        if (s < 10) {
                            s = "0" + s;
                        }
                        if (m < 10) {
                            m = "0" + m;
                        }
                        if (h < 10) {
                            h = "0" + h;
                        }
                        document.getElementById("time").innerHTML = h + ':' + m;
                    }
                </script>
            </div>

            <div class="span date">
                <script>
                    var d = new Date();
                    var month = d.getMonth()+1;
                    var day = d.getDate();
                    var output = d.getFullYear() + '-' +
                        (month<10 ? '0' : '') + month + '-' +
                        (day<10 ? '0' : '') + day + ', ';
                    document.write(output);
                </script>
                <script>
                    var objToday = new Date(),
                        weekday = new Array('Vasárnap', 'Hétfő', 'Kedd', 'Szerda', 'Csütörtök', 'Péntek', 'Szombat'),
                        dayOfWeek = weekday[objToday.getDay()];
                    document.write(dayOfWeek);
                </script>
            </div>
        </div>
        @yield('content')
    </div>
</div>

