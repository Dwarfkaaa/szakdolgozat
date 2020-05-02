<?php

namespace App\Http\Controllers;

use App\Item_model;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class KezdolapController extends Controller
{
    public function index(Request $request)
    {
        return view('kezdolap');

    }

    public function autocomplete(Request $request)
    {

        $data = Item_model::select("name")->where("name", "LIKE", "{$request->input('name')}%")->get();
        str_replace(' ', '', strtolower($data));
        $autocomplete = response()->json($data);
        return $autocomplete;

    }
}
