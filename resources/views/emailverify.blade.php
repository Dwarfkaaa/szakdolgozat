@extends('layout')


@section('content')
    <link href="{{ asset('/css/register.css') }}" rel="stylesheet" />
    <meta name="viewport" content="width=device-width">
    <div id="logreg-forms">
        <form class="form-signin" method="GET" action="{{ route('verification.resend') }}">
            @csrf
            <h4 style="text-align: center"> E-mail megerősítés</h4><br>
            <h3 style="text-align: center"> Erősítsd meg az E-mail címed</h3>
            <button class="btn btn-success btn-block" type="submit">E-mail küldése / Újraküldés</button>
        </form>
    </div>
@endsection
