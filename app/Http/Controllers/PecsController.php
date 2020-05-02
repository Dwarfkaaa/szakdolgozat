<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;

class PecsController extends Controller
{
    public function index()
    {

        //jelenlegi előrejelzés
        $clientPecs = new Client();
        try {
            $bodyPecs = $clientPecs->get('http://api.openweathermap.org/data/2.5/weather?q=pecs&appid=86e5cbb3097836e0f2a884baa56e143a'
            )->getBody()->getContents();

        } catch (ClientException $e) {}

        $jsonPecs = json_decode($bodyPecs, true);
        $descriptionPecs = $jsonPecs['weather'][0]['description'];              //leírás
        $tempPecs = round(($jsonPecs['main']['temp'] - 273)); //fok     //jelenlegi hőm.
        $tempCurrentFahrenheitPecs = round(($tempPecs * 9 / 5) + 32); //fahrenheit     //jelenlegi hőm.
        $szelesseg = $jsonPecs['coord']['lat']; //hosszusag
        $hosszusag = $jsonPecs['coord']['lon']; //szelesseg
        $humidityPecs = $jsonPecs['main']['humidity'];              //páratartalom
        $windSpeedPecs = round($jsonPecs['wind']['speed']) * 3.6;  //szélsebesség
        $cloudCoverPecs = $jsonPecs['clouds']['all'];  //felhozet szazalekban
        $pressurePecs = $jsonPecs['main']['pressure']; //legnyomas

        $timezonePecs = $jsonPecs['timezone'];
        $sunriseSecPecs = $jsonPecs['sys']['sunrise'] + $timezonePecs;
        $sunrisePecs = date('H:i', $sunriseSecPecs);  //napkelte
        $sunsetSecPecs = $jsonPecs['sys']['sunset'] + $timezonePecs;
        $sunsetPecs = date('H:i', $sunsetSecPecs); //napnyugta

        $tempFeelslikePecs = round(($jsonPecs ['main']['feels_like'] - 273)); //fok  hoerzet
        $tempFahrenheitFeelslikePecs = round(($tempFeelslikePecs * 9 / 5) + 32); //fahrenheit hoerzet

        //ikon
        foreach ($jsonPecs['weather'] as &$value) {

            $value['kep'] = 'images/' . $value['icon'] . '.png';
            $ikonPecs = $value['kep'];
        }

        //szélirány
        if (!isset($jsonPecs['wind']['deg'])) {
            $windDegPecs = "Nincs adat";
        } else {
            $windDegPecs = $jsonPecs['wind']['deg'];
        }

        if ($windDegPecs == "") {
            $windDegPecs = "Nincs adat";
        } else if ($windDegPecs < 90 && $windDegPecs >= 0) {
            $windDegPecs = 'images/ek.svg';
        } else if ($windDegPecs == 90) {
            $windDegPecs = 'images/k.svg';
        } else if ($windDegPecs > 90 && $windDegPecs < 180) {
            $windDegPecs = 'images/dk.svg';
        } else if ($windDegPecs >= 180 && $windDegPecs < 240) {
            $windDegPecs = 'images/dny.svg';
        } else if ($windDegPecs == 240) {
            $windDegPecs = 'images/ny.svg';
        } else if ($windDegPecs > 240 && $windDegPecs <= 360) {
            $windDegPecs = 'images/eny.svg';
        } else if ($windDegPecs == 0) {
            $windDegPecs = "Nincs";
        }

        //ido...
        if ($descriptionPecs == "clear sky") {
            $descriptionPecs = "Derült idő";
        } else if ($descriptionPecs == "few clouds") {
            $descriptionPecs = "Néhol felhős";
        } else if ($descriptionPecs == "fog") {
            $descriptionPecs = "Ködös idő";
        } else if ($descriptionPecs == "light rain") {
            $descriptionPecs = "Gyenge eső";
        } else if ($descriptionPecs == "scattered clouds") {
            $descriptionPecs = "Szétszórtan felhős";
        } else if ($descriptionPecs == "overcast clouds") {
            $descriptionPecs = "Erősen felhős";
        } else if ($descriptionPecs == "broken clouds") {
            $descriptionPecs = "Borult idő";
        } else if ($descriptionPecs == "shower rain") {
            $descriptionPecs = "Ónos eső ";
        } else if ($descriptionPecs == "rain") {
            $descriptionPecs = "Eső";
        } else if ($descriptionPecs == "thunderstorm") {
            $descriptionPecs = "Zivatar";
        } else if ($descriptionPecs == "snow") {
            $descriptionPecs = "Hózápor";
        } else if ($descriptionPecs == "mist") {
            $descriptionPecs = "Ködös idő";
        } else if ($descriptionPecs == "haze") {
            $descriptionPecs = "Ködös idő";
        } else if ($descriptionPecs == "smoke") {
            $descriptionPecs = "Ködös idő";
        } else if ($descriptionPecs == "thunderstorm with light rain") {
            $descriptionPecs = "Zivatar gyenge esővel";
        } else if ($descriptionPecs == "thunderstorm with heavy rain") {
            $descriptionPecs = "Heves zivatar";
        } else if ($descriptionPecs == "light thunderstorm") {
            $descriptionPecs = "Zivatar";
        } else if ($descriptionPecs == "heavy thunderstorm") {
            $descriptionPecs = "Heves zivatar";
        } else if ($descriptionPecs == "ragged thunderstorm") {
            $descriptionPecs = "Heves zivatar";
        } else if ($descriptionPecs == "thunderstorm with light drizzle") {
            $descriptionPecs = "Gyenge zivatar";
        } else if ($descriptionPecs == "thunderstorm with drizzle") {
            $descriptionPecs = "Gyenge zivatar";
        } else if ($descriptionPecs == "thunderstorm with heavy drizzle") {
            $descriptionPecs = "Heves zivatar";
        } else if ($descriptionPecs == "light intensity drizzle") {
            $descriptionPecs = "Eső";
        } else if ($descriptionPecs == "light intensity drizzle") {
            $descriptionPecs = "Eső";
        } else if ($descriptionPecs == "drizzle") {
            $descriptionPecs = "Eső";
        } else if ($descriptionPecs == "heavy intensity drizzle") {
            $descriptionPecs = "Eső";
        } else if ($descriptionPecs == "light intensity drizzle rain") {
            $descriptionPecs = "Eső";
        } else if ($descriptionPecs == "drizzle rain") {
            $descriptionPecs = "Eső";
        } else if ($descriptionPecs == "heavy intensity drizzle rain") {
            $descriptionPecs = "Eső";
        } else if ($descriptionPecs == "shower rain and drizzle") {
            $descriptionPecs = "Eső";
        } else if ($descriptionPecs == "heavy shower rain and drizzle") {
            $descriptionPecs = "Eső";
        } else if ($descriptionPecs == "shower drizzle") {
            $descriptionPecs = "Eső";
        } else if ($descriptionPecs == "light rain") {
            $descriptionPecs = "Eső";
        } else if ($descriptionPecs == "moderate rain") {
            $descriptionPecs = "Eső";
        } else if ($descriptionPecs == "heavy intensity rain") {
            $descriptionPecs = "Eső";
        } else if ($descriptionPecs == "very heavy rain") {
            $descriptionPecs = "Eső";
        } else if ($descriptionPecs == "extreme rain") {
            $descriptionPecs = "Eső";
        } else if ($descriptionPecs == "freezing rain") {
            $descriptionPecs = "Ónos eső";
        } else if ($descriptionPecs == "light intensity shower rain") {
            $descriptionPecs = "Ónos eső";
        } else if ($descriptionPecs == "heavy intensity shower rain") {
            $descriptionPecs = "Ónos eső";
        } else if ($descriptionPecs == "ragged shower rain") {
            $descriptionPecs = "Ónos eső";
        } else if ($descriptionPecs == "light snow") {
            $descriptionPecs = "Hózápor";
        } else if ($descriptionPecs == "Heavy snow") {
            $descriptionPecs = "Hózápor";
        } else if ($descriptionPecs == "Sleet") {
            $descriptionPecs = "Havas eső";
        } else if ($descriptionPecs == "Light shower sleet") {
            $descriptionPecs = "Havas eső";
        } else if ($descriptionPecs == "Shower sleet") {
            $descriptionPecs = "Havas eső";
        } else if ($descriptionPecs == "Light rain and snow") {
            $descriptionPecs = "Havas eső";
        } else if ($descriptionPecs == "Rain and snow") {
            $descriptionPecs = "Havas eső";
        } else if ($descriptionPecs == "Light shower snow") {
            $descriptionPecs = "Havas eső";
        } else if ($descriptionPecs == "Shower snow") {
            $descriptionPecs = "Havas eső";
        } else if ($descriptionPecs == "Heavy shower snow") {
            $descriptionPecs = "Havas eső";
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
            $body = $client2->get('http://api.openweathermap.org/data/2.5/forecast?q=pecs&appid=86e5cbb3097836e0f2a884baa56e143a'
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


        return view('pecs', compact('descriptionPecs', 'tempPecs', 'temperatureMax1', 'temperatureMin1',
            'humidityPecs', 'windSpeedPecs', 'windDegPecs', 'ikonPecs', 'townPecs', 'tempCurrentFahrenheitPecs',
            'cloudCoverPecs', 'pressurePecs', 'sunrisePecs', 'sunsetPecs', 'temperatureFahrenheitMin1',
            'temperatureFahrenheitMax1', 'tempFeelslikePecs', 'tempFahrenheitFeelslikePecs',

            //3napos előrejelzés adatai, melyeket felhasználok jelenleg.
            'tempArray','threehoursArray',

            //5napos előrejelzés adatai, melyeket felhasználok jelenleg.
            'temperatureMax2', 'temperatureMax3', 'temperatureMax4' ,'temperatureMax5',
            'temperatureMin2', 'temperatureMin3', 'temperatureMin4', 'temperatureMin5'
        ));


    }

}
