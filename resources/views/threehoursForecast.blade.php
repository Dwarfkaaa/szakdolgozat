@extends('layout')


<!--  ha nem létezik a város-->
@if(!isset($body))

    @section('content')

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <meta name="viewport" content="width=device-width">
        <link href="{{ asset('/css/style.css') }}" rel="stylesheet" />

        <div class="overlay">
            <div class="SearchWrapper">
                <form class="searchbox" class="typeahead form-control"  action="/threehoursForecast" method="post" autocomplete="off" >
                    {{csrf_field()}}
                    <input  type="text" name="search" value="{{$closest}}" placeholder="Írj be egy települést.."  required/>
                    <button type="submit" name="search2" value="{{$closest}}" >Keresés</button>
                </form>
            </div>
            <div class="col" style="top:50%;">
                <p class="hibasvaros" style="text-align: center; color:white">  Esetleg erre gondoltál: {{$closest}} ? <br><br><br>
                    Előfordulhat, hogy az általad és általunk megadott városról nincs adat.</p>
            </div>
        </div>
        <div class="panel panel-functions"></div>

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

<!-- ha létezik a város-->
@else(isset($body))

    @section('content')
        <link href="{{ asset('/css/style.css') }}" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <meta name="viewport" content="width=device-width">

        <!-- search box-->
        <div class="bg"></div>
        <div class="overlay">
            <div class="SearchWrapper">
                <form class="searchbox" class="typeahead form-control"  action="/threehoursForecast" method="post" autocomplete="off">
                    {{csrf_field()}}
                    <input  type="text" name="search" placeholder="Írj be egy települést.." required />
                    <button type="submit" name="search2" >Keresés</button>
                </form>
            </div>
        </div>

        <div  class="panel panel-weather" id="felhozet">
            <div class="location">{{$kiiratasCurrent}}</div>
            <img class="threehoursikon" src="{{$ikonCurrent}}">
            <div class="span temp">{{$tempCurrent}}<span class="degree">&deg;C</span></div>
            <div class="span text"> {{$description}}</div>
            <div class="highcharts" id="felho" style="height: 70%; width: 100%"></div>
            <script>
                document.addEventListener('DOMContentLoaded', () =>{
                    Highcharts.chart('felho',{
                        chart: {
                            type: 'column',
                            backgroundColor: 'transparent'

                        },
                        colors: ['rgb( 117, 120, 118)'],
                        title: '',
                        tooltip:{
                            color: '#ffffff',
                            borderColor: 'rgb(0,0,0)',
                            borderRadius:20,
                            followPointer: true,
                            style: {
                                fontWeight: "bold",
                                fontSize: "14px"
                            }
                        },
                        yAxis:{
                            labels: {
                                style: {
                                    fontSize: '18px',
                                    color: 'white',
                                    fontWeight: "bold"
                                }
                            },
                            title:{
                                style: {
                                    fontWeight: "bold",
                                    fontSize: "16px",
                                    color: "white"
                                },
                                text: 'Százalék'
                            }
                        },
                        xAxis: {
                            labels: {
                                style: {
                                    fontSize: '18px',
                                    color: 'white',
                                    fontWeight: "bold"
                                }
                            },
                            categories: ["{{$threehoursArray[0]}}", "{{$threehoursArray[1]}}", "{{$threehoursArray[2]}}", "{{$threehoursArray[3]}}", "{{$threehoursArray[4]}}", "{{$threehoursArray[5]}}",
                                "{{$threehoursArray[6]}}", "{{$threehoursArray[7]}}", "{{$threehoursArray[8]}}", "{{$threehoursArray[9]}}"],
                            title: {
                                text: "Idő",
                                style: {
                                    fontWeight: "bold",
                                    fontSize: "16px",
                                    color: "white"
                                }
                            }
                        },
                        responsive: {
                            rules: [
                                {
                                    condition: {
                                        maxWidth: 600
                                    },
                                    chartOptions: {
                                        xAxis: {
                                            labels: {
                                                style: {
                                                    fontSize: '8px',
                                                    color: 'white',
                                                    fontWeight: "bold"
                                                }
                                            }
                                        },
                                        yAxis: {
                                            labels: {
                                                enabled: false
                                            }
                                        },
                                        legend: {
                                            itemStyle:{
                                                fontSize: "14px"
                                            }
                                        },
                                    },
                                },
                                {
                                    condition: {
                                        minWidth: 601,
                                    },
                                    chartOptions: {
                                        xAxis: {
                                            labels: {
                                                enabled: true
                                            }
                                        },
                                        yAxis: {
                                            labels: {
                                                enabled: true
                                            }
                                        },
                                        legend: {
                                            itemStyle:{
                                                fontSize: "18px"
                                            }
                                        },
                                    }
                                }
                            ],
                        },
                        legend: {
                            itemStyle: {
                                fontSize: "20px",
                                color: "#ffffff"
                            }
                        },
                        series:[
                            {
                                name: 'Felhőzet mértéke',
                                data: [{{$cloudsArray[0]}} ,{{$cloudsArray[1]}}, {{$cloudsArray[2]}}, {{$cloudsArray[3]}}, {{$cloudsArray[4]}}, {{$cloudsArray[5]}},
                                    {{$cloudsArray[6]}} ,{{$cloudsArray[7]}}, {{$cloudsArray[8]}}, {{$cloudsArray[9]}}],
                                lineWidth: 3
                            }
                        ]
                    });
                });
            </script>
        </div> <!-- egesz div bezar-->

        <div  class="panel panel-weather" id="szel">
            <div class="location">{{$kiiratasCurrent}}</div>
            <img class="threehoursikon" src="{{$ikonCurrent}}">
            <div class="span temp">{{$tempCurrent}}<span class="degree">&deg;C</span></div>
            <div class="span text"> {{$description}}</div>
            <div class="highcharts" id="sz" style="height: 70%; width: 100%"></div>
            <script>
                document.addEventListener('DOMContentLoaded', () =>{
                    Highcharts.chart('sz',{
                        chart: {
                            type: 'column',
                            backgroundColor: 'transparent'
                        },
                        colors: ['rgb( 249, 255, 232)'],
                        title: '',
                        tooltip:{
                            color: '#ffffff',
                            borderColor: 'rgb(0,0,0)',
                            borderRadius:20,
                            followPointer: true,
                            style: {
                                fontWeight: "bold",
                                fontSize: "14px"
                            }
                        },
                        yAxis:{
                            labels: {
                                style: {
                                    fontSize: '18px',
                                    color: 'white',
                                    fontWeight: "bold"
                                }
                            },
                            title:{
                                style: {
                                    fontWeight: "bold",
                                    fontSize: "16px",
                                    color: "white"
                                },
                                text: 'km/h'
                            }
                        },
                        xAxis: {
                            labels: {
                                style: {
                                    fontSize: '18px',
                                    color: 'white',
                                    fontWeight: "bold"
                                }
                            },
                            categories: ["{{$threehoursArray[0]}}", "{{$threehoursArray[1]}}", "{{$threehoursArray[2]}}", "{{$threehoursArray[3]}}", "{{$threehoursArray[4]}}", "{{$threehoursArray[5]}}",
                                "{{$threehoursArray[6]}}", "{{$threehoursArray[7]}}", "{{$threehoursArray[8]}}", "{{$threehoursArray[9]}}"],
                            title: {
                                text: "Idő",
                                style: {
                                    fontWeight: "bold",
                                    fontSize: "16px",
                                    color: "white"
                                }
                            }
                        },
                        responsive: {
                            rules: [
                                {
                                    condition: {
                                        maxWidth: 600
                                    },
                                    chartOptions: {
                                        xAxis: {
                                            labels: {
                                                style: {
                                                    fontSize: '8px',
                                                    color: 'white',
                                                    fontWeight: "bold"
                                                }
                                            }
                                        },
                                        yAxis: {
                                            labels: {
                                                enabled: false
                                            }
                                        },
                                        legend: {
                                            itemStyle:{
                                                fontSize: "14px"
                                            }
                                        },
                                    },
                                },
                                {
                                    condition: {
                                        minWidth: 601
                                    },
                                    chartOptions: {
                                        xAxis: {
                                            labels: {
                                                enabled: true
                                            }
                                        },
                                        yAxis: {
                                            labels: {
                                                enabled: true
                                            }
                                        },
                                        legend: {
                                            itemStyle:{
                                                fontSize: "18px"
                                            }
                                        },
                                    }
                                }
                            ],
                        },
                        legend: {
                            itemStyle: {
                                fontSize: "20px",
                                color: "#ffffff"
                            }
                        },
                        series:[
                            {
                                name: 'Szélsebesség',
                                data: [{{$windArray[0]}} ,{{$windArray[1]}}, {{$windArray[2]}}, {{$windArray[3]}}, {{$windArray[4]}}, {{$windArray[5]}},
                                    {{$windArray[6]}} ,{{$windArray[7]}}, {{$windArray[8]}}, {{$windArray[9]}}],
                                lineWidth: 3
                            }
                        ]
                    });
                });
            </script>
        </div> <!-- egesz div bezar-->

        <div  class="panel panel-weather" id="szelirany">
            <div class="location">{{$kiiratasCurrent}}</div>
            <img class="threehoursikon" src=" {{$ikonCurrent}}">
            <div class="span temp">{{$tempCurrent}}<span class="degree">&deg;C</span></div>
            <div class="span text"> {{$description}}</div>
            <div class="wrapper" id="szeliranywrapper">
                <div>{{$threehoursSubstrArray[0]}} <br> <img class="szeliranyharomorasikon" src="{{$szeliranyArray[0]}}"> </div>
                <div>{{$threehoursSubstrArray[1]}} <br>  <img class="szeliranyharomorasikon" src="{{$szeliranyArray[1]}}">  </div>
                <div>{{$threehoursSubstrArray[2]}} <br>  <img class="szeliranyharomorasikon" src="{{$szeliranyArray[2]}}"> </div>
                <div>{{$threehoursSubstrArray[3]}} <br> <img class="szeliranyharomorasikon" src="{{$szeliranyArray[3]}}">  </div>
                <div>{{$threehoursSubstrArray[4]}} <br> <img class="szeliranyharomorasikon" src="{{$szeliranyArray[4]}}">   </div>
                <div>{{$threehoursSubstrArray[5]}} <br>  <img class="szeliranyharomorasikon" src="{{$szeliranyArray[5]}}">  </div>
            </div>
         </div> <!-- egesz div bezar-->

        <div  class="panel panel-weather" id="fahrenheit">
            <div class="location">{{$kiiratasCurrent}}</div>
            <img class="threehoursikon" src=" {{$ikonCurrent}}">
            <div class="span temp">{{$temperatureFahrenheitMax1}}<span class="degree">&deg;F</span></div>
            <div class="span text"> {{$description}}</div>
            <div class="highcharts" id="fahren" style="height: 100%; width: 100%"></div>
            <script>
                document.addEventListener('DOMContentLoaded', () =>{
                    Highcharts.chart('fahren',{
                        chart: {
                            type: 'areaspline',
                            backgroundColor: 'transparent'
                        },
                        title: '',
                        colors: ['#FF8C00','#1e90ff'],
                        tooltip:{
                            color: '#ffffff',
                            borderColor: '#00BFFF',
                            borderRadius:20,
                            followPointer: true,
                            style: {
                                fontWeight: "bold",
                                fontSize: "14px"
                            }
                        },
                        yAxis:{
                            labels: {
                                style: {
                                    fontSize: '18px',
                                    color: 'white',
                                    fontWeight: "bold"
                                }
                            },
                            title:{
                                style: {
                                    fontWeight: "bold",
                                    fontSize: "16px",
                                    color: "white"
                                },
                                text: 'Fahrenheit'
                            }
                        },
                        xAxis: {
                            labels: {
                                style: {
                                    fontSize: '18px',
                                    color: 'white',
                                    fontWeight: "bold"
                                }
                            },
                            categories: ["{{$threehoursArray[0]}}", "{{$threehoursArray[1]}}", "{{$threehoursArray[2]}}", "{{$threehoursArray[3]}}", "{{$threehoursArray[4]}}", "{{$threehoursArray[5]}}",
                                "{{$threehoursArray[6]}}", "{{$threehoursArray[7]}}", "{{$threehoursArray[8]}}", "{{$threehoursArray[9]}}"],
                            title: {
                                text: "Idő",
                                style: {
                                    fontWeight: "bold",
                                    fontSize: "16px",
                                    color: "white"
                                }
                            }
                        },
                        responsive: {
                            rules: [
                                {
                                    condition: {
                                        maxWidth: 600
                                    },
                                    chartOptions: {
                                        xAxis: {
                                            labels: {
                                                enabled: false
                                            }
                                        },
                                        yAxis: {
                                            labels: {
                                                enabled: false
                                            }
                                        },
                                        legend: {
                                            itemStyle:{
                                                fontSize: "14px"
                                            }
                                        },
                                    },
                                },
                                {
                                    condition: {
                                        minWidth: 601,
                                    },
                                    chartOptions: {
                                        xAxis: {
                                            labels: {
                                                enabled: true
                                            }
                                        },
                                        yAxis: {
                                            labels: {
                                                enabled: true
                                            }
                                        },
                                        legend: {
                                            itemStyle:{
                                                fontSize: "18px"
                                            }
                                        },
                                    }
                                }
                            ],
                        },
                        legend: {
                            itemStyle: {
                                fontSize: "20px",
                                color: "#ffffff"
                            }
                        },
                        series:[
                            {
                                name: 'Maximum hőmérséklet',
                                data: [{{$temperatureFahrenheitMax1}},{{$temperatureFahrenheitMax2}},
                                    {{$temperatureFahrenheitMax3}},{{$temperatureFahrenheitMax4}},{{$temperatureFahrenheitMax5}}
                                ,{{$temperatureFahrenheitMax6}},{{$temperatureFahrenheitMax7}},{{$temperatureFahrenheitMax8}},{{$temperatureFahrenheitMax9}},
                                    {{$temperatureFahrenheitMax10}}],
                                lineWidth: 3
                            }
                        ]
                    });
                });
            </script>
        </div>
        <div  class="panel panel-weather" id="homerseklet">
            <div class="location">{{$kiiratasCurrent}}</div>
            <!--.icon.wi.wi-day-sunny-overcast--><img class="threehoursikon" src=" {{$ikonCurrent}}">
            <div class="span temp">{{$tempCurrent}}<span class="degree">&deg;C</span></div>
            <div class="span text"> {{$description}}</div>
            <div class="highcharts" id="hom" style="height: 70%; width: 100%"></div>
            <script>
                document.addEventListener('DOMContentLoaded', () =>{
                    Highcharts.chart('hom',{
                        chart: {
                            type: 'areaspline',
                            backgroundColor: 'transparent'
                        },
                        title: '',
                        colors: ['#FF8C00','#1e90ff'],
                        tooltip:
                            {
                            color: '#ffffff',
                            borderColor: '#00BFFF',
                            borderRadius:20,
                            followPointer: true,
                            style: {
                                fontWeight: "bold",
                                fontSize: "14px"
                            }
                        },
                        yAxis:{
                            labels: {
                                style: {
                                    fontSize: '18px',
                                    color: 'white',
                                    fontWeight: "bold"
                                }
                            },
                            title:{
                                style: {
                                    fontWeight: "bold",
                                    fontSize: "16px",
                                    color: "white"
                                },
                                text: 'Celsius'
                            }
                        },
                        xAxis: {
                            labels: {
                                style: {
                                    fontSize: '18px',
                                    color: 'white',
                                    fontWeight: "bold"
                                }
                            },
                            categories: ["{{$threehoursArray[0]}}", "{{$threehoursArray[1]}}", "{{$threehoursArray[2]}}", "{{$threehoursArray[3]}}", "{{$threehoursArray[4]}}", "{{$threehoursArray[5]}}",
                                "{{$threehoursArray[6]}}", "{{$threehoursArray[7]}}", "{{$threehoursArray[8]}}", "{{$threehoursArray[9]}}"],
                            title: {
                                text: "Idő",
                                style: {
                                    fontWeight: "bold",
                                    fontSize: "16px",
                                    color: "white"
                                }
                            }
                        },
                        responsive: {
                            rules: [
                                {
                                    condition: {
                                        maxWidth: 600
                                    },
                                    chartOptions: {
                                        xAxis: {
                                            labels: {
                                                enabled: false
                                            }
                                        },
                                        yAxis: {
                                            labels: {
                                                enabled: false
                                            }
                                        },
                                        legend: {
                                            itemStyle:{
                                                fontSize: "14px"
                                            }
                                        },
                                    },
                                },
                                {
                                    condition: {
                                        minWidth: 601,
                                    },
                                    chartOptions: {
                                        xAxis: {
                                            labels: {
                                                enabled: true
                                            }
                                        },
                                        yAxis: {
                                            labels: {
                                                enabled: true
                                            }
                                        },
                                        legend: {
                                            itemStyle:{
                                                fontSize: "18px"
                                            }
                                        },
                                    }
                                }
                            ],
                        },
                        legend: {
                            itemStyle: {
                                fontSize: "20px",
                                color: "#ffffff"
                            }
                        },
                        series:[
                            {
                                name: 'Maximum hőmérséklet',
                                data: [{{$tempArray[0]}} ,{{$tempArray[1]}}, {{$tempArray[2]}}, {{$tempArray[3]}}, {{$tempArray[4]}}, {{$tempArray[5]}},
                                    {{$tempArray[6]}} ,{{$tempArray[7]}}, {{$tempArray[8]}}, {{$tempArray[9]}}],
                                lineWidth: 3
                            }
                        ]
                    });
                });
            </script>
        </div>

        <!-- footer -->
        <div class="panel panel-functions">
            <div class=""><button id="expand1" name="expand1"  style="border: none; background: none;"> <img class="ikonmeretelorejelzes" src="{{URL::asset('/images/celsiustemp.svg')}}">  </button></div>
            <div class=""><button id="expand2" name="expand2" style="border: none; background: none;"> <img class="ikonmeretelorejelzes" src="{{URL::asset('/images/fahrenheittemp.png')}}">  </button></div>
            <div class=""><button id="expand3" name="expand3" style="border: none; background: none;"> <img  class="ikonmeretelorejelzes" src="{{URL::asset('/images/cloud.png')}}">  </button></div>
            <div class=""><button id="expand4" name="expand4"  style="border: none; background: none; "> <img  class="ikonmeretelorejelzes" src="{{URL::asset('/images/wind.png')}}" >  </button></div>
            <div class=""><button id="expand5" name="expand5"  style="border: none; background: none; "> <img class="ikonmeretelorejelzes" src="{{URL::asset('/images/compass.png')}}">  </button></div>
        </div>


        <!-- Div Selector -->
        <script>
            $('#felhozet').hide();
            $('#fahrenheit').hide();
            $('#szel').hide();
            $('#szelirany').hide();
            $('#homerseklet').show();

            document.getElementById("expand3").addEventListener("click", function()
            {
                if(document.getElementById('felhozet').style.display == 'block'){
                      document.getElementById('szel').style.display = 'none';
                        document.getElementById('homerseklet').style.display = 'none';
                        document.getElementById('fahrenheit').style.display = 'none';
                        document.getElementById('szelirany').style.display = 'none';
                }
             else
                    document.getElementById('felhozet').style.display = 'block';
                    document.getElementById('szel').style.display = 'none';
                    document.getElementById('homerseklet').style.display = 'none';
                    document.getElementById('fahrenheit').style.display = 'none';
                    document.getElementById('szelirany').style.display = 'none';
            });
            document.getElementById("expand2").addEventListener("click", function()
            {
                if(document.getElementById('fahrenheit').style.display == 'block'){
                    document.getElementById('felhozet').style.display = 'none';
                    document.getElementById('homerseklet').style.display = 'none';
                    document.getElementById('szel').style.display = 'none';
                    document.getElementById('szelirany').style.display = 'none';

                }
                else
                    document.getElementById('fahrenheit').style.display = 'block';
                    document.getElementById('homerseklet').style.display = 'none';
                    document.getElementById('felhozet').style.display = 'none';
                    document.getElementById('szel').style.display = 'none';
                    document.getElementById('szelirany').style.display = 'none';
            });
            document.getElementById("expand1").addEventListener("click", function()
            {
                if(document.getElementById('homerseklet').style.display == 'block'){
                    document.getElementById('felhozet').style.display = 'none';
                    document.getElementById('szel').style.display = 'none';
                    document.getElementById('fahrenheit').style.display = 'none';
                    document.getElementById('szelirany').style.display = 'none';
                }
                else
                    document.getElementById('homerseklet').style.display = 'block';
                    document.getElementById('szel').style.display = 'none';
                    document.getElementById('felhozet').style.display = 'none';
                    document.getElementById('fahrenheit').style.display = 'none';
                    document.getElementById('szelirany').style.display = 'none';
            });
            document.getElementById("expand4").addEventListener("click", function()
            {
                if(document.getElementById('szel').style.display == 'block'){
                    document.getElementById('felhozet').style.display = 'none';
                    document.getElementById('homerseklet').style.display = 'none';
                    document.getElementById('fahrenheit').style.display = 'none';
                    document.getElementById('szelirany').style.display = 'none';

                }
                else
                    document.getElementById('szel').style.display = 'block';
                    document.getElementById('homerseklet').style.display = 'none';
                    document.getElementById('felhozet').style.display = 'none';
                    document.getElementById('fahrenheit').style.display = 'none';
                    document.getElementById('szelirany').style.display = 'none';
            });
            document.getElementById("expand5").addEventListener("click", function()
            {
                if(document.getElementById('szelirany').style.display == 'block'){
                    document.getElementById('felhozet').style.display = 'none';
                    document.getElementById('homerseklet').style.display = 'none';
                    document.getElementById('fahrenheit').style.display = 'none';
                    document.getElementById('szel').style.display = 'none';
                }
                else
                    document.getElementById('szelirany').style.display = 'block';
                    document.getElementById('homerseklet').style.display = 'none';
                    document.getElementById('felhozet').style.display = 'none';
                    document.getElementById('fahrenheit').style.display = 'none';
                    document.getElementById('szel').style.display = 'none';
            });
            <!-- page-scrolldown -->
            $(document).ready(function(){
                $('body,html').animate({scrollTop: 206}, 800);
            });

        </script>

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
@endif
