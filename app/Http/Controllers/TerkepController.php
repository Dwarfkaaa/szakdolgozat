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

class TerkepController extends Controller
{
    public function index(){
        return view('terkep');
    }
}
