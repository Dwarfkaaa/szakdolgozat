<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class asdController extends Controller
{

    public function index(){


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.infermedica.com/v2/symptoms');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'app_id: '. '6329d318',
            'app_key: '. '2da01f18d9a0e908eaf69f276f2cb126'
        ));
        $res = curl_exec($ch);

        curl_close($ch);

        $json = (json_decode($res, true));

        return $json;

        return view('asd', compact('json'));
    }

}
