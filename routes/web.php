<?php

use App\Http\Controllers\apiMyWeather;
use Illuminate\Support\Facades\Route;

Route::get('/', [apiMyWeather::class, 'index' ]);
