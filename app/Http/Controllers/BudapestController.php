<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;

class BudapestController extends Controller
{
    public function index()
    {

        //jelenlegi időjárás
        $clientBud = new Client();
        try {
            $bodyBud = $clientBud->get('http://api.openweathermap.org/data/2.5/weather?q=budapest&appid=86e5cbb3097836e0f2a884baa56e143a'
            )->getBody()->getContents();

        } catch (ClientException $e) {}

        $jsonBud = json_decode($bodyBud, true);
        $descriptionBud = $jsonBud['weather'][0]['description'];              //leírás
        $tempBud = round(($jsonBud['main']['temp'] - 273)); //fok     //jelenlegi hőm.
        $tempCurrentFahrenheitBud = round(($tempBud * 9 / 5) + 32); //fahrenheit     //jelenlegi hőm.
        $szelesseg = $jsonBud['coord']['lat']; //hosszusag
        $hosszusag = $jsonBud['coord']['lon']; //szelesseg
        $humidityBud = $jsonBud['main']['humidity'];              //páratartalom
        $windSpeedBud = round($jsonBud['wind']['speed']) * 3.6;  //szélsebesség
        $cloudCoverBud = $jsonBud['clouds']['all'];  //felhozet szazalekban
        $pressureBud = $jsonBud['main']['pressure']; //legnyomas

        $timezoneBud = $jsonBud['timezone'];
        $sunriseSecBud = $jsonBud['sys']['sunrise'] + $timezoneBud;
        $sunriseBud = date('H:i', $sunriseSecBud);  //napkelte
        $sunsetSecBud = $jsonBud['sys']['sunset'] + $timezoneBud;
        $sunsetBud = date('H:i', $sunsetSecBud); //napnyugta

        $tempFeelslikeBud = round(($jsonBud ['main']['feels_like'] - 273)); //fok  hoerzet
        $tempFahrenheitFeelslikeBud = round(($tempFeelslikeBud * 9 / 5) + 32); //fahrenheit hoerzet

        //ikon
        foreach ($jsonBud['weather'] as &$value) {

            $value['kep'] = 'images/' . $value['icon'] . '.png';
            $ikonBud = $value['kep'];
        }

        //szélirány
        if (!isset($jsonBud['wind']['deg'])) {
            $windDegBud = "Nincs adat";
        } else {
            $windDegBud = $jsonBud['wind']['deg'];
        }

        if ($windDegBud == "") {
            $windDegBud = "Nincs adat";
        } else if ($windDegBud < 90 && $windDegBud >= 0) {
            $windDegBud = 'images/ek.svg';
        } else if ($windDegBud == 90) {
            $windDegBud = 'images/k.svg';
        } else if ($windDegBud > 90 && $windDegBud < 180) {
            $windDegBud = 'images/dk.svg';
        } else if ($windDegBud >= 180 && $windDegBud < 240) {
            $windDegBud = 'images/dny.svg';
        } else if ($windDegBud == 240) {
            $windDegBud = 'images/ny.svg';
        } else if ($windDegBud > 240 && $windDegBud <= 360) {
            $windDegBud = 'images/eny.svg';
        } else if ($windDegBud == 0) {
            $windDegBud = "Nincs";
        }

        //ido...
        if ($descriptionBud == "clear sky") {
            $descriptionBud = "Derült idő";
        } else if ($descriptionBud == "few clouds") {
            $descriptionBud = "Néhol felhős";
        } else if ($descriptionBud == "fog") {
            $descriptionBud = "Ködös idő";
        } else if ($descriptionBud == "light rain") {
            $descriptionBud = "Gyenge eső";
        } else if ($descriptionBud == "scattered clouds") {
            $descriptionBud = "Szétszórtan felhős";
        } else if ($descriptionBud == "overcast clouds") {
            $descriptionBud = "Erősen felhős";
        } else if ($descriptionBud == "broken clouds") {
            $descriptionBud = "Borult idő";
        } else if ($descriptionBud == "shower rain") {
            $descriptionBud = "Ónos eső ";
        } else if ($descriptionBud == "rain") {
            $descriptionBud = "Eső";
        } else if ($descriptionBud == "thunderstorm") {
            $descriptionBud = "Zivatar";
        } else if ($descriptionBud == "snow") {
            $descriptionBud = "Hózápor";
        } else if ($descriptionBud == "mist") {
            $descriptionBud = "Ködös idő";
        } else if ($descriptionBud == "haze") {
            $descriptionBud = "Ködös idő";
        } else if ($descriptionBud == "smoke") {
            $descriptionBud = "Ködös idő";
        } else if ($descriptionBud == "thunderstorm with light rain") {
            $descriptionBud = "Zivatar gyenge esővel";
        } else if ($descriptionBud == "thunderstorm with heavy rain") {
            $descriptionBud = "Heves zivatar";
        } else if ($descriptionBud == "light thunderstorm") {
            $descriptionBud = "Zivatar";
        } else if ($descriptionBud == "heavy thunderstorm") {
            $descriptionBud = "Heves zivatar";
        } else if ($descriptionBud == "ragged thunderstorm") {
            $descriptionBud = "Heves zivatar";
        } else if ($descriptionBud == "thunderstorm with light drizzle") {
            $descriptionBud = "Gyenge zivatar";
        } else if ($descriptionBud == "thunderstorm with drizzle") {
            $descriptionBud = "Gyenge zivatar";
        } else if ($descriptionBud == "thunderstorm with heavy drizzle") {
            $descriptionBud = "Heves zivatar";
        } else if ($descriptionBud == "light intensity drizzle") {
            $descriptionBud = "Eső";
        } else if ($descriptionBud == "light intensity drizzle") {
            $descriptionBud = "Eső";
        } else if ($descriptionBud == "drizzle") {
            $descriptionBud = "Eső";
        } else if ($descriptionBud == "heavy intensity drizzle") {
            $descriptionBud = "Eső";
        } else if ($descriptionBud == "light intensity drizzle rain") {
            $descriptionBud = "Eső";
        } else if ($descriptionBud == "drizzle rain") {
            $descriptionBud = "Eső";
        } else if ($descriptionBud == "heavy intensity drizzle rain") {
            $descriptionBud = "Eső";
        } else if ($descriptionBud == "shower rain and drizzle") {
            $descriptionBud = "Eső";
        } else if ($descriptionBud == "heavy shower rain and drizzle") {
            $descriptionBud = "Eső";
        } else if ($descriptionBud == "shower drizzle") {
            $descriptionBud = "Eső";
        } else if ($descriptionBud == "light rain") {
            $descriptionBud = "Eső";
        } else if ($descriptionBud == "moderate rain") {
            $descriptionBud = "Eső";
        } else if ($descriptionBud == "heavy intensity rain") {
            $descriptionBud = "Eső";
        } else if ($descriptionBud == "very heavy rain") {
            $descriptionBud = "Eső";
        } else if ($descriptionBud == "extreme rain") {
            $descriptionBud = "Eső";
        } else if ($descriptionBud == "freezing rain") {
            $descriptionBud = "Ónos eső";
        } else if ($descriptionBud == "light intensity shower rain") {
            $descriptionBud = "Ónos eső";
        } else if ($descriptionBud == "heavy intensity shower rain") {
            $descriptionBud = "Ónos eső";
        } else if ($descriptionBud == "ragged shower rain") {
            $descriptionBud = "Ónos eső";
        } else if ($descriptionBud == "light snow") {
            $descriptionBud = "Hózápor";
        } else if ($descriptionBud == "Heavy snow") {
            $descriptionBud = "Hózápor";
        } else if ($descriptionBud == "Sleet") {
            $descriptionBud = "Havas eső";
        } else if ($descriptionBud == "Light shower sleet") {
            $descriptionBud = "Havas eső";
        } else if ($descriptionBud == "Shower sleet") {
            $descriptionBud = "Havas eső";
        } else if ($descriptionBud == "Light rain and snow") {
            $descriptionBud = "Havas eső";
        } else if ($descriptionBud == "Rain and snow") {
            $descriptionBud = "Havas eső";
        } else if ($descriptionBud == "Light shower snow") {
            $descriptionBud = "Havas eső";
        } else if ($descriptionBud == "Shower snow") {
            $descriptionBud = "Havas eső";
        } else if ($descriptionBud == "Heavy shower snow") {
            $descriptionBud = "Havas eső";
        }


        //minimum,maximum hőmérsékletethez egy másik API (előzőben nem volt  jól jelen), valamint az 5 napos előrejelzés hőmérséklet adatai
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
            $body = $client2->get('http://api.openweathermap.org/data/2.5/forecast?q=budapest&appid=86e5cbb3097836e0f2a884baa56e143a'
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





        return view('budapest', compact('descriptionBud', 'tempBud', 'temperatureMax1', 'temperatureMin1',
            'humidityBud', 'windSpeedBud', 'windDegBud', 'ikonBud', 'townBud', 'tempCurrentFahrenheitBud',
            'cloudCoverBud', 'pressureBud', 'sunriseBud', 'sunsetBud', 'temperatureFahrenheitMin1',
            'temperatureFahrenheitMax1', 'tempFeelslikeBud', 'tempFahrenheitFeelslikeBud',

            //3napos előrejelzés adatai, melyeket felhasználok jelenleg.
            'tempArray','threehoursArray',

            //5napos előrejelzés adatai, melyeket felhasználok jelenleg.
            'temperatureMax2', 'temperatureMax3', 'temperatureMax4' ,'temperatureMax5',
            'temperatureMin2', 'temperatureMin3', 'temperatureMin4', 'temperatureMin5'
        ));


    }

}
