@extends('layout')


@section('content')
    <link href="{{ asset('/css/register.css') }}" rel="stylesheet" />
    <meta name="viewport" content="width=device-width">
    <div id="logreg-forms">
        <form class="form-signin" action="{{ route('password.email') }}" method="POST">
            @csrf
            <h1 class="h3 mb-3 font-weight-normal" style="text-align: center"> E-mail megerősítés</h1><br>
            <h4 class="h3 mb-3 font-weight-normal" style="text-align: center"> Erősítsd meg az E-mail címed</h4>
            <input id="email" type="email" placeholder="E-mail cím" class="input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
            <strong>{{ $message }}</strong><br><br><br>
            @enderror
            <button class="btn btn-success btn-block" type="submit">Új jelszó küldése</button>
        </form>
    </div>
@endsection
