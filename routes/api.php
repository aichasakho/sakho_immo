<?php

use App\Http\Controllers\BienController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Biens
Route::apiResource('biens', BienController::class);
Route::post('/biens', [BienController::class, 'store']);
Route::put('/biens/{id}', [BienController::class, 'update']);
<<<<<<< HEAD
Route::delete('/biens/{id}', [BienController::class, 'destroy']);
=======
>>>>>>> 7a929f142c0fa72b7766e2ace77cb68096b6e904

//User
Route::post('utilisateur/{id}/bloquer', [UserController::class, 'bloquer']);
Route::post('utilisateur/{id}/debloquer', [UserController::class, 'debloquer']);

//Reservation
Route::post('reservations', [ReservationController::class, 'store']);
