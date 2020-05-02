<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mockery\Matcher\Not;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Arr;
use App\Item_model;

//Az 5 napos előrejelzésnél, szélesség/hosszúság alapján kellett keresni. Ezért meghivom a Kezdőlap Controllerbe levő apit,
//Kiszedem a szélesség hosszúságot abból az aPI-ból.
//majd a szélesség/hosszúságot beillesztem a DarkSkyApi-ba . Így tudom lekérni az adott városról az előrejelzéseket.
class FivedaysController extends Controller
{
    public function fivedays(Request $request)
    {
        $town = $request['search'];

        //LEVENSTEIN
        $database = Item_model::select("name")->get();
        $shortest = -1;
        $szoveg = str_replace(' ', '', strtolower($request['search']));

        foreach ($database as $datas) {
            $adatbazis = strtolower($datas->name);

            $lev = levenshtein($szoveg, $adatbazis);
            if ($lev == 0) {
                // closest word is this one (exact match)
                $closest = $datas->name;
                $shortest = 0;
                // break out of the loop; we've found an exact match
                break;
            }

            // distance, OR if a next shortest word has not yet been found
            if ($lev <= $shortest || $shortest < 0) {
                // set the closest match, and shortest distance
                $closest = $datas->name;
                $shortest = $lev;
            }
        }

        //Karakter Dekodolas.
        $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'ő'=>'o', 'Ő'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ű'=>'u' , 'Ű' => 'u'  , 'ü'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );

        $char_decodeCurrent=  strtr($town, $unwanted_array ) ;

        //Az aktualis varos API-jara van szuksegunk, a szelesseg, hosszusag kiszuresehez. Ezen adatok pedig az 5 napos elorejelzesehez szuksegesek.
        $client = new Client();
        try {
            $body = $client->get('http://api.openweathermap.org/data/2.5/weather?q='. $char_decodeCurrent .'&appid=86e5cbb3097836e0f2a884baa56e143a'
            )->getBody()->getContents();

        } catch (ClientException $e) {
            return view('fivedaysForecast', compact('closest', 'body'));

        }
        $fivedays = json_decode($body, true);
        $szelesseg = $fivedays['coord']['lat'];
        $hosszusag = $fivedays['coord']['lon'];


        $kiiratasCurrent = $fivedays['name'];
        $description = $fivedays['weather'][0]['description'];
        foreach ( $fivedays['weather'] as &$value) {

            $value['kep'] = 'images/' . $value['icon'] . '.png';
            $ikonCurrent = $value['kep'];
        }
        $tempCurrent = round(($fivedays['main']['temp'] - 273)); //fok     //jelenlegi hőm.
        $tempCurrentFahrenheit = round(($tempCurrent * 9/5)+32); //fahrenheit     //jelenlegi hőm.



        //5 napos előrejelzés
        $client1 = new Client();
        try {
            $body = $client1->get('https://api.darksky.net/forecast/a0a7e9251010849166f773c19512dc65/'. $szelesseg .','. $hosszusag .''
            )->getBody()->getContents();
        } catch (ClientException $e) {}

        $json =  json_decode($body, true);

        foreach($json['daily']['data'] as  &$value) {
            $ikon = $value['icon'];

            switch ($ikon) {
                case "clear-day":
                    $value['icon'] = 'images/01d.png';
                    break;
                case "clear-night":
                    $value['icon'] = 'images/01n.png';
                    break;
                case "rain":
                    $value['icon'] = 'images/10d.png';
                    break;
                case "snow":
                    $value['icon'] = 'images/13d.png';
                    break;
                case "sleet":
                    $value['icon'] = 'images/09d.png';
                    break;
                case "cloudy":
                    $value['icon'] = 'images/03d.png';
                    break;
                case "partly-cloudy-day":
                    $value['icon'] = 'images/02d.png';
                    break;
                case "partly-cloudy-night":
                    $value['icon'] = 'images/02n.png';
                    break;
                case "wind":
                    $value['icon'] = 'images/10n.png';
                    break;
                case "fog":
                    $value['icon'] = 'images/11n.png';
                    break;
                case "thunderstorm":
                    $value['icon'] = 'images/11d.png';
                    break;
                case "hail":
                    $value['icon'] = 'images/10d.png';
                    break;
            }

            //ido...
            if ($description == "clear sky") {
                $description = "Derült idő";
            } else if ($description == "few clouds") {
                $description = "Néhol felhős";
            }
            else if ($description == "fog") {
                $description = "Ködös idő";
            }
            else if ($description == "light rain") {
                $description = "Gyenge eső";
            } else if ($description == "scattered clouds") {
                $description = "Szétszórtan felhős";
            } else if ($description == "overcast clouds") {
                $description = "Erősen felhős";
            } else if ($description == "broken clouds") {
                $description = "Borult idő";
            } else if ($description == "shower rain") {
                $description = "Ónos eső ";
            } else if ($description == "rain") {
                $description = "Eső";
            } else if ($description == "thunderstorm") {
                $description = "Zivatar";
            } else if ($description == "snow") {
                $description = "Hózápor";
            } else if ($description == "mist") {
                $description = "Ködös idő";
            } else if ($description == "haze") {
                $description = "Ködös idő";
            }
            else if ($description == "smoke") {
                $description = "Ködös idő";
            }
            else if ($description == "thunderstorm with light rain") {
                $description = "Zivatar gyenge esővel";
            }
            else if ($description == "thunderstorm with heavy rain") {
                $description = "Heves zivatar";
            }
            else if ($description == "light thunderstorm") {
                $description = "Zivatar";
            }
            else if ($description == "heavy thunderstorm") {
                $description = "Heves zivatar";
            }
            else if ($description == "ragged thunderstorm") {
                $description = "Heves zivatar";
            }
            else if ($description == "thunderstorm with light drizzle") {
                $description = "Gyenge zivatar";
            }
            else if ($description == "thunderstorm with drizzle") {
                $description = "Gyenge zivatar";
            }
            else if ($description == "thunderstorm with heavy drizzle") {
                $description = "Heves zivatar";
            }
            else if ($description == "light intensity drizzle") {
                $description = "Eső";
            }
            else if ($description == "light intensity drizzle") {
                $description = "Eső";
            }
            else if ($description == "drizzle") {
                $description = "Eső";
            }
            else if ($description == "heavy intensity drizzle") {
                $description = "Eső";
            }
            else if ($description == "light intensity drizzle rain") {
                $description = "Eső";
            }
            else if ($description == "drizzle rain") {
                $description = "Eső";
            }
            else if ($description == "heavy intensity drizzle rain") {
                $description = "Eső";
            }
            else if ($description == "shower rain and drizzle") {
                $description = "Eső";
            }
            else if ($description == "heavy shower rain and drizzle") {
                $description = "Eső";
            }
            else if ($description == "shower drizzle") {
                $description = "Eső";
            }
            else if ($description == "light rain") {
                $description = "Eső";
            }
            else if ($description == "moderate rain") {
                $description = "Eső";
            }
            else if ($description == "heavy intensity rain") {
                $description = "Eső";
            }
            else if ($description == "very heavy rain") {
                $description = "Eső";
            }
            else if ($description == "extreme rain") {
                $description = "Eső";
            }
            else if ($description == "freezing rain") {
                $description = "Ónos eső";
            }
            else if ($description == "light intensity shower rain") {
                $description = "Ónos eső";
            }
            else if ($description == "heavy intensity shower rain") {
                $description = "Ónos eső";
            }
            else if ($description == "ragged shower rain") {
                $description = "Ónos eső";
            }
            else if ($description == "light snow") {
                $description = "Hózápor";
            }
            else if ($description == "Heavy snow") {
                $description = "Hózápor";
            }
            else if ($description == "Sleet") {
                $description = "Havas eső";
            }
            else if ($description == "Light shower sleet") {
                $description = "Havas eső";
            }
            else if ($description == "Shower sleet") {
                $description = "Havas eső";
            }
            else if ($description == "Light rain and snow") {
                $description = "Havas eső";
            }
            else if ($description == "Rain and snow") {
                $description = "Havas eső";
            }
            else if ($description == "Light shower snow") {
                $description = "Havas eső";
            }
            else if ($description == "Shower snow") {
                $description = "Havas eső";
            }
            else if ($description == "Heavy shower snow") {
                $description = "Havas eső";
            }

            $daily = $json['daily'];
            $dateToSec1 = $daily['data'][1]['time'];
            $descriptionForecast1 = $daily['data'][0]['summary'];
            $temperatureFahrenheitMax1 = round($daily['data'][0]['temperatureMax']);
            $temperatureFahrenheitMin1 = round($daily['data'][0]['temperatureMin']);
            $temperatureMax1 = round(($temperatureFahrenheitMax1 -32 ) * (5/9));
            $temperatureMin1 = round(($temperatureFahrenheitMin1 -32 ) * (5/9));
            $dateToDateDay1 = date('Y-m-d', $dateToSec1);


            $ikon1 = $daily['data'][0]['icon'];
            $windSpeed1 = round($daily['data'][0]['windSpeed']);
            $pressure1 = $daily['data'][0]['pressure'];
            $sunriseTime1 = $daily['data'][0]['sunriseTime'];
            $sunriseTime1toDate = date('h:m', $sunriseTime1);
            $sunsetTime1 = $daily['data'][0]['sunsetTime'];
            $sunsetTime1toDate = date('h:m', $sunsetTime1);
            $precipProbability1 =  ($daily['data'][0]['precipProbability']) * 100;
            $cloudCover1 = $daily['data'][0]['cloudCover'];
            $uvIndex1 = $daily['data'][0]['uvIndex'];
            $humidity1 = $daily['data'][0]['humidity'] * 100;


            $dateToSec2 = $daily['data'][2]['time'];
            $descriptionForecast2 = $daily['data'][1]['summary'];
            $temperatureFahrenheitMax2 = round($daily['data'][1]['temperatureMax']);
            $temperatureFahrenheitMin2 = round($daily['data'][1]['temperatureMin']);
            $temperatureMax2 = round(($temperatureFahrenheitMax2 -32 ) * (5/9)) ;
            $temperatureMin2 = round(($temperatureFahrenheitMin2 -32 ) * (5/9));
            $dateToDateDay2 = date('Y-m-d', $dateToSec2);
            $ikon2 = $daily['data'][1]['icon'];
            $windSpeed2 = round($daily['data'][1]['windSpeed']);
            $pressure2 = $daily['data'][1]['pressure'];
            $sunriseTime2 = $daily['data'][1]['sunriseTime'];
            $sunriseTime2toDate = date('h:m', $sunriseTime2);
            $sunsetTime2 = $daily['data'][1]['sunsetTime'];
            $sunsetTime2toDate = date('h:m', $sunsetTime2);
            $precipProbability2 =  ($daily['data'][1]['precipProbability']) * 100;
            $cloudCover2 = $daily['data'][1]['cloudCover'];
            $uvIndex2 = $daily['data'][1]['uvIndex'];
            $humidity2 = $daily['data'][1]['humidity'] * 100;


            $dateToSec3 = $daily['data'][3]['time'];
            $descriptionForecast3 = $daily['data'][2]['summary'];
            $temperatureFahrenheitMax3 = round($daily['data'][2]['temperatureMax']);
            $temperatureFahrenheitMin3 = round($daily['data'][2]['temperatureMin']);
            $temperatureMax3 = round(($temperatureFahrenheitMax3 -32 ) * (5/9)) ;
            $temperatureMin3 = round(($temperatureFahrenheitMin3 -32 ) * (5/9));
            $dateToDateDay3 = date('Y-m-d', $dateToSec3);
            $ikon3 = $daily['data'][2]['icon'];
            $windSpeed3 = round($daily['data'][2]['windSpeed']);
            $pressure3 = $daily['data'][2]['pressure'];
            $sunriseTime3 = $daily['data'][2]['sunriseTime'];
            $sunriseTime3toDate = date('h:m', $sunriseTime3);
            $sunsetTime3 = $daily['data'][2]['sunsetTime'];
            $sunsetTime3toDate = date('h:m', $sunsetTime3);
            $precipProbability3 =  ($daily['data'][2]['precipProbability']) * 100;
            $cloudCover3 = $daily['data'][2]['cloudCover'];
            $uvIndex3 = $daily['data'][2]['uvIndex'];
            $humidity3 = $daily['data'][2]['humidity'] * 100;


            $dateToSec4 = $daily['data'][4]['time'];
            $descriptionForecast4 = $daily['data'][3]['summary'];
            $temperatureFahrenheitMax4 = round($daily['data'][3]['temperatureMax']);
            $temperatureFahrenheitMin4 = round($daily['data'][3]['temperatureMin']);
            $temperatureMax4 = round(($temperatureFahrenheitMax4 -32 ) * (5/9))  ;
            $temperatureMin4 = round(($temperatureFahrenheitMin4 -32 ) * (5/9));
            $dateToDateDay4 = date('Y-m-d', $dateToSec4);
            $ikon4 = $daily['data'][3]['icon'];
            $windSpeed4 = round($daily['data'][3]['windSpeed']);
            $pressure4 = $daily['data'][3]['pressure'];
            $sunriseTime4 = $daily['data'][3]['sunriseTime'];
            $sunriseTime4toDate = date('h:m', $sunriseTime4);
            $sunsetTime4 = $daily['data'][3]['sunsetTime'];
            $sunsetTime4toDate = date('h:m', $sunsetTime4);
            $precipProbability4 =  ($daily['data'][3]['precipProbability']) * 100;
            $cloudCover4 = $daily['data'][3]['cloudCover'];
            $uvIndex4 = $daily['data'][3]['uvIndex'];
            $humidity4 = $daily['data'][3]['humidity'] * 100 ;


            $dateToSec5 = $daily['data'][5]['time'];
            $descriptionForecast5 = $daily['data'][4]['summary'];
            $temperatureFahrenheitMax5 = round($daily['data'][4]['temperatureMax']);
            $temperatureFahrenheitMin5 = round($daily['data'][4]['temperatureMin']);
            $temperatureMax5 = round(($temperatureFahrenheitMax5 -32 ) * (5/9)) ;
            $temperatureMin5 = round(($temperatureFahrenheitMin5 -32 ) * (5/9));
            $dateToDateDay5 = date('Y-m-d', $dateToSec5);
            $ikon5 = $daily['data'][4]['icon'];
            $windSpeed5 = round($daily['data'][4]['windSpeed']);
            $pressure5 = $daily['data'][4]['pressure'];
            $sunriseTime5 = $daily['data'][4]['sunriseTime'];
            $sunriseTime5toDate = date('h:m', $sunriseTime5);
            $sunsetTime5 = $daily['data'][4]['sunsetTime'];
            $sunsetTime5toDate = date('h:m', $sunsetTime5);
            $precipProbability5 =  ($daily['data'][4]['precipProbability']) * 100;
            $cloudCover5 = $daily['data'][4]['cloudCover'];
            $uvIndex5 = $daily['data'][4]['uvIndex'];
            $humidity5 = $daily['data'][4]['humidity'] * 100;
        }

        return view('fivedaysForecast', compact(
            //jelenlegi idojaras adatok
            'kiiratasCurrent', 'description', 'ikonCurrent', 'tempCurrent','tempCurrentFahrenheit', 'body',

            //5 napos előrejelzés adatok naponként lebontva.
            'temperatureFahrenheitMax1', 'temperatureFahrenheitMax2', 'temperatureFahrenheitMax3', 'temperatureFahrenheitMax4', 'temperatureFahrenheitMax5',
            'temperatureFahrenheitMin1', 'temperatureFahrenheitMin2', 'temperatureFahrenheitMin3', 'temperatureFahrenheitMin4', 'temperatureFahrenheitMin5',
            'temperatureMax1', 'temperatureMax2', 'temperatureMax3', 'temperatureMax4' ,'temperatureMax5',
            'temperatureMin1', 'temperatureMin2', 'temperatureMin3', 'temperatureMin4', 'temperatureMin5',
            'dateToDateDay1', 'dateToDateDay2', 'dateToDateDay3', 'dateToDateDay4', 'dateToDateDay5',
            'ikon1', 'ikon2', 'ikon3', 'ikon4', 'ikon5',
            'windSpeed1', 'windSpeed2', 'windSpeed3', 'windSpeed4', 'windSpeed5',
            'pressure1', 'pressure2', 'pressure3', 'pressure4','pressure5',
            'sunriseTime1toDate', 'sunriseTime2toDate', 'sunriseTime3toDate', 'sunriseTime4toDate','sunriseTime5toDate',
            'sunsetTime1toDate', 'sunsetTime2toDate', 'sunsetTime3toDate', 'sunsetTime4toDate','sunsetTime5toDate',
            'precipProbability1', 'precipProbability2', 'precipProbability3', 'precipProbability4','precipProbability5',
            'cloudCover1','cloudCover2','cloudCover3','cloudCover4','cloudCover5',
            'descriptionForecast1','descriptionForecast2','descriptionForecast3','descriptionForecast4','descriptionForecast5',
            'humidity1','humidity2','humidity3','humidity4','humidity5',
            'uvIndex1','uvIndex2','uvIndex3','uvIndex4','uvIndex5'
        ));
    }







}

