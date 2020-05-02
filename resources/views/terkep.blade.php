
@extends('layout')


@section('content')


    <link href="{{ asset('/css/style.css') }}" rel="stylesheet" />
    <meta name="viewport" content="width=device-width">
    <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/leaflet/leaflet.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/leaflet/leaflet-openweathermap.css') }}" />

    <script src="{{ URL::asset('js/leaflet.js') }}"></script>
    <script src="{{ URL::asset('js/leaflet-openweathermap.js') }}"></script>
    <script src="{{ URL::asset('js/map_i18n.js') }}"></script>
    <script src="{{ URL::asset('js/map.js') }}"></script>


    <style>
        .page .overlay {
            background-color: rgba(0, 233, 233, 0.1) !important;

        }
    </style>

    <div class="overlay">


            <div id="map"></div>
            <script>
                initMap();

            </script>





    </div>

    <div class="panel panel-functions">

    </div>





@endsection
