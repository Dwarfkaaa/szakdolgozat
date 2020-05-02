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

class LocationController extends Controller
{

    public function location(Request $request)
    {
        $location = $request->input('location');

        $client = new Client();
        try {
            $body = $client->get('http://api.openweathermap.org/data/2.5/weather?q=' . $location . '&appid=86e5cbb3097836e0f2a884baa56e143a'

            )->getBody()->getContents();

        } catch (ClientException $e) {}

        $json = json_decode($body, true);

        $name = $json['name'];
        $description = $json['weather'][0]['description'];              //leírás
        $temp = round(($json['main']['temp'] - 273)); //fok     //jelenlegi hőm.
        $tempCurrentFahrenheit = round(($temp * 9/5)+32); //fahrenheit     //jelenlegi hőm.
        $szelesseg = $json['coord']['lat']; //hosszusag
        $hosszusag = $json['coord']['lon']; //szelesseg
        $max_temp = round(($json['main']['temp_max']) - 273);   //max_hőm.
        $min_temp = round(($json['main']['temp_min']) - 273);   //min_hőmérséklet
        $humidity = $json['main']['humidity'];              //páratartalom
        $windSpeed = round($json['wind']['speed']) * 3.6;  //szélsebesség
        $cloudCover =  $json['clouds']['all'] ;  //felhozet szazalekban
        $pressure =  $json['main']['pressure']; //legnyomas

        $timezone = $json['timezone'];
        $sunriseSec =  $json['sys']['sunrise'] + $timezone;
        $sunrise = date('H:i', $sunriseSec);  //napkelte
        $sunsetSec =  $json['sys']['sunset']+ $timezone;
        $sunset = date('H:i', $sunsetSec); //napnyugta

        $min_tempFahrenheit = round(($min_temp * 9/5)+32);
        $max_tempFahrenheit = round(($max_temp * 9/5)+32);

        $tempFeelslike = round(( $json ['main']['feels_like'] - 273)); //fok  hoerzet
        $tempFahrenheitFeelslike = round(($tempFeelslike * 9/5)+32); //fahrenheit hoerzet

        //ikon
        foreach ($json['weather'] as &$value) {
            $value['kep'] = 'images/' . $value['icon'] . '.png';
            $ikon = $value['kep'];
        }


        //szélirány
        if (!isset($json['wind']['deg'])) {
            $windDeg = "Nincs adat";
        } else {
            $windDeg = $json['wind']['deg'];
        }

        if ($windDeg == "") {
            $windDeg = "Nincs adat";
        } else if ($windDeg < 90 && $windDeg >= 0) {
            $windDeg = 'images/ek.svg';
        } else if ($windDeg == 90) {
            $windDeg = 'images/k.svg';
        } else if ($windDeg > 90 && $windDeg < 180) {
            $windDeg = 'images/dk.svg';
        } else if ($windDeg >= 180 && $windDeg < 240) {
            $windDeg = 'images/dny.svg';
        } else if ($windDeg == 240) {
            $windDeg = 'images/ny.svg';
        } else if ($windDeg > 240 && $windDeg <= 360) {
            $windDeg = 'images/eny.svg';
        } else if ($windDeg == 0) {
            $windDeg = "Nincs";
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


        //minimum,maximum hőmérsékletethez egy másik API (előzőben nem volt jelen), valamint az 5 napos előrejelzés hőmérséklet adatai
        $darkskyapi = new Client();
        try {
            $body = $darkskyapi->get('https://api.darksky.net/forecast/a0a7e9251010849166f773c19512dc65/' . $szelesseg . ',' . $hosszusag . ''

            )->getBody()->getContents();
        } catch (ClientException $e) {}

        $jsonDarkSky = json_decode($body, true);
        $daily = $jsonDarkSky['daily'];
        $temperatureFahrenheitMax1 = round($daily['data'][0]['temperatureMax']);
        $temperatureFahrenheitMin1 = round($daily['data'][0]['temperatureMin']);
        $temperatureMax1 = round(($temperatureFahrenheitMax1 - 32) * (5 / 9));
        $temperatureMin1 = round(($temperatureFahrenheitMin1 - 32) * (5 / 9));


        $temperatureFahrenheitMaxFivedays2 = round($daily['data'][1]['temperatureMax']);
        $temperatureFahrenheitMinFivedays2 = round($daily['data'][1]['temperatureMin']);
        $temperatureMax2 = round(($temperatureFahrenheitMaxFivedays2 - 32) * (5 / 9));
        $temperatureMin2 = round(($temperatureFahrenheitMinFivedays2 - 32) * (5 / 9));


        $temperatureFahrenheitMaxFivedays3 = round($daily['data'][2]['temperatureMax']);
        $temperatureFahrenheitMinFivedays3 = round($daily['data'][2]['temperatureMin']);
        $temperatureMax3 = round(($temperatureFahrenheitMaxFivedays3 - 32) * (5 / 9));
        $temperatureMin3 = round(($temperatureFahrenheitMinFivedays3 - 32) * (5 / 9));

        $temperatureFahrenheitMaxFivedays4 = round($daily['data'][3]['temperatureMax']);
        $temperatureFahrenheitMinFivedays4 = round($daily['data'][3]['temperatureMin']);
        $temperatureMax4 = round(($temperatureFahrenheitMaxFivedays4 - 32) * (5 / 9));
        $temperatureMin4 = round(($temperatureFahrenheitMinFivedays4 - 32) * (5 / 9));

        $temperatureFahrenheitMaxFivedays5 = round($daily['data'][4]['temperatureMax']);
        $temperatureFahrenheitMinFivedays5 = round($daily['data'][4]['temperatureMin']);
        $temperatureMax5 = round(($temperatureFahrenheitMaxFivedays5 - 32) * (5 / 9));
        $temperatureMin5 = round(($temperatureFahrenheitMinFivedays5 - 32) * (5 / 9));


        //három órás előrejelzés
        $client2 = new Client();

        try {
            $body = $client2->get('http://api.openweathermap.org/data/2.5/forecast?q='.$location.'&appid=86e5cbb3097836e0f2a884baa56e143a'
            )->getBody()->getContents();
        } catch (ClientException $e) {}

        $jsonThreehours = json_decode($body, true);
        $tempArray = array();
        $threehoursArray = array();


        foreach ($jsonThreehours['list'] as &$value) {
            $value['kep'] = 'images/' . $value['weather'][0]['icon'] . '.png';
            $temp = round($value['main']['temp'] - 273); //fok
            $threehours = $value['dt_txt'];   //datum
            $threehoursArray[] = $threehours;
            $tempArray[] = $temp;
        }



        return view('location', compact('name', 'description', 'temp','temperatureMax1','temperatureMin1',
            'humidity', 'windSpeed', 'windDeg', 'ikon', 'body', 'tempCurrentFahrenheit',
            'cloudCover', 'pressure', 'sunrise', 'sunset', 'temperatureFahrenheitMax1','temperatureFahrenheitMin1','tempFeelslike', 'tempFahrenheitFeelslike'
            //3napos előrejelzés adatai, melyeket felhasználok jelenleg.
            ,'tempArray','threehoursArray',

            //5napos előrejelzés adatai, melyeket felhasználok jelenleg.
            'temperatureMax2', 'temperatureMax3', 'temperatureMax4' ,'temperatureMax5',
            'temperatureMin2', 'temperatureMin3', 'temperatureMin4', 'temperatureMin5'));

    }

}










