<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;

class SzegedController extends Controller
{
    public function index()
    {

        //jelenlegi előrejelzés
        $clientSzeged = new Client();
        try {
            $bodySzeged = $clientSzeged->get('http://api.openweathermap.org/data/2.5/weather?q=szeged&appid=86e5cbb3097836e0f2a884baa56e143a'
            )->getBody()->getContents();

        } catch (ClientException $e) {}

        $jsonSzeged = json_decode($bodySzeged, true);
        $descriptionSzeged = $jsonSzeged['weather'][0]['description'];              //leírás
        $tempSzeged = round(($jsonSzeged['main']['temp'] - 273)); //fok     //jelenlegi hőm.
        $tempCurrentFahrenheitSzeged = round(($tempSzeged * 9 / 5) + 32); //fahrenheit     //jelenlegi hőm.
        $szelesseg = $jsonSzeged['coord']['lat']; //hosszusag
        $hosszusag = $jsonSzeged['coord']['lon']; //szelesseg
        $humiditySzeged = $jsonSzeged['main']['humidity'];              //páratartalom
        $windSpeedSzeged = round($jsonSzeged['wind']['speed']) * 3.6;  //szélsebesség
        $cloudCoverSzeged = $jsonSzeged['clouds']['all'];  //felhozet szazalekban
        $pressureSzeged = $jsonSzeged['main']['pressure']; //legnyomas

        $timezoneSzeged = $jsonSzeged['timezone'];
        $sunriseSecSzeged = $jsonSzeged['sys']['sunrise'] + $timezoneSzeged;
        $sunriseSzeged = date('H:i', $sunriseSecSzeged);  //napkelte
        $sunsetSecSzeged = $jsonSzeged['sys']['sunset'] + $timezoneSzeged;
        $sunsetSzeged = date('H:i', $sunsetSecSzeged); //napnyugta

        $tempFeelslikeSzeged = round(($jsonSzeged ['main']['feels_like'] - 273)); //fok  hoerzet
        $tempFahrenheitFeelslikeSzeged = round(($tempFeelslikeSzeged * 9 / 5) + 32); //fahrenheit hoerzet

        //ikon
        foreach ($jsonSzeged['weather'] as &$value) {

            $value['kep'] = 'images/' . $value['icon'] . '.png';
            $ikonSzeged = $value['kep'];
        }

        //szélirány
        if (!isset($jsonSzeged['wind']['deg'])) {
            $windDegSzeged = "Nincs adat";
        } else {
            $windDegSzeged = $jsonSzeged['wind']['deg'];
        }

        if ($windDegSzeged == "") {
            $windDegSzeged = "Nincs adat";
        } else if ($windDegSzeged < 90 && $windDegSzeged >= 0) {
            $windDegSzeged = 'images/ek.svg';
        } else if ($windDegSzeged == 90) {
            $windDegSzeged = 'images/k.svg';
        } else if ($windDegSzeged > 90 && $windDegSzeged < 180) {
            $windDegSzeged = 'images/dk.svg';
        } else if ($windDegSzeged >= 180 && $windDegSzeged < 240) {
            $windDegSzeged = 'images/dny.svg';
        } else if ($windDegSzeged == 240) {
            $windDegSzeged = 'images/ny.svg';
        } else if ($windDegSzeged > 240 && $windDegSzeged <= 360) {
            $windDegSzeged = 'images/eny.svg';
        } else if ($windDegSzeged == 0) {
            $windDegSzeged = "Nincs";
        }

        //ido...
        if ($descriptionSzeged == "clear sky") {
            $descriptionSzeged = "Derült idő";
        } else if ($descriptionSzeged == "few clouds") {
            $descriptionSzeged = "Néhol felhős";
        } else if ($descriptionSzeged == "fog") {
            $descriptionSzeged = "Ködös idő";
        } else if ($descriptionSzeged == "light rain") {
            $descriptionSzeged = "Gyenge eső";
        } else if ($descriptionSzeged == "scattered clouds") {
            $descriptionSzeged = "Szétszórtan felhős";
        } else if ($descriptionSzeged == "overcast clouds") {
            $descriptionSzeged = "Erősen felhős";
        } else if ($descriptionSzeged == "broken clouds") {
            $descriptionSzeged = "Borult idő";
        } else if ($descriptionSzeged == "shower rain") {
            $descriptionSzeged = "Ónos eső ";
        } else if ($descriptionSzeged == "rain") {
            $descriptionSzeged = "Eső";
        } else if ($descriptionSzeged == "thunderstorm") {
            $descriptionSzeged = "Zivatar";
        } else if ($descriptionSzeged == "snow") {
            $descriptionSzeged = "Hózápor";
        } else if ($descriptionSzeged == "mist") {
            $descriptionSzeged = "Ködös idő";
        } else if ($descriptionSzeged == "haze") {
            $descriptionSzeged = "Ködös idő";
        } else if ($descriptionSzeged == "smoke") {
            $descriptionSzeged = "Ködös idő";
        } else if ($descriptionSzeged == "thunderstorm with light rain") {
            $descriptionSzeged = "Zivatar gyenge esővel";
        } else if ($descriptionSzeged == "thunderstorm with heavy rain") {
            $descriptionSzeged = "Heves zivatar";
        } else if ($descriptionSzeged == "light thunderstorm") {
            $descriptionSzeged = "Zivatar";
        } else if ($descriptionSzeged == "heavy thunderstorm") {
            $descriptionSzeged = "Heves zivatar";
        } else if ($descriptionSzeged == "ragged thunderstorm") {
            $descriptionSzeged = "Heves zivatar";
        } else if ($descriptionSzeged == "thunderstorm with light drizzle") {
            $descriptionSzeged = "Gyenge zivatar";
        } else if ($descriptionSzeged == "thunderstorm with drizzle") {
            $descriptionSzeged = "Gyenge zivatar";
        } else if ($descriptionSzeged == "thunderstorm with heavy drizzle") {
            $descriptionSzeged = "Heves zivatar";
        } else if ($descriptionSzeged == "light intensity drizzle") {
            $descriptionSzeged = "Eső";
        } else if ($descriptionSzeged == "light intensity drizzle") {
            $descriptionSzeged = "Eső";
        } else if ($descriptionSzeged == "drizzle") {
            $descriptionSzeged = "Eső";
        } else if ($descriptionSzeged == "heavy intensity drizzle") {
            $descriptionSzeged = "Eső";
        } else if ($descriptionSzeged == "light intensity drizzle rain") {
            $descriptionSzeged = "Eső";
        } else if ($descriptionSzeged == "drizzle rain") {
            $descriptionSzeged = "Eső";
        } else if ($descriptionSzeged == "heavy intensity drizzle rain") {
            $descriptionSzeged = "Eső";
        } else if ($descriptionSzeged == "shower rain and drizzle") {
            $descriptionSzeged = "Eső";
        } else if ($descriptionSzeged == "heavy shower rain and drizzle") {
            $descriptionSzeged = "Eső";
        } else if ($descriptionSzeged == "shower drizzle") {
            $descriptionSzeged = "Eső";
        } else if ($descriptionSzeged == "light rain") {
            $descriptionSzeged = "Eső";
        } else if ($descriptionSzeged == "moderate rain") {
            $descriptionSzeged = "Eső";
        } else if ($descriptionSzeged == "heavy intensity rain") {
            $descriptionSzeged = "Eső";
        } else if ($descriptionSzeged == "very heavy rain") {
            $descriptionSzeged = "Eső";
        } else if ($descriptionSzeged == "extreme rain") {
            $descriptionSzeged = "Eső";
        } else if ($descriptionSzeged == "freezing rain") {
            $descriptionSzeged = "Ónos eső";
        } else if ($descriptionSzeged == "light intensity shower rain") {
            $descriptionSzeged = "Ónos eső";
        } else if ($descriptionSzeged == "heavy intensity shower rain") {
            $descriptionSzeged = "Ónos eső";
        } else if ($descriptionSzeged == "ragged shower rain") {
            $descriptionSzeged = "Ónos eső";
        } else if ($descriptionSzeged == "light snow") {
            $descriptionSzeged = "Hózápor";
        } else if ($descriptionSzeged == "Heavy snow") {
            $descriptionSzeged = "Hózápor";
        } else if ($descriptionSzeged == "Sleet") {
            $descriptionSzeged = "Havas eső";
        } else if ($descriptionSzeged == "Light shower sleet") {
            $descriptionSzeged = "Havas eső";
        } else if ($descriptionSzeged == "Shower sleet") {
            $descriptionSzeged = "Havas eső";
        } else if ($descriptionSzeged == "Light rain and snow") {
            $descriptionSzeged = "Havas eső";
        } else if ($descriptionSzeged == "Rain and snow") {
            $descriptionSzeged = "Havas eső";
        } else if ($descriptionSzeged == "Light shower snow") {
            $descriptionSzeged = "Havas eső";
        } else if ($descriptionSzeged == "Shower snow") {
            $descriptionSzeged = "Havas eső";
        } else if ($descriptionSzeged == "Heavy shower snow") {
            $descriptionSzeged = "Havas eső";
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
            $body = $client2->get('http://api.openweathermap.org/data/2.5/forecast?q=szeged&appid=86e5cbb3097836e0f2a884baa56e143a'
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


        return view('szeged', compact('descriptionSzeged', 'tempSzeged', 'temperatureMax1', 'temperatureMin1',
            'humiditySzeged', 'windSpeedSzeged', 'windDegSzeged', 'ikonSzeged', 'townSzeged', 'tempCurrentFahrenheitSzeged',
            'cloudCoverSzeged', 'pressureSzeged', 'sunriseSzeged', 'sunsetSzeged', 'temperatureFahrenheitMin1',
            'temperatureFahrenheitMax1', 'tempFeelslikeSzeged', 'tempFahrenheitFeelslikeSzeged',

            //3napos előrejelzés adatai, melyeket felhasználok jelenleg.
            'tempArray','threehoursArray',

            //5napos előrejelzés adatai, melyeket felhasználok jelenleg.
            'temperatureMax2', 'temperatureMax3', 'temperatureMax4' ,'temperatureMax5',
            'temperatureMin2', 'temperatureMin3', 'temperatureMin4', 'temperatureMin5'
        ));


    }

}
