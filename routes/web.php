<?php

use App\Events\SetPlaceEvent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    event(new SetPlaceEvent("1", []));
    return view('welcome');
});

