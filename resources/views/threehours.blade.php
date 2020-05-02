
@extends('layout')


@section('content')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet" />
    <meta name="viewport" content="width=device-width">

    <!--search box -->
    <div class="bg"></div>
    <div class="overlay">
        <div class="SearchWrapper">
            <form class="searchbox" class="typeahead form-control"  action="/threehoursForecast" method="post" autocomplete="off" >
                {{csrf_field()}}
                <input  type="text" name="search" placeholder="Írj be egy települést.."  required/>
                <button type="submit" name="search2" >Keresés</button>
            </form>
        </div>
    </div>
    <div class="panel panel-functions"></div>

    <!-- autocomplete -->
    <script type="text/javascript">
        var path ="{{route('autocomplete')}}";
        $('input').typeahead({
            source:function (query,process) {
                return $.get(path,{query:name}, function (data) {
                    return process(data);
                });
            }
        });
    </script>

@endsection
