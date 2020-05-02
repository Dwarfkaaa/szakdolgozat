<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;

class SopronController extends Controller
{
    public function index()
    {

        //jelenlegi előrejelzés
        $clientSopron = new Client();
        try {
            $bodySopron = $clientSopron->get('http://api.openweathermap.org/data/2.5/weather?q=sopron&appid=86e5cbb3097836e0f2a884baa56e143a'
            )->getBody()->getContents();

        } catch (ClientException $e) {}

        $jsonSopron = json_decode($bodySopron, true);
        $descriptionSopron = $jsonSopron['weather'][0]['description'];              //leírás
        $tempSopron = round(($jsonSopron['main']['temp'] - 273)); //fok     //jelenlegi hőm.
        $tempCurrentFahrenheitSopron = round(($tempSopron * 9 / 5) + 32); //fahrenheit     //jelenlegi hőm.
        $szelesseg = $jsonSopron['coord']['lat']; //hosszusag
        $hosszusag = $jsonSopron['coord']['lon']; //szelesseg
        $humiditySopron = $jsonSopron['main']['humidity'];              //páratartalom
        $windSpeedSopron = round($jsonSopron['wind']['speed']) * 3.6;  //szélsebesség
        $cloudCoverSopron = $jsonSopron['clouds']['all'];  //felhozet szazalekban
        $pressureSopron = $jsonSopron['main']['pressure']; //legnyomas

        $timezoneSopron = $jsonSopron['timezone'];
        $sunriseSecSopron = $jsonSopron['sys']['sunrise'] + $timezoneSopron;
        $sunriseSopron = date('H:i', $sunriseSecSopron);  //napkelte
        $sunsetSecSopron = $jsonSopron['sys']['sunset'] + $timezoneSopron;
        $sunsetSopron = date('H:i', $sunsetSecSopron); //napnyugta

        $tempFeelslikeSopron = round(($jsonSopron ['main']['feels_like'] - 273)); //fok  hoerzet
        $tempFahrenheitFeelslikeSopron = round(($tempFeelslikeSopron * 9 / 5) + 32); //fahrenheit hoerzet

        //ikon
        foreach ($jsonSopron['weather'] as &$value) {

            $value['kep'] = 'images/' . $value['icon'] . '.png';
            $ikonSopron = $value['kep'];
        }

        //szélirány
        if (!isset($jsonSopron['wind']['deg'])) {
            $windDegSopron = "Nincs adat";
        } else {
            $windDegSopron = $jsonSopron['wind']['deg'];
        }

        if ($windDegSopron == "") {
            $windDegSopron = "Nincs adat";
        } else if ($windDegSopron < 90 && $windDegSopron >= 0) {
            $windDegSopron = 'images/ek.svg';
        } else if ($windDegSopron == 90) {
            $windDegSopron = 'images/k.svg';
        } else if ($windDegSopron > 90 && $windDegSopron < 180) {
            $windDegSopron = 'images/dk.svg';
        } else if ($windDegSopron >= 180 && $windDegSopron < 240) {
            $windDegSopron = 'images/dny.svg';
        } else if ($windDegSopron == 240) {
            $windDegSopron = 'images/ny.svg';
        } else if ($windDegSopron > 240 && $windDegSopron <= 360) {
            $windDegSopron = 'images/eny.svg';
        } else if ($windDegSopron == 0) {
            $windDegSopron = "Nincs";
        }

        //ido...
        if ($descriptionSopron == "clear sky") {
            $descriptionSopron = "Derült idő";
        } else if ($descriptionSopron == "few clouds") {
            $descriptionSopron = "Néhol felhős";
        } else if ($descriptionSopron == "fog") {
            $descriptionSopron = "Ködös idő";
        } else if ($descriptionSopron == "light rain") {
            $descriptionSopron = "Gyenge eső";
        } else if ($descriptionSopron == "scattered clouds") {
            $descriptionSopron = "Szétszórtan felhős";
        } else if ($descriptionSopron == "overcast clouds") {
            $descriptionSopron = "Erősen felhős";
        } else if ($descriptionSopron == "broken clouds") {
            $descriptionSopron = "Borult idő";
        } else if ($descriptionSopron == "shower rain") {
            $descriptionSopron = "Ónos eső ";
        } else if ($descriptionSopron == "rain") {
            $descriptionSopron = "Eső";
        } else if ($descriptionSopron == "thunderstorm") {
            $descriptionSopron = "Zivatar";
        } else if ($descriptionSopron == "snow") {
            $descriptionSopron = "Hózápor";
        } else if ($descriptionSopron == "mist") {
            $descriptionSopron = "Ködös idő";
        } else if ($descriptionSopron == "haze") {
            $descriptionSopron = "Ködös idő";
        } else if ($descriptionSopron == "smoke") {
            $descriptionSopron = "Ködös idő";
        } else if ($descriptionSopron == "thunderstorm with light rain") {
            $descriptionSopron = "Zivatar gyenge esővel";
        } else if ($descriptionSopron == "thunderstorm with heavy rain") {
            $descriptionSopron = "Heves zivatar";
        } else if ($descriptionSopron == "light thunderstorm") {
            $descriptionSopron = "Zivatar";
        } else if ($descriptionSopron == "heavy thunderstorm") {
            $descriptionSopron = "Heves zivatar";
        } else if ($descriptionSopron == "ragged thunderstorm") {
            $descriptionSopron = "Heves zivatar";
        } else if ($descriptionSopron == "thunderstorm with light drizzle") {
            $descriptionSopron = "Gyenge zivatar";
        } else if ($descriptionSopron == "thunderstorm with drizzle") {
            $descriptionSopron = "Gyenge zivatar";
        } else if ($descriptionSopron == "thunderstorm with heavy drizzle") {
            $descriptionSopron = "Heves zivatar";
        } else if ($descriptionSopron == "light intensity drizzle") {
            $descriptionSopron = "Eső";
        } else if ($descriptionSopron == "light intensity drizzle") {
            $descriptionSopron = "Eső";
        } else if ($descriptionSopron == "drizzle") {
            $descriptionSopron = "Eső";
        } else if ($descriptionSopron == "heavy intensity drizzle") {
            $descriptionSopron = "Eső";
        } else if ($descriptionSopron == "light intensity drizzle rain") {
            $descriptionSopron = "Eső";
        } else if ($descriptionSopron == "drizzle rain") {
            $descriptionSopron = "Eső";
        } else if ($descriptionSopron == "heavy intensity drizzle rain") {
            $descriptionSopron = "Eső";
        } else if ($descriptionSopron == "shower rain and drizzle") {
            $descriptionSopron = "Eső";
        } else if ($descriptionSopron == "heavy shower rain and drizzle") {
            $descriptionSopron = "Eső";
        } else if ($descriptionSopron == "shower drizzle") {
            $descriptionSopron = "Eső";
        } else if ($descriptionSopron == "light rain") {
            $descriptionSopron = "Eső";
        } else if ($descriptionSopron == "moderate rain") {
            $descriptionSopron = "Eső";
        } else if ($descriptionSopron == "heavy intensity rain") {
            $descriptionSopron = "Eső";
        } else if ($descriptionSopron == "very heavy rain") {
            $descriptionSopron = "Eső";
        } else if ($descriptionSopron == "extreme rain") {
            $descriptionSopron = "Eső";
        } else if ($descriptionSopron == "freezing rain") {
            $descriptionSopron = "Ónos eső";
        } else if ($descriptionSopron == "light intensity shower rain") {
            $descriptionSopron = "Ónos eső";
        } else if ($descriptionSopron == "heavy intensity shower rain") {
            $descriptionSopron = "Ónos eső";
        } else if ($descriptionSopron == "ragged shower rain") {
            $descriptionSopron = "Ónos eső";
        } else if ($descriptionSopron == "light snow") {
            $descriptionSopron = "Hózápor";
        } else if ($descriptionSopron == "Heavy snow") {
            $descriptionSopron = "Hózápor";
        } else if ($descriptionSopron == "Sleet") {
            $descriptionSopron = "Havas eső";
        } else if ($descriptionSopron == "Light shower sleet") {
            $descriptionSopron = "Havas eső";
        } else if ($descriptionSopron == "Shower sleet") {
            $descriptionSopron = "Havas eső";
        } else if ($descriptionSopron == "Light rain and snow") {
            $descriptionSopron = "Havas eső";
        } else if ($descriptionSopron == "Rain and snow") {
            $descriptionSopron = "Havas eső";
        } else if ($descriptionSopron == "Light shower snow") {
            $descriptionSopron = "Havas eső";
        } else if ($descriptionSopron == "Shower snow") {
            $descriptionSopron = "Havas eső";
        } else if ($descriptionSopron == "Heavy shower snow") {
            $descriptionSopron = "Havas eső";
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
            $body = $client2->get('http://api.openweathermap.org/data/2.5/forecast?q=sopron&appid=86e5cbb3097836e0f2a884baa56e143a'
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


        return view('sopron', compact('descriptionSopron', 'tempSopron', 'temperatureMax1', 'temperatureMin1',
            'humiditySopron', 'windSpeedSopron', 'windDegSopron', 'ikonSopron',  'tempCurrentFahrenheitSopron',
            'cloudCoverSopron', 'pressureSopron', 'sunriseSopron', 'sunsetSopron', 'temperatureFahrenheitMin1',
            'temperatureFahrenheitMax1', 'tempFeelslikeSopron', 'tempFahrenheitFeelslikeSopron',

            //3napos előrejelzés adatai, melyeket felhasználok jelenleg.
            'tempArray','threehoursArray',

            //5napos előrejelzés adatai, melyeket felhasználok jelenleg.
            'temperatureMax2', 'temperatureMax3', 'temperatureMax4' ,'temperatureMax5',
            'temperatureMin2', 'temperatureMin3', 'temperatureMin4', 'temperatureMin5'
        ));


    }

}
