@extends('layout')

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>    <meta name="viewport" content="width=device-width">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet" />

        <div class="overlay">
            <div class="SearchWrapper">
                <form class="searchbox" class="typeahead form-control"  action="/current" method="post" autocomplete="off" >
                    {{csrf_field()}}
                    <input  type="text" name="search" placeholder="Írj be egy települést.."  required/>
                    <button type="submit" name="search2" >Keresés</button>
                </form>
            </div>
        </div>

    <!-- adatok listázása Fahrenheit-ben-->
    <div class="panel panel-weather"  id="locationFahren">
        <div class="location"><b>{{$name}}</b></div>
        <img class="kezdolapikon" src=" {{$ikon}}">
        <div class="span temp">{{$tempCurrentFahrenheit}}<span class="degree">&deg;F</span></div>
        <div class="span text">{{$description}}</div>
        <div class="row" style="padding-top: 30px">
            <div class="col" id="kezdolapleiras1">
                Napkelte: <br> <b>{{$sunrise}}</b> <br><br>
                Napnyugta: <br> <b>{{$sunset}}</b> <br><br>
                Max hőm.: <br> <b>{{$temperatureFahrenheitMax1}} &deg;F</b> <br><br>
                Min hőm.:  <br>  <b>{{$temperatureFahrenheitMin1}} &deg;F</b> <br><br>
            </div>
            <div class="col" id="kezdolapleiras2" >
                <i>   Felhőzet:  <br> <b> {{$cloudCover}} % </b> <br><br>
                    Légnyomás: <br>  <b>{{$pressure}} hPa </b><br><br>
                    Páratartalom: <br> <b> {{$humidity}} % </b><br><br>
                </i>
            </div>
            <div class="col" id="kezdolapleiras3" >
                <i>
                    Hőérzet: <br> <b> {{$tempFahrenheitFeelslike}} &deg;F </b> <br><br>
                    Szélsebesség: <br>   <b> {{$windSpeed}} km/h </b> <br><br>
                    Szélirány: <br> <img class="kezdolapszelirany" src="{{$windDeg}}">
                </i>
            </div>
        </div>
    </div>

    <!-- adatok listázása Celsius-ban-->
    <div class="panel panel-weather"  id="locationCelsius">
        <div class="location"><b>{{$name}}</b></div>
        <img class="kezdolapikon" src=" {{$ikon}}">
        <div class="span temp">{{$temp}}<span class="degree">&deg;C</span></div>
        <div class="span text">{{$description}}</div>
        <div class="row" style="padding-top: 30px">
            <div class="col" id="kezdolapleiras1">
                Napkelte: <br> <b>{{$sunrise}}</b> <br><br>
                Napnyugta: <br>  <b>{{$sunset}}</b> <br><br>
                Max hőm.: <br> <b>{{$temperatureMax1}} &deg;C</b> <br><br>
                Min hőm.:  <br>  <b>{{$temperatureMin1}} &deg;C</b> <br><br>
            </div>
            <div class="col" id="kezdolapleiras2" >
                <i>   Felhőzet:  <br> <b> {{$cloudCover}} % </b> <br><br>
                    Légnyomás: <br>  <b>{{$pressure}} hPa </b><br><br>
                    Páratartalom: <br> <b> {{$humidity}} % </b><br><br>
                </i>
            </div>
            <div class="col" id="kezdolapleiras3" >
                <i>
                    Hőérzet: <br> <b> {{$tempFeelslike}} &deg;C </b> <br><br>
                    Szélsebesség: <br>   <b> {{$windSpeed}} km/h </b> <br><br>
                    Szélirány: <br> <img class="kezdolapszelirany" src="{{$windDeg}}">
                </i>
            </div>
        </div>
    </div>

    <div  class="panel panel-weather" id="location3days">
        <div class="location"><b>{{$name}}</b></div>
        <img class="kezdolapikon" src=" {{$ikon}}">
        <div class="span temp">{{$temp}}<span class="degree">&deg;C</span></div>
        <div class="span text">{{$description}}</div>
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
                            text: 'Celsius - 3 óránkénti'
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
    <div class="panel panel-weather" id="location5days">
        <div class="location"><b>{{$name}}</b></div>
        <img class="kezdolapikon" src=" {{$ikon}}">
        <div class="span temp">{{$temp}}<span class="degree">&deg;C</span></div>
        <div class="span text">{{$description}}</div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="maxhom" style="height:100%; width: 100%">
                <script>
                    document.addEventListener('DOMContentLoaded', () =>{
                        Highcharts.chart('maxhom',{
                            chart: {
                                type: 'column',
                                backgroundColor: 'transparent'

                            },
                            colors: ['#FF8C00','#1e90ff'],
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
                                    text: 'Celsius - 5 napos'
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
                                categories: ["Ma","Holnap","3. nap","4. nap","5. nap"],
                                title: {
                                    text: "Nap",
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
                                            maxWidth: 529
                                        },
                                        chartOptions: {
                                            xAxis: {
                                                labels: {
                                                    fontSize: '6px',
                                                    color: 'white',
                                                    fontWeight: "bold"
                                                }
                                            },
                                            yAxis: {
                                                labels: {
                                                    enabled: false
                                                }
                                            },
                                            legend: {
                                                enabled: false
                                            }
                                        },

                                    },
                                    {
                                        condition: {
                                            minWidth: 530
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
                                    data: [{{$temperatureMax1}},{{$temperatureMax2}},{{$temperatureMax3}},{{$temperatureMax4}},{{$temperatureMax5}}],
                                    lineWidth: 3,
                                },
                                {

                                    name: 'Minimum hőmérséklet',
                                    data: [{{$temperatureMin1}},{{$temperatureMin2}},{{$temperatureMin3}},{{$temperatureMin4}},{{$temperatureMin5}}],
                                    lineWidth: 3
                                },
                            ]
                        });
                    });
                </script>
            </div>
        </div>
    </div>
    <div class="panel panel-functions">
        <div class="ikonmeretdefault"><button id="gomb1" name="gomb1"  style="border: none; background: none;"> <img src="{{URL::asset('/images/celsiustemp.svg')}}" height="55" width="55">  </button></div>
        <div class=ikonmeretdefault"><button id="gomb2" name="gomb2" style="border: none; background: none;"> <img src="{{URL::asset('/images/fahrenheittemp.png')}}" height="55" width="55">  </button></div>
        <div class=ikonmeretdefault"><button id="gomb3" name="gomb3" style="border: none; background: none;"> <img src="{{URL::asset('/images/three.png')}}" height="55" width="55">  </button></div>
        <div class=ikonmeretdefault"><button id="gomb4" name="gomb4" style="border: none; background: none;"> <img src="{{URL::asset('/images/five.png')}}" height="55" width="55">  </button></div>
    </div>

    <!--  Div Selector -->
    <script>
        $('#locationFahren').hide();
        $('#location3days').hide();
        $('#location5days').hide();
        $('#locationCelsius').show();
        document.getElementById("gomb1").addEventListener("click", function()
        {
            if(document.getElementById('locationCelsius').style.display == 'block'){
                document.getElementById('locationFahren').style.display = 'none';
                document.getElementById('location3days').style.display = 'none';
                document.getElementById('location5days').style.display = 'none';

            }
            else
                document.getElementById('locationCelsius').style.display = 'block';
            document.getElementById('locationFahren').style.display = 'none';
            document.getElementById('location3days').style.display = 'none';
            document.getElementById('location5days').style.display = 'none';
        });

        document.getElementById("gomb2").addEventListener("click", function()
        {
            if(document.getElementById('locationFahren').style.display == 'block'){
                document.getElementById('locationCelsius').style.display = 'none';
                document.getElementById('location3days').style.display = 'none';
                document.getElementById('location5days').style.display = 'none';
            }

            else
                document.getElementById('locationFahren').style.display = 'block';
            document.getElementById('locationCelsius').style.display = 'none';
            document.getElementById('location3days').style.display = 'none';
            document.getElementById('location5days').style.display = 'none';

        });

        document.getElementById("gomb3").addEventListener("click", function()
        {
            if(document.getElementById('location3days').style.display == 'block'){
                document.getElementById('locationCelsius').style.display = 'none';
                document.getElementById('locationFahren').style.display = 'none';
                document.getElementById('location5days').style.display = 'none';
            }

            else
                document.getElementById('location3days').style.display = 'block';
            document.getElementById('locationCelsius').style.display = 'none';
            document.getElementById('locationFahren').style.display = 'none';
            document.getElementById('location5days').style.display = 'none';

        });

        document.getElementById("gomb4").addEventListener("click", function()
        {
            if(document.getElementById('location5days').style.display == 'block'){
                document.getElementById('locationCelsius').style.display = 'none';
                document.getElementById('locationFahren').style.display = 'none';
                document.getElementById('location3days').style.display = 'none';
            }

            else
                document.getElementById('location5days').style.display = 'block';
            document.getElementById('locationCelsius').style.display = 'none';
            document.getElementById('locationFahren').style.display = 'none';
            document.getElementById('location3days').style.display = 'none';

        });
        <!-- page-scrolldown -->
        $(document).ready(function(){
            $('body,html').animate({scrollTop: 206}, 800);
        });
    </script>


    <script>
        $(document).ready(function(){
            $('body,html').animate({scrollTop: 206}, 800);
        });
    </script>

    <!--  autocomplete -->
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
