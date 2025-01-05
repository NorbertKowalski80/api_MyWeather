<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class apiMyWeather extends Controller
{
    public function index() {

        $response = Http::get('http://api.openweathermap.org/data/2.5/forecast/daily?lat=51.1&lon=17.033&cnt=9&appid=8dda4ea543bc17f640e62f7070cc7a7b&units=metric&lang=pl');
        
        if($response->failed()) {
            abort(500);
        }

        $body = $response->json();

        //dd($body);

        return view('welcome', [
            'data' => $body
        ]);
    }
}
