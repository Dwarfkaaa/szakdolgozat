
@extends('layout')

<!-- ha nem letezik a varos -->
@if(!isset($body))

    @section('content')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
        <meta name="viewport" content="width=device-width">
        <link href="{{ asset('/css/style.css') }}" rel="stylesheet" />

        <div class="overlay">
            <div class="SearchWrapper">
                <form class="searchbox" class="typeahead form-control"  action="/fivedaysForecast" method="post" autocomplete="off">
                    {{csrf_field()}}
                    <input  type="text" name="search" value="{{$closest}}" placeholder="Írj be egy települést.." />
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

<!-- ha letezik a varos -->
@else(isset($body))

    @section('content')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <meta name="viewport" content="width=device-width">
        <link href="{{ asset('/css/style.css') }}" rel="stylesheet" />


        <div class="overlay">
            <div class="SearchWrapper">
                <form class="searchbox" class="typeahead form-control"  action="/fivedaysForecast" method="post" autocomplete="off">
                    {{csrf_field()}}
                    <input  type="text" name="search" placeholder="Írj be egy települést.." />
                    <button type="submit" name="search2" >Keresés</button>
                </form>
            </div>
        </div>

        <!-- Gombok eredmenyei -->
        <div class="panel panel-weather" id="elsonap">
            <div class="location">{{$kiiratasCurrent}}</div>
            <img class="threehoursikon" src=" {{$ikon5}}">
            <div class="span temp">{{$temperatureMax1}}<span class="degree">&deg;C</span></div><br><br>
            <div class="otodiknapdatum">  <b>{{$dateToDateDay1}} </b></div><br><br>
            <div class="wrapper" id="otodiknaielorejelzespadatok" >
                <div class="otnapiadatok1"><b>Max hőm. <br> {{$temperatureMax1}} &deg;C / {{$temperatureFahrenheitMax1}} &deg;F </b></div>
                <div class="otnapiadatok2"><b>Min hőm. <br> {{$temperatureMin1}} &deg;C / {{$temperatureFahrenheitMin1}} &deg;F  </b> </div>
                <div  class="otnapiadatok3">Eső valószínűsége: <br> {{$precipProbability1}} %</div>
                <div  class="otnapiadatok4">Szélsebesség: <br> {{$windSpeed1}} km/h</div>
                <div  class="otnapiadatok5">Páratartalom:<br>{{$humidity1}} %</div>
                <div  class="otnapiadatok6">UV-Index: <br>{{$uvIndex1}}</div>
                <div  class="otnapiadatok7">Felhőzet:<br>{{$cloudCover1 * 100}} %</div>
                <div  class="otnapiadatok8">Légnyomás: <br>{{$pressure1}} hPa</div>
            </div>
        </div>

        <div class="panel panel-weather" id="masodiknap">
            <div class="location">{{$kiiratasCurrent}}</div>
            <img class="threehoursikon" src=" {{$ikon2}}">
            <div class="span temp">{{$temperatureMax2}}<span class="degree">&deg;C</span></div><br><br>
            <div class="otodiknapdatum">  <b>{{$dateToDateDay2}} </b></div><br><br>
            <div class="wrapper" id="otodiknaielorejelzespadatok" >
                <div class="otnapiadatok1"><b>Max hőm. <br> {{$temperatureMax2}} &deg;C / {{$temperatureFahrenheitMax2}} &deg;F </b></div>
                <div class="otnapiadatok2"><b>Min hőm. <br> {{$temperatureMin2}} &deg;C / {{$temperatureFahrenheitMin2}} &deg;F  </b> </div>
                <div  class="otnapiadatok3">Eső valószínűsége: <br>   {{$precipProbability2}} %</div>
                <div  class="otnapiadatok4">Szélsebesség:<br> {{$windSpeed2}} km/h</div>
                <div  class="otnapiadatok5">Páratartalom: <br> {{$humidity2}} %</div>
                <div  class="otnapiadatok6">UV-Index: <br> {{$uvIndex2}}</div>
                <div  class="otnapiadatok7">Felhőzet:<br>  {{$cloudCover2 * 100}} %</div>
                <div  class="otnapiadatok8">Légnyomás:<br> {{$pressure2}} hPa</div>
            </div>
        </div>

        <div class="panel panel-weather" id="harmadiknap">
            <div class="location">{{$kiiratasCurrent}}</div>
            <img class="threehoursikon" src=" {{$ikon3}}">
            <div class="span temp">{{$temperatureMax3}}<span class="degree">&deg;C</span></div><br><br>
            <div class="otodiknapdatum">  <b>{{$dateToDateDay3}} </b></div><br><br>
            <div class="wrapper" id="otodiknaielorejelzespadatok" >
                <div class="otnapiadatok1"><b>Max hőm. <br> {{$temperatureMax3}} &deg;C / {{$temperatureFahrenheitMax3}} &deg;F </b></div>
                <div class="otnapiadatok2"><b>Min hőm. <br> {{$temperatureMin3}} &deg;C / {{$temperatureFahrenheitMin3}} &deg;F  </b> </div>
                <div  class="otnapiadatok3">Eső valószínűsége: <br>  {{$precipProbability3}} %</div>
                <div  class="otnapiadatok4">Szélsebesség: <br> {{$windSpeed3}} km/h</div>
                <div  class="otnapiadatok5">Páratartalom:<br> {{$humidity3}} %</div>
                <div  class="otnapiadatok6">UV-Index:<br>  {{$uvIndex3}}</div>
                <div  class="otnapiadatok7">Felhőzet:<br> {{$cloudCover3 * 100}} %</div>
                <div  class="otnapiadatok8">Légnyomás:<br> {{$pressure3}} hPa</div>
            </div>
        </div>

        <div class="panel panel-weather" id="negyediknap">
            <div class="location">{{$kiiratasCurrent}}</div>
            <img class="threehoursikon" src=" {{$ikon4}}">
            <div class="span temp">{{$temperatureMax4}}<span class="degree">&deg;C</span></div><br><br>
            <div class="otodiknapdatum">  <b>{{$dateToDateDay4}} </b></div><br><br>
            <div class="wrapper" id="otodiknaielorejelzespadatok" >
                <div class="otnapiadatok1"><b>Max hőm. <br> {{$temperatureMax4}} &deg;C / {{$temperatureFahrenheitMax4}} &deg;F </b></div>
                <div class="otnapiadatok2"><b>Min hőm. <br> {{$temperatureMin4}} &deg;C / {{$temperatureFahrenheitMin4}} &deg;F  </b> </div>
                <div  class="otnapiadatok3">Eső valószínűsége:<br>   {{$precipProbability4}} %</div>
                <div  class="otnapiadatok4">Szélsebesség:<br> {{$windSpeed4}} km/h</div>
                <div  class="otnapiadatok5">Páratartalom:<br> {{$humidity4}} %</div>
                <div  class="otnapiadatok6">UV-Index: <br> {{$uvIndex4}}</div>
                <div  class="otnapiadatok7">Felhőzet: <br> {{$cloudCover4 * 100}} %</div>
                <div  class="otnapiadatok8">Légnyomás:<br> {{$pressure4}} hPa</div>
            </div>
        </div>

        <div class="panel panel-weather" id="otodiknap">
            <div class="location">{{$kiiratasCurrent}}</div>
            <img class="threehoursikon" src=" {{$ikon5}}">
            <div class="span temp">{{$temperatureMax5}}<span class="degree">&deg;C</span></div><br><br>
            <div class="otodiknapdatum">  <b>{{$dateToDateDay5}} </b></div><br><br>
            <div class="wrapper" id="otodiknaielorejelzespadatok" >
                <div class="otnapiadatok1"><b>Max hőm. <br> {{$temperatureMax5}} &deg;C / {{$temperatureFahrenheitMax5}} &deg;F </b></div>
                <div class="otnapiadatok2"><b>Min hőm. <br> {{$temperatureMin5}} &deg;C / {{$temperatureFahrenheitMin5}} &deg;F  </b> </div>
                <div  class="otnapiadatok3">Eső valószínűsége: <br> {{$precipProbability5}} %</div>
                <div  class="otnapiadatok4">Szélsebesség: <br> {{$windSpeed5}} km/h</div>
                <div  class="otnapiadatok5">Páratartalom:<br> {{$humidity5}} %</div>
                <div  class="otnapiadatok6">UV-Index: <br> {{$uvIndex5}}</div>
                <div  class="otnapiadatok7">Felhőzet: <br>{{$cloudCover5 * 100}} %</div>
                <div  class="otnapiadatok8">Légnyomás:<br> {{$pressure5}} hPa</div>
            </div>
        </div>

        <!-- Fahrenheit -->
        <div class="panel panel-weather" id="fahrenheit">
            <div class="location">{{$kiiratasCurrent}}</div>
            <img class="threehoursikon" src=" {{$ikonCurrent}}">
            <div class="span temp">{{$tempCurrentFahrenheit}}<span class="degree">&deg;F</span></div>
            <div class="span text"> {{$description}}</div>
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-9 col-12" id="fahren" style="height:100%; width: 100%">
                    <script>
                        document.addEventListener('DOMContentLoaded', () =>{
                            Highcharts.chart('fahren',{
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
                                                        enabled: false
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
                                        data: [{{$temperatureFahrenheitMax1}},{{$temperatureFahrenheitMax2}},{{$temperatureFahrenheitMax3}},{{$temperatureFahrenheitMax4}},{{$temperatureFahrenheitMax5}}],
                                        lineWidth: 3
                                    },
                                    {
                                        name: 'Minimum hőmérséklet',
                                        data: [{{$temperatureFahrenheitMin1}},{{$temperatureFahrenheitMin2}},{{$temperatureFahrenheitMin3}},{{$temperatureFahrenheitMin4}},{{$temperatureFahrenheitMin5}}],
                                        lineWidth: 3
                                    },
                                ]
                            });
                        });
                    </script>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4" id="fahrenheit">
                    <div class="row">
                        <div class="col" >
                            <a   href="javascript:elsonap()"  style="text-decoration: none">
                                <div class="elsonapgomb"> {{$dateToDateDay1}} <br>  Max: {{$temperatureFahrenheitMax1}} &deg;F <br> Min:  {{$temperatureFahrenheitMin1}} &deg;F </div>
                            </a>
                        </div>
                        <div class="col">
                            <a   href="javascript:masodiknap()"  style="text-decoration: none">
                                <div class="masodiknapgomb"> {{$dateToDateDay2}} <br>  Max: {{$temperatureFahrenheitMax2}} &deg;F <br> Min:  {{$temperatureFahrenheitMin2}} &deg;F </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"style="padding-top: 10%" >
                            <a  href="javascript:harmadiknap()"  style="text-decoration: none">
                                <div class="harmadiknapgomb"> {{$dateToDateDay3}} <br>  Max: {{$temperatureFahrenheitMax3}} &deg;F <br> Min:  {{$temperatureFahrenheitMin3}} &deg;F </div>
                            </a>
                        </div>
                        <div class="col"style="padding-top: 10%">
                            <a   href="javascript:negyediknap()"  style="text-decoration: none">
                                <div class="negyediknapgomb"> {{$dateToDateDay4}} <br>  Max: {{$temperatureFahrenheitMax4}} &deg;F <br> Min:  {{$temperatureFahrenheitMin4}} &deg;F </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col" style="padding-top: 10%">
                            <a   href="javascript:otodiknap()"  style="text-decoration: none">
                                <div class="otodiknapgomb"> {{$dateToDateDay5}} <br>  Max: {{$temperatureFahrenheitMax5}} &deg;F <br> Min:  {{$temperatureFahrenheitMin5}} &deg;F </div>
                            </a>
                        </div>
                        <div class="col"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Celsius -->
        <div class="panel panel-weather" id="maxhomerseklet">
            <div class="location">{{$kiiratasCurrent}}</div>
            <img class="threehoursikon" src=" {{$ikonCurrent}}">
            <div class="span temp">{{$tempCurrent}}<span class="degree">&deg;C</span></div>
            <div class="span text"> {{$description}}</div>
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-9 col-12" id="maxhom" style="height:100%; width: 100%">
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
                                                        enabled: false
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

                <!-- Gombok -->
                <div id="maxhomerseklet">
                    <div class="row">
                        <div class="col" >
                            <a   href="javascript:elsonap()"  style="text-decoration: none">
                                <div class="elsonapgomb"> {{$dateToDateDay1}} <br>  Max: {{$temperatureMax1}} &deg;C <br> Min:  {{$temperatureMin1}} &deg;C </div>
                            </a>
                        </div>
                        <div class="col" >
                            <a   href="javascript:masodiknap()"  style="text-decoration: none">
                                <div class="masodiknapgomb"> {{$dateToDateDay2}} <br>  Max: {{$temperatureMax2}} &deg;C <br> Min:  {{$temperatureMin2}} &deg;C </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"  style="padding-top: 10%">
                            <a  href="javascript:harmadiknap() "  style="text-decoration: none">
                                <div class="harmadiknapgomb"> {{$dateToDateDay3}} <br>  Max: {{$temperatureMax3}} &deg;C <br> Min:  {{$temperatureMin3}} &deg;C </div>
                            </a>
                        </div>
                        <div class="col" style="padding-top: 10%">
                            <a   href="javascript:negyediknap()"  style="text-decoration: none">
                                <div class="negyediknapgomb"> {{$dateToDateDay4}} <br>  Max: {{$temperatureMax4}} &deg;C <br> Min:  {{$temperatureMin4}} &deg;C </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"style="padding-top: 10%">
                            <a   href="javascript:otodiknap()"  style="text-decoration: none">
                                <div class="otodiknapgomb"> {{$dateToDateDay5}} <br>  Max: {{$temperatureMax5}} &deg;C <br> Min:  {{$temperatureMin5}} &deg;C </div>
                            </a>
                        </div>
                        <div class="col"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="panel panel-functions">
            <div class=""><button id="expand" name="expand"  style="border: none; background: none;"> <img class="ikonmeretdefault" src="{{URL::asset('/images/celsiustemp.svg')}}">  </button></div>
            <div class=""><button id="expand2" name="expand2" style="border: none; background: none;"> <img class="ikonmeretdefault" src="{{URL::asset('/images/fahrenheittemp.png')}}">  </button></div>
        </div>

        <!-- Gombok: Div selector -->
        <script>
            function elsonap() {
                $('#fahrenheit').hide();
                $('#maxhomerseklet').hide();
                $('#masodiknap').hide();
                $('#harmadiknap').hide();
                $('#negyediknap').hide();
                $('#otodiknap').hide();
                $('#elsonap').show();
            }

            function masodiknap() {
                $('#fahrenheit').hide();
                $('#maxhomerseklet').hide();
                $('#elsonap').hide();
                $('#harmadiknap').hide();
                $('#negyediknap').hide();
                $('#otodiknap').hide();
                $('#masodiknap').show();
            }

            function harmadiknap() {
                $('#fahrenheit').hide();
                $('#maxhomerseklet').hide();
                $('#masodiknap').hide();
                $('#elsonap').hide();
                $('#negyediknap').hide();
                $('#otodiknap').hide();
                $('#harmadiknap').show();
            }

            function negyediknap() {
                $('#fahrenheit').hide();
                $('#maxhomerseklet').hide();
                $('#masodiknap').hide();
                $('#harmadiknap').hide();
                $('#otodiknap').hide();
                $('#elsonap').hide();
                $('#negyediknap').show();
            }

            function otodiknap() {
                $('#fahrenheit').hide();
                $('#maxhomerseklet').hide();
                $('#masodiknap').hide();
                $('#harmadiknap').hide();
                $('#negyediknap').hide();
                $('#elsonap').hide();
                $('#otodiknap').show();
            }
        </script>

        <!-- Div Selector -->
        <script>
            $('#fahrenheit').hide();
            $('#elsonap').hide();
            $('#masodiknap').hide();
            $('#harmadiknap').hide();
            $('#negyediknap').hide();
            $('#otodiknap').hide();
            $('#maxhomerseklet').show();

            document.getElementById("expand").addEventListener("click", function()
            {
                if(document.getElementById('maxhomerseklet').style.display == 'block'){
                    document.getElementById('fahrenheit').style.display = 'none';
                    document.getElementById('elsonap').style.display = 'none';
                    document.getElementById('masodiknap').style.display = 'none';
                    document.getElementById('harmadiknap').style.display = 'none';
                    document.getElementById('negyediknap').style.display = 'none';
                    document.getElementById('otodiknap').style.display = 'none';
                }
                else
                    document.getElementById('maxhomerseklet').style.display = 'block';
                    document.getElementById('fahrenheit').style.display = 'none';
                    document.getElementById('elsonap').style.display = 'none';
                    document.getElementById('masodiknap').style.display = 'none';
                    document.getElementById('harmadiknap').style.display = 'none';
                    document.getElementById('negyediknap').style.display = 'none';
                    document.getElementById('otodiknap').style.display = 'none';
            });
            document.getElementById("expand2").addEventListener("click", function()
            {
                if(document.getElementById('fahrenheit').style.display == 'block'){
                    document.getElementById('maxhomerseklet').style.display = 'none';
                    document.getElementById('elsonap').style.display = 'none';
                    document.getElementById('masodiknap').style.display = 'none';
                    document.getElementById('harmadiknap').style.display = 'none';
                    document.getElementById('negyediknap').style.display = 'none';
                    document.getElementById('otodiknap').style.display = 'none';
                }
                else
                    document.getElementById('fahrenheit').style.display = 'block';
                    document.getElementById('maxhomerseklet').style.display = 'none';
                    document.getElementById('elsonap').style.display = 'none';
                    document.getElementById('masodiknap').style.display = 'none';
                    document.getElementById('harmadiknap').style.display = 'none';
                    document.getElementById('negyediknap').style.display = 'none';
                    document.getElementById('otodiknap').style.display = 'none';
            });


        </script>

        <!-- page-scrolldown -->
        <script>
        $(document).ready(function(){
        $('body,html').animate({scrollTop: 206}, 800);
        });
        </script>

        <script>
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
