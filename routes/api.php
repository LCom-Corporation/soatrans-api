<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\VilleController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\TrajetController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\ReservationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('ville', VilleController::class);
Route::apiResource('trajet', TrajetController::class);
Route::apiResource('vehicule', VehiculeController::class);
Route::apiResource('offre', OffreController::class);
Route::apiResource('reservation', ReservationController::class);

Route::get("/classe" , [ClasseController::class , "index"]);
Route::get("/trajets/classe", [TrajetController::class , "getListWithoutDoublon"]);


Route::put("/reservation/{reservation}/annuler",[ ReservationController::class , "annulation"])->middleware("user"); 
