@extends('layout')


@section('content')

    <link href="{{ asset('/css/register.css') }}" rel="stylesheet" />
    <meta name="viewport" content="width=device-width">

    <div id="logreg-forms">
        <form class="form-signin" method="POST" action="{{ route('login') }}">
            @csrf
            <h1 class="h3 mb-3 font-weight-normal" style="text-align: center"> Bejelentkezés</h1>
            <div class="social-login">

            <a href="{{ url('/auth/google') }}" class="col-xl-12 col-lg-12 col-md-12 col-sm-12" id="login">
                    <button class="btn google-btn social-btn" type="button"><span>Bejelentkezés Google+ fiókkal</span> </button>
            </a>

            </div>
            <p style="text-align:center"> VAGY  </p>
            <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email-cím" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
            <strong>{{ $message }}</strong>
            @enderror


            <input type="password" id="password" class="form-control  @error('password') is-invalid @enderror" placeholder="Jelszó" name="password" required autocomplete="current-password">

            @error('password')
            <strong>{{ $message }}</strong>

            @enderror

            <button class="btn btn-success btn-block" type="submit">Bejelentkezés</button>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    Elfelejtetted a jelszavad?
                </a>
            @endif
            <hr>
            <!-- <p>Don't have an account!</p>  -->
            <button class="btn btn-primary btn-block" type="button" id="btn-signup"> Regisztráció</button>
        </form>

        <form action="/reset" class="form-reset">
            <input type="email" id="resetEmail" class="form-control" placeholder="E-mail cím" required="" autofocus="">
            <button class="btn btn-primary btn-block" type="submit">Jelszó megújítása</button>
            <a href="#" id="cancel_reset"> Vissza</a>
        </form>

        <form action="{{ route('register') }}" method="POST" class="form-signup">
            @csrf
            <h1 class="h3 mb-3 font-weight-normal" style="text-align: center"> Regisztráció</h1>

            <input type="text" id="name" class="form-control  @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Felhasználónév" required autocomplete="name" autofocus>
                    @error('name')
                     <strong>{{ $message }}</strong>
                    @enderror

            <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email-cím" required autocomplete="name" autofocus>
                    @error('email')
                    <strong>{{ $message }}</strong>
                    @enderror
            <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Jelszó" required autocomplete="name" autofocus>
                    @error('password')
                    <strong>{{ $message }}</strong>
                    @enderror
            <input type="password" id="password-confirm" class="form-control" placeholder="Jelszó megerősítése" name="password_confirmation" required autocomplete="new-password">

            <button class="btn btn-primary btn-block" type="submit"> Regisztráció</button>
            <a href="#" id="cancel_signup">Vissza</a>
        </form>
        <br>

    </div>


    <script>
        function toggleResetPswd(e){
            e.preventDefault();
            $('#logreg-forms .form-signin').toggle() // display:block or none
            $('#logreg-forms .form-reset').toggle() // display:block or none
        }

        function toggleSignUp(e){
            e.preventDefault();
            $('#logreg-forms .form-signin').toggle(); // display:block or none
            $('#logreg-forms .form-signup').toggle(); // display:block or none
        }

        $(()=>{
            // Login Register Form
            $('#logreg-forms #forgot_pswd').click(toggleResetPswd);
            $('#logreg-forms #cancel_reset').click(toggleResetPswd);
            $('#logreg-forms #btn-signup').click(toggleSignUp);
            $('#logreg-forms #cancel_signup').click(toggleSignUp);
        })
    </script>


@endsection
