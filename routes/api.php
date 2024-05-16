<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\VilleController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\TrajetController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\ReservationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix("auth")->controller(AuthController::class)->group(function () {
    Route::post("'/login", 'login');
    Route::post("register", "register");
});

Route::apiResource('ville', VilleController::class);
Route::get("/trajets/classe", [TrajetController::class , "getListWithoutDoublon"]);
Route::apiResource('trajet', TrajetController::class);
Route::apiResource('vehicule', VehiculeController::class);
Route::apiResource('offre', OffreController::class);
Route::get('reservation/user', [ReservationController::class, "list"])->middleware("user"); 
Route::get('reservation/create', [ReservationController::class, "create"]);
Route::apiResource('reservation', ReservationController::class);

Route::get("/classe" , [ClasseController::class , "index"]);


Route::post("/place/set",[ PlaceController::class , "setPlace"]);
Route::post("/place/unset",[ PlaceController::class , "unSetPlace"]);


Route::put("/reservation/{reservation}/annuler",[ ReservationController::class , "annulation"])->middleware("user"); 
