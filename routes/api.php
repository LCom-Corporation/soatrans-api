<?php

use App\Http\Controllers\OffreController;
use App\Http\Controllers\ReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VilleController;
use App\Http\Controllers\TrajetController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('ville', VilleController::class);
Route::apiResource('trajet', TrajetController::class);
Route::apiResource('trajet', TrajetController::class);
Route::apiResource('offre', OffreController::class);
Route::apiResource('reservation', ReservationController::class);
Route::put("/reservation/annuler/{reservation}",[ ReservationController::class , "annulation"]);