<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsultasiController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\RegistasiVaksinController;
use App\Http\Controllers\SpotsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/test', function () {
    return response()->json([
        'test' => 'oke'
    ]);
});


Route::prefix("/v1")->group(function () {

    Route::controller(AuthController::class)->group(function () {

        Route::post("/auth/login", "login");
        Route::post("/auth/register", "register");
        Route::post("/auth/logout", "logout");
        Route::get("/profile", "profile");
    });


    Route::controller(ConsultasiController::class)->group(function () {

        Route::post("/consultation", "consultasi");
        Route::get("/consultation/single", "getConsultasi");
        Route::get("/consultation", "consultasionAll");
        Route::put("/consultation/{id}/update", "updateStatus");
    });

    Route::controller(SpotsController::class)->group(function () {
        Route::get("/spots", "spots");
        Route::get("/spots/all", "index");
        Route::get("/spots/{id}", "getSpots");
    });


    Route::controller(RegistasiVaksinController::class)->group(function () {

        Route::post("/vaksinasi", "register");
        Route::put("/vaksinasi/{id}/update", "update");
        Route::get("/vaksinasi", "index");
    });


    Route::controller(DoctorController::class)->group(function () {
        Route::get("/konsultasis", "index");
        Route::get("/doctor", "DoctorAll");
        Route::put("/konsultasi/{id}/update", "update");
    });
});
