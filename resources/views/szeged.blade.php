@extends('layout')

@section('content')
    <meta name="viewport" content="width=device-width">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet" />


    <div class="overlay"></div>
    <!-- adatok listázása-->
    <div class="panel panel-weather"  id="szegedFahren">
        <div class="location"><b>Szeged</b></div>
        <img class="kezdolapikon" src=" {{$ikonSzeged}}">
        <div class="span temp">{{$tempCurrentFahrenheitSzeged}}<span class="degree">&deg;F</span></div>
        <div class="span text">{{$descriptionSzeged}}</div>
        <div class="row" style="padding-top: 30px">
            <div class="col" id="kezdolapleiras1">
                Napkelte: <br> <b>{{$sunriseSzeged}}</b> <br><br>
                Napnyugta: <br> <b>{{$sunsetSzeged}}</b> <br><br>
                Max hőm.: <br> <b>{{$temperatureFahrenheitMax1}} &deg;F</b> <br><br>
                Min hőm.:  <br>  <b>{{$temperatureFahrenheitMin1}} &deg;F</b>
            </div>
            <div class="col" id="kezdolapleiras2" >
                <i>   Felhőzet:  <br> <b> {{$cloudCoverSzeged}} % </b> <br><br>
                    Légnyomás: <br>  <b>{{$pressureSzeged}} hPa </b><br><br>
                    Páratartalom: <br> <b> {{$humiditySzeged}} % </b><br><br>
                </i>
            </div>
            <div class="col" id="kezdolapleiras3" >
                <i>
                    Hőérzet: <br> <b> {{$tempFahrenheitFeelslikeSzeged}} &deg;F </b> <br><br>
                    Szélsebesség: <br>   <b> {{$windSpeedSzeged}} km/h </b> <br><br>
                    Szélirány: <br> <img class="kezdolapszelirany" src="{{$windDegSzeged}}">
                </i>
            </div>
        </div>
    </div>
    <!-- adatok listázása-->
    <div class="panel panel-weather"  id="szegedCelsius">
        <div class="location"><b>Szeged</b></div>
        <img class="kezdolapikon" src=" {{$ikonSzeged}}">
        <div class="span temp">{{$tempSzeged}}<span class="degree">&deg;C</span></div>
        <div class="span text">{{$descriptionSzeged}}</div>
        <div class="row" style="padding-top: 30px">
            <div class="col" id="kezdolapleiras1">
                Napkelte: <br> <b>{{$sunriseSzeged}}</b> <br><br>
                Napnyugta: <br>  <b>{{$sunsetSzeged}}</b> <br><br>
                Max hőm.: <br> <b>{{$temperatureMax1}} &deg;C</b> <br><br>
                Min hőm.:  <br>  <b>{{$temperatureMin1}} &deg;C</b> <br><br>
            </div>
            <div class="col" id="kezdolapleiras2" >
                <i>   Felhőzet:  <br> <b> {{$cloudCoverSzeged}} % </b> <br><br>
                    Légnyomás: <br>  <b>{{$pressureSzeged}} hPa </b><br><br>
                    Páratartalom: <br> <b> {{$humiditySzeged}} % </b><br><br>

                </i>
            </div>
            <div class="col" id="kezdolapleiras3" >
                <i>
                    Hőérzet: <br> <b> {{$tempFeelslikeSzeged}} &deg;C </b> <br><br>
                    Szélsebesség: <br>   <b> {{$windSpeedSzeged}} km/h </b> <br><br>
                    Szélirány: <br> <img class="kezdolapszelirany" src="{{$windDegSzeged}}">
                </i>
            </div>
        </div>
    </div>
    <div  class="panel panel-weather" id="szeged3days">
        <div class="location"><b>Szeged</b></div>
        <img class="kezdolapikon" src=" {{$ikonSzeged}}">
        <div class="span temp">{{$tempSzeged}}<span class="degree">&deg;C</span></div>
        <div class="span text">{{$descriptionSzeged}}</div>
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
    <div class="panel panel-weather" id="szeged5days">
        <div class="location"><b>Szeged</b></div>
        <img class="kezdolapikon" src=" {{$ikonSzeged}}">
        <div class="span temp">{{$tempSzeged}}<span class="degree">&deg;C</span></div>
        <div class="span text">{{$descriptionSzeged}}</div>
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


    <script>
        $('#szegedFahren').hide();
        $('#szeged3days').hide();
        $('#szeged5days').hide();
        $('#szegedCelsius').show();
        document.getElementById("gomb1").addEventListener("click", function()
        {
            if(document.getElementById('szegedCelsius').style.display == 'block'){
                document.getElementById('szegedFahren').style.display = 'none';
                document.getElementById('szeged3days').style.display = 'none';
                document.getElementById('szeged5days').style.display = 'none';

            }
            else
                document.getElementById('szegedCelsius').style.display = 'block';
            document.getElementById('szegedFahren').style.display = 'none';
            document.getElementById('szeged3days').style.display = 'none';
            document.getElementById('szeged5days').style.display = 'none';
        });

        document.getElementById("gomb2").addEventListener("click", function()
        {
            if(document.getElementById('szegedFahren').style.display == 'block'){
                document.getElementById('szegedCelsius').style.display = 'none';
                document.getElementById('szeged3days').style.display = 'none';
                document.getElementById('szeged5days').style.display = 'none';
            }

            else
                document.getElementById('szegedFahren').style.display = 'block';
            document.getElementById('szegedCelsius').style.display = 'none';
            document.getElementById('szeged3days').style.display = 'none';
            document.getElementById('szeged5days').style.display = 'none';

        });

        document.getElementById("gomb3").addEventListener("click", function()
        {
            if(document.getElementById('szeged3days').style.display == 'block'){
                document.getElementById('szegedCelsius').style.display = 'none';
                document.getElementById('szegedFahren').style.display = 'none';
                document.getElementById('szeged5days').style.display = 'none';
            }

            else
                document.getElementById('szeged3days').style.display = 'block';
            document.getElementById('szegedCelsius').style.display = 'none';
            document.getElementById('szegedFahren').style.display = 'none';
            document.getElementById('szeged5days').style.display = 'none';

        });

        document.getElementById("gomb4").addEventListener("click", function()
        {
            if(document.getElementById('szeged5days').style.display == 'block'){
                document.getElementById('szegedCelsius').style.display = 'none';
                document.getElementById('szegedFahren').style.display = 'none';
                document.getElementById('szeged3days').style.display = 'none';
            }

            else
                document.getElementById('szeged5days').style.display = 'block';
            document.getElementById('szegedCelsius').style.display = 'none';
            document.getElementById('szegedFahren').style.display = 'none';
            document.getElementById('szeged3days').style.display = 'none';

        });

        <!-- page-scrolldown -->
        $(document).ready(function(){
            $('body,html').animate({scrollTop: 206}, 800);
        });
    </script>

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

