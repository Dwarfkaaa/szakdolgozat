@extends('layout')


@section('content')
    <link href="{{ asset('/css/register.css') }}" rel="stylesheet" />
    <meta name="viewport" content="width=device-width">

    <div id="logreg-forms">
        <form class="form-signin" action="{{ route('password.email') }}" method="POST">
           @csrf
            <h1 class="h3 mb-3 font-weight-normal" style="text-align: center"> Elfelejtett jelszó</h1><br>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <input id="email" type="email" placeholder="E-mail cím" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')

            <strong>{{ $message }}</strong><br><br><br>

            @enderror

            <button class="btn btn-primary btn-block" type="submit">Elküldés</button>
        </form>
    </div>



@endsection
