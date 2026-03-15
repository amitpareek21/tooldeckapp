<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tools', function () {
    return view('welcome');
});

Route::view('/json-formatter', 'tools.json-formatter');