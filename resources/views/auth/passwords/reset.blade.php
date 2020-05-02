
@extends('layout')


@section('content')
    <link href="{{ asset('/css/register.css') }}" rel="stylesheet" />
    <meta name="viewport" content="width=device-width">
    <div id="logreg-forms">
        <form class="form-signin" method="POST" action="{{ route('password.update') }}">
            @csrf
            <h1 class="h3 mb-3 font-weight-normal" style="text-align: center"> Új jelszó beállítása</h1>
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
            @error('email')
            <strong>{{ $message }}</strong>
            @enderror
            <input type="password" id="password" class="form-control  @error('password') is-invalid @enderror" placeholder="Jelszó" name="password" required autocomplete="current-password">
            @error('password')
            <strong>{{ $message }}</strong>
            @enderror
            <input type="password" id="password-confirm" class="form-control" placeholder="Jelszó megerősítése" name="password_confirmation" required autocomplete="new-password">
            <button class="btn btn-success btn-block" type="submit">Új jelszó beállítása</button>
        </form>
    </div>
@endsection
