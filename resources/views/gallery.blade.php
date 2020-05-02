
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="{{ asset('/css/gallery.css') }}" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"> </script>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>




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
                    <a href="#" class="avatarmenu2"  style="position: relative;padding-left: 50px"><img class="avatarmenu"  src="images/avatars/{{Auth::user()->avatar}}" style="width: 32px; height: 32px;left: 10px;position: absolute;top:10px;border-radius: 50%;">
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


<div class="page page-home" id="page" style="display:block;  background-repeat: no-repeat;  background-attachment: fixed;  background-size: cover;
    background-position: center center; height: auto; min-height: 100vh;
    background-image: url({{asset('images/bg.jpeg')}})">
    <div class="overlay" style="height: auto; min-height: 100vh">

        <section id="gallery">
            <div class="container">
                <div id="image-gallery">
                    <div class="row">

                        @foreach ($posts as $post)


                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 image" style="padding-top: 5%">
                                <div class="img-wrapper" >
                                    <a href="/images/galeries/{{$post->image}}"><img src="/images/galeries/{{$post->image}}" class="img-responsive"></a>
                                    <div class="img-overlay">
                                        <i>{{$post->description}}</i><br>
                                    </div>
                                </div>
                                    <div class="szoveg" style="text-align: center; color: white">
                                        <p class="float-center">
                                        <i class="fa fa-thumbs-up fa-lg" style="color: deepskyblue" aria-hidden="true"><b> {{$post->likes()->count()}}</b></i>
                                        <i class="fa fa-thumbs-down fa-lg" style="color: orangered" aria-hidden="true"><b> {{$post->dislikes()->count()}}</b></i></p><br>
                                        <p style="text-align: center"><i><b>Feltöltötte: {{$post->name}}</b></i></p>

                                        <p><i><b>{{$post->created_at}}</b></i></p>
                                    </div>
                                @if(Auth::check())
                                    <div class="post" data-postid="{{ $post->id }}" style="padding-bottom: 25%">
                                        <div class="intedraction">
                                            <a href="#" class="btn btn-primary active like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 1 ? 'You like this post' : 'Like' : 'Like'  }}</a>
                                            <a href="#" class="btn btn-xs btn-danger like" id="dislike" >{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 0 ? 'You dont like this post' : 'Dislike' : 'Dislike'  }}</a>
                                        </div>

                                    </div>

                                @endif
                            </div>
                        @endforeach

                    </div><!-- End row -->
                </div><!-- End image gallery -->
            </div><!-- End container -->
        </section>
    </div><!--overlay bezar -->
</div><!-- egesz div bezar-->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous">
</script>

<script>
    var postId = 0;
    $('.like').on('click', function(event) {
        event.preventDefault();
        postId = event.target.parentNode.parentNode.dataset['postid'];
        var isLike = event.target.previousElementSibling == null;
        $.ajax({
            method: 'POST',
            url: urlLike,
            data: {isLike: isLike, postId: postId, _token: token}
        })
            .done(function() {
                event.target.innerText = isLike ? event.target.innerText == 'Like' ? 'You like this post' : 'Like' : event.target.innerText == 'Dislike' ? 'You dont like this post' : 'Dislike';
                if (isLike) {
                    event.target.nextElementSibling.innerText = 'Dislike';
                } else {
                    event.target.previousElementSibling.innerText = 'Like';
                }
            });
    });
    var token = '{{ Session::token() }}';
    var urlLike = '{{ route('like') }}';
</script>
<script type="text/javascript">

    // Gallery image hover
    $( ".img-wrapper" ).hover(
        function() {
            $(this).find(".img-overlay").animate({opacity: 1}, 600);
        }, function() {
            $(this).find(".img-overlay").animate({opacity: 0}, 600);
        }
    );

    // Lightbox
    var $overlay = $('<div id="overlay"></div>');
    var $image = $("<img>");
    var $prevButton = $('<div id="prevButton"><i class="fa fa-chevron-left"></i></div>');
    var $nextButton = $('<div id="nextButton"><i class="fa fa-chevron-right"></i></div>');
    var $exitButton = $('<div id="exitButton"><i class="fa fa-times"></i></div>');

    // Add overlay
    $overlay.append($image).prepend($prevButton).append($nextButton).append($exitButton);
    $("#gallery").append($overlay);

    // Hide overlay on default
    $overlay.hide();

    // When an image is clicked
    $(".img-overlay").click(function(event) {
        // Prevents default behavior
        event.preventDefault();
        // Adds href attribute to variable
        var imageLocation = $(this).prev().attr("href");
        // Add the image src to $image
        $image.attr("src", imageLocation);
        // Fade in the overlay
        $overlay.fadeIn("slow");
    });

    // When the overlay is clicked
    $overlay.click(function() {
        // Fade out the overlay
        $(this).fadeOut("slow");
    });

    // When next button is clicked
    $nextButton.click(function(event) {
        // Hide the current image
        $("#overlay img").hide();
        // Overlay image location
        var $currentImgSrc = $("#overlay img").attr("src");
        // Image with matching location of the overlay image
        var $currentImg = $('#image-gallery img[src="' + $currentImgSrc + '"]');
        // Finds the next image
        var $nextImg = $($currentImg.closest(".image").next().find("img"));
        // All of the images in the gallery
        var $images = $("#image-gallery img");
        // If there is a next image
        if ($nextImg.length > 0) {
            // Fade in the next image
            $("#overlay img").attr("src", $nextImg.attr("src")).fadeIn(800);
        } else {
            // Otherwise fade in the first image
            $("#overlay img").attr("src", $($images[0]).attr("src")).fadeIn(800);
        }
        // Prevents overlay from being hidden
        event.stopPropagation();
    });

    // When previous button is clicked
    $prevButton.click(function(event) {
        // Hide the current image
        $("#overlay img").hide();
        // Overlay image location
        var $currentImgSrc = $("#overlay img").attr("src");
        // Image with matching location of the overlay image
        var $currentImg = $('#image-gallery img[src="' + $currentImgSrc + '"]');
        // Finds the next image
        var $nextImg = $($currentImg.closest(".image").prev().find("img"));
        // Fade in the next image
        $("#overlay img").attr("src", $nextImg.attr("src")).fadeIn(800);
        // Prevents overlay from being hidden
        event.stopPropagation();
    });

    // When the exit button is clicked
    $exitButton.click(function() {
        // Fade out the overlay
        $("#overlay").fadeOut("slow");
    });


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
</html>
