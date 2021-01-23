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


class ThreehoursController extends Controller
{
    public function threehours(Request $request)
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

        //Karakter dekodolas.
        $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'ő'=>'o', 'Ő'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ű'=>'u' , 'Ű' => 'u'  , 'ü'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );


        $char_decodeCurrent=  strtr( $town, $unwanted_array ) ;


        $client = new Client();
        try {
            $body = $client->get('http://api.openweathermap.org/data/2.5/forecast?q='. $char_decodeCurrent .'&appid=86e5cbb3097836e0f2a884baa56e143a'
            )->getBody()->getContents();

        } catch (ClientException $e) {
            return view('threehoursForecast', compact('closest'));
        }

        $json = json_decode($body, true);

        // 3 orasnkenti objektumok eltarolasa
        $tempArray = array();
        $threehoursArray = array();
        $threehoursSubstrArray = array();
        $threehoursSubstrArrayOra = array();
        $ikonArray = array();
        $cloudsArray = array();
        $windArray = array();
        $szeliranyArray = array();

        foreach($json['list'] as  &$value) {

            $value['kep']  = 'images/' . $value['weather'][0]['icon'] . '.png';
            $szelirany = $value['wind']['deg'];
            $temp = round($value['main']['temp'] - 273); //fok
            $threehours = $value['dt_txt'];   //datum
            $threehoursSubstr = substr($threehours, 5);
            $threehoursSubstrOra = substr($threehours, 11, 5);

            $ikon = $value['kep'];  //ikon
            $clouds = $value['clouds']['all']; // felhőzet %

            if (!isset($value['wind']['speed'])) {
                $wind = "Nincs adat";
            } else {
                $wind = round($value['wind']['speed'] * 3.6)   ;                //szélsebesség
            }

            if (!isset($value['wind']['deg'])) {
                $szelirany = "Nincs adat";
            } else {
                $szelirany = $value['wind']['deg'];                    //szélirány
            }

            if ($szelirany == "") {
                $szelirany = "Nincs adat";
            } else if ($szelirany < 90 && $szelirany >= 0) {
                $szelirany = 'images/ek.svg';
            } else if ($szelirany == 90) {
                $szelirany = 'images/k.svg';
            } else if ($szelirany > 90 && $szelirany < 180) {
                $szelirany = 'images/dk.svg';
            } else if ($szelirany >= 180 && $szelirany < 240) {
                $szelirany = 'images/dny.svg';
            } else if ($szelirany == 240) {
                $szelirany = 'images/ny.svg';
            } else if ($szelirany > 240 && $szelirany <= 360) {
                $szelirany = 'images/eny.svg';
            } else if ($szelirany == 0) {
                $szelirany = "Nincs";
            }

            $windArray[] = $wind;
            $cloudsArray[] = $clouds;
            $ikonArray[] = $ikon;
            $threehoursArray[] = $threehours;
            $threehoursSubstrArray[] = $threehoursSubstr;
            $threehoursSubstrArrayOra[] = $threehoursSubstrOra;

            $tempArray[] = $temp;
            $szeliranyArray[] = $szelirany;

        }

        //fahrenheit átszámitás
        $temperatureFahrenheitMax1 = round(($tempArray[0] * 9/5)+32);
        $temperatureFahrenheitMax2 = round(($tempArray[1] * 9/5)+32);
        $temperatureFahrenheitMax3 = round(($tempArray[2] * 9/5)+32);
        $temperatureFahrenheitMax4 = round(($tempArray[3] * 9/5)+32);
        $temperatureFahrenheitMax5 = round(($tempArray[4] * 9/5)+32);
        $temperatureFahrenheitMax6 = round(($tempArray[5] * 9/5)+32);
        $temperatureFahrenheitMax7 = round(($tempArray[6] * 9/5)+32);
        $temperatureFahrenheitMax8 = round(($tempArray[7] * 9/5)+32);
        $temperatureFahrenheitMax9 = round(($tempArray[8] * 9/5)+32);
        $temperatureFahrenheitMax10 = round(($tempArray[9] * 9/5)+32);
        $temperatureFahrenheitMax11 = round(($tempArray[10] * 9/5)+32);


        //JELENLEGI IDOJARAS API, a jelenlegi adatok kiszuresere
        $client2 = new Client();
        try {
            $threehoursWeatherKiiratasmiatt = $client2->get('http://api.openweathermap.org/data/2.5/weather?q='. $char_decodeCurrent .'&appid=86e5cbb3097836e0f2a884baa56e143a'

            )->getBody()->getContents();
        } catch (ClientException $e) {}

        $kiiratas = json_decode($threehoursWeatherKiiratasmiatt, true);
        $kiiratasCurrent = $kiiratas['name'];
        $description = $kiiratas['weather'][0]['description'];
        foreach ($kiiratas['weather'] as &$value) {

            $value['kep'] = 'images/' . $value['icon'] . '.png';
            $ikonCurrent = $value['kep'];
        }
        $tempCurrent = round(($kiiratas['main']['temp'] - 273)); //fok     //jelenlegi hőm.
        $tempCurrentFahrenheit = round(($tempCurrent * 9/5)+32); //fahrenheit     //jelenlegi hőm.

        //////////////////////////////////

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

        return view('threehoursForecast', compact('windArray','tempArray','cloudsArray','tempCurrent', 'threehoursArray', 'ikonCurrent', 'kiiratasCurrent',
            'body' , 'closest', 'ikonArray', 'description', 'tempCurrentFahrenheit',
            'temperatureFahrenheitMax1','temperatureFahrenheitMax2','temperatureFahrenheitMax3'
            ,'temperatureFahrenheitMax4','temperatureFahrenheitMax5','temperatureFahrenheitMax6'
            ,'temperatureFahrenheitMax7','temperatureFahrenheitMax8','temperatureFahrenheitMax9'
            ,'temperatureFahrenheitMax10','temperatureFahrenheitMax11', 'szeliranyArray', 'threehoursSubstrArray','threehoursSubstrArrayOra'));




    }
}
