<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;

class DebrecenController extends Controller
{
    public function index()
    {

        //jelenlegi időjárás
        $clientDeb = new Client();
        try {
            $bodyDeb = $clientDeb->get('http://api.openweathermap.org/data/2.5/weather?q=debrecen&appid=86e5cbb3097836e0f2a884baa56e143a'
            )->getBody()->getContents();

        } catch (ClientException $e) {}

        $jsonDeb = json_decode($bodyDeb, true);
        $descriptionDeb = $jsonDeb['weather'][0]['description'];              //leírás
        $tempDeb = round(($jsonDeb['main']['temp'] - 273)); //fok     //jelenlegi hőm.
        $tempCurrentFahrenheitDeb = round(($tempDeb * 9 / 5) + 32); //fahrenheit     //jelenlegi hőm.
        $szelesseg = $jsonDeb['coord']['lat']; //hosszusag
        $hosszusag = $jsonDeb['coord']['lon']; //szelesseg
        $humidityDeb = $jsonDeb['main']['humidity'];              //páratartalom
        $windSpeedDeb = round($jsonDeb['wind']['speed']) * 3.6;  //szélsebesség
        $cloudCoverDeb = $jsonDeb['clouds']['all'];  //felhozet szazalekban
        $pressureDeb = $jsonDeb['main']['pressure']; //legnyomas

        $timezoneDeb = $jsonDeb['timezone'];
        $sunriseSecDeb = $jsonDeb['sys']['sunrise'] + $timezoneDeb;
        $sunriseDeb = date('H:i', $sunriseSecDeb);  //napkelte
        $sunsetSecDeb = $jsonDeb['sys']['sunset'] + $timezoneDeb;
        $sunsetDeb = date('H:i', $sunsetSecDeb); //napnyugta

        $tempFeelslikeDeb = round(($jsonDeb ['main']['feels_like'] - 273)); //fok  hoerzet
        $tempFahrenheitFeelslikeDeb = round(($tempFeelslikeDeb * 9 / 5) + 32); //fahrenheit hoerzet

        //ikon
        foreach ($jsonDeb['weather'] as &$value) {

            $value['kep'] = 'images/' . $value['icon'] . '.png';
            $ikonDeb = $value['kep'];
        }

        //szélirány
        if (!isset($jsonDeb['wind']['deg'])) {
            $windDegDeb = "Nincs adat";
        } else {
            $windDegDeb = $jsonDeb['wind']['deg'];
        }

        if ($windDegDeb == "") {
            $windDegDeb = "Nincs adat";
        } else if ($windDegDeb < 90 && $windDegDeb >= 0) {
            $windDegDeb = 'images/ek.svg';
        } else if ($windDegDeb == 90) {
            $windDegDeb = 'images/k.svg';
        } else if ($windDegDeb > 90 && $windDegDeb < 180) {
            $windDegDeb = 'images/dk.svg';
        } else if ($windDegDeb >= 180 && $windDegDeb < 240) {
            $windDegDeb = 'images/dny.svg';
        } else if ($windDegDeb == 240) {
            $windDegDeb = 'images/ny.svg';
        } else if ($windDegDeb > 240 && $windDegDeb <= 360) {
            $windDegDeb = 'images/eny.svg';
        } else if ($windDegDeb == 0) {
            $windDegDeb = "Nincs";
        }

        //ido...
        if ($descriptionDeb == "clear sky") {
            $descriptionDeb = "Derült idő";
        } else if ($descriptionDeb == "few clouds") {
            $descriptionDeb = "Néhol felhős";
        } else if ($descriptionDeb == "fog") {
            $descriptionDeb = "Ködös idő";
        } else if ($descriptionDeb == "light rain") {
            $descriptionDeb = "Gyenge eső";
        } else if ($descriptionDeb == "scattered clouds") {
            $descriptionDeb = "Szétszórtan felhős";
        } else if ($descriptionDeb == "overcast clouds") {
            $descriptionDeb = "Erősen felhős";
        } else if ($descriptionDeb == "broken clouds") {
            $descriptionDeb = "Borult idő";
        } else if ($descriptionDeb == "shower rain") {
            $descriptionDeb = "Ónos eső ";
        } else if ($descriptionDeb == "rain") {
            $descriptionDeb = "Eső";
        } else if ($descriptionDeb == "thunderstorm") {
            $descriptionDeb = "Zivatar";
        } else if ($descriptionDeb == "snow") {
            $descriptionDeb = "Hózápor";
        } else if ($descriptionDeb == "mist") {
            $descriptionDeb = "Ködös idő";
        } else if ($descriptionDeb == "haze") {
            $descriptionDeb = "Ködös idő";
        } else if ($descriptionDeb == "smoke") {
            $descriptionDeb = "Ködös idő";
        } else if ($descriptionDeb == "thunderstorm with light rain") {
            $descriptionDeb = "Zivatar gyenge esővel";
        } else if ($descriptionDeb == "thunderstorm with heavy rain") {
            $descriptionDeb = "Heves zivatar";
        } else if ($descriptionDeb == "light thunderstorm") {
            $descriptionDeb = "Zivatar";
        } else if ($descriptionDeb == "heavy thunderstorm") {
            $descriptionDeb = "Heves zivatar";
        } else if ($descriptionDeb == "ragged thunderstorm") {
            $descriptionDeb = "Heves zivatar";
        } else if ($descriptionDeb == "thunderstorm with light drizzle") {
            $descriptionDeb = "Gyenge zivatar";
        } else if ($descriptionDeb == "thunderstorm with drizzle") {
            $descriptionDeb = "Gyenge zivatar";
        } else if ($descriptionDeb == "thunderstorm with heavy drizzle") {
            $descriptionDeb = "Heves zivatar";
        } else if ($descriptionDeb == "light intensity drizzle") {
            $descriptionDeb = "Eső";
        } else if ($descriptionDeb == "light intensity drizzle") {
            $descriptionDeb = "Eső";
        } else if ($descriptionDeb == "drizzle") {
            $descriptionDeb = "Eső";
        } else if ($descriptionDeb == "heavy intensity drizzle") {
            $descriptionDeb = "Eső";
        } else if ($descriptionDeb == "light intensity drizzle rain") {
            $descriptionDeb = "Eső";
        } else if ($descriptionDeb == "drizzle rain") {
            $descriptionDeb = "Eső";
        } else if ($descriptionDeb == "heavy intensity drizzle rain") {
            $descriptionDeb = "Eső";
        } else if ($descriptionDeb == "shower rain and drizzle") {
            $descriptionDeb = "Eső";
        } else if ($descriptionDeb == "heavy shower rain and drizzle") {
            $descriptionDeb = "Eső";
        } else if ($descriptionDeb == "shower drizzle") {
            $descriptionDeb = "Eső";
        } else if ($descriptionDeb == "light rain") {
            $descriptionDeb = "Eső";
        } else if ($descriptionDeb == "moderate rain") {
            $descriptionDeb = "Eső";
        } else if ($descriptionDeb == "heavy intensity rain") {
            $descriptionDeb = "Eső";
        } else if ($descriptionDeb == "very heavy rain") {
            $descriptionDeb = "Eső";
        } else if ($descriptionDeb == "extreme rain") {
            $descriptionDeb = "Eső";
        } else if ($descriptionDeb == "freezing rain") {
            $descriptionDeb = "Ónos eső";
        } else if ($descriptionDeb == "light intensity shower rain") {
            $descriptionDeb = "Ónos eső";
        } else if ($descriptionDeb == "heavy intensity shower rain") {
            $descriptionDeb = "Ónos eső";
        } else if ($descriptionDeb == "ragged shower rain") {
            $descriptionDeb = "Ónos eső";
        } else if ($descriptionDeb == "light snow") {
            $descriptionDeb = "Hózápor";
        } else if ($descriptionDeb == "Heavy snow") {
            $descriptionDeb = "Hózápor";
        } else if ($descriptionDeb == "Sleet") {
            $descriptionDeb = "Havas eső";
        } else if ($descriptionDeb == "Light shower sleet") {
            $descriptionDeb = "Havas eső";
        } else if ($descriptionDeb == "Shower sleet") {
            $descriptionDeb = "Havas eső";
        } else if ($descriptionDeb == "Light rain and snow") {
            $descriptionDeb = "Havas eső";
        } else if ($descriptionDeb == "Rain and snow") {
            $descriptionDeb = "Havas eső";
        } else if ($descriptionDeb == "Light shower snow") {
            $descriptionDeb = "Havas eső";
        } else if ($descriptionDeb == "Shower snow") {
            $descriptionDeb = "Havas eső";
        } else if ($descriptionDeb == "Heavy shower snow") {
            $descriptionDeb = "Havas eső";
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
            $body = $client2->get('http://api.openweathermap.org/data/2.5/forecast?q=debrecen&appid=86e5cbb3097836e0f2a884baa56e143a'
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





        return view('debrecen', compact('descriptionDeb', 'tempDeb', 'temperatureMax1', 'temperatureMin1',
            'humidityDeb', 'windSpeedDeb', 'windDegDeb', 'ikonDeb', 'tempCurrentFahrenheitDeb',
            'cloudCoverDeb', 'pressureDeb', 'sunriseDeb', 'sunsetDeb', 'temperatureFahrenheitMin1',
            'temperatureFahrenheitMax1', 'tempFeelslikeDeb', 'tempFahrenheitFeelslikeDeb',

            //3napos előrejelzés adatai, melyeket felhasználok jelenleg.
            'tempArray','threehoursArray',

            //5napos előrejelzés adatai, melyeket felhasználok jelenleg.
            'temperatureMax2', 'temperatureMax3', 'temperatureMax4' ,'temperatureMax5',
            'temperatureMin2', 'temperatureMin3', 'temperatureMin4', 'temperatureMin5'
        ));


    }

}
