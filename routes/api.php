<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\ProvinceController;
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

Route::post('registration',[AuthController::class,'registration']);

Route::prefix('country')->group(function () {
    Route::get('/',[CountryController::class,'index']);
    Route::post('store',[CountryController::class,'store']);
    Route::get('/{id}/edit',[CountryController::class,'edit']);
    Route::put('/{id}/update',[CountryController::class,'update']);
    Route::delete('/{id}/delete',[CountryController::class,'destroy']);
});

Route::prefix('province')->group(function () {
    Route::get('/',[ProvinceController::class,'index']);
    Route::post('store',[ProvinceController::class,'store']);
    Route::get('/{id}/edit',[ProvinceController::class,'edit']);
    Route::put('/{id}/update',[ProvinceController::class,'update']);
    Route::delete('/{id}/delete',[ProvinceController::class,'destroy']);
});

Route::prefix('district')->group(function () {
    Route::get('/',[DistrictController::class,'index']);
    Route::post('store',[DistrictController::class,'store']);
    Route::get('/{id}/edit',[DistrictController::class,'edit']);
    Route::put('/{id}/update',[DistrictController::class,'update']);
    Route::delete('/{id}/delete',[DistrictController::class,'destroy']);
});

Route::prefix('municipality')->group(function () {
    Route::get('/',[MunicipalityController::class,'index']);
    Route::post('store',[MunicipalityController::class,'store']);
    Route::get('/{id}/edit',[MunicipalityController::class,'edit']);
    Route::put('/{id}/update',[MunicipalityController::class,'update']);
    Route::delete('/{id}/delete',[MunicipalityController::class,'destroy']);
});
