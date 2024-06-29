<?php

use App\Http\Controllers\ApplicationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\front\JobController as FrontJobController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\VacancyController;
use App\Http\Middleware\CanManageJob;

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

Route::post('employer-registration',[AuthController::class,'employerRegistration']);
Route::post('user-registration',[AuthController::class,'seekerRegistration']);
Route::post('login',[AuthController::class,'login']);

Route::get('filter-job',[FrontJobController::class,'filter']);
Route::get('job/{id}/detail',[FrontJobController::class,'detail']);

Route::middleware('auth:sanctum')->group(function () {
    Route::group(['middleware' => ['role:super-admin']], function () {
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


    });
    Route::group(['middleware' => ['role:employer']], function () {
        Route::prefix('company')->group(function () {
            Route::get('/',[CompanyController::class,'index']); //for both (get/edit)
            Route::post('store',[CompanyController::class,'store']);
            Route::put('/{id}/update',[CompanyController::class,'update']);
        });

        Route::prefix('vacancy')->group(function () {
            Route::get('/',[VacancyController::class,'index']); //for both (get/edit)
            Route::post('store',[VacancyController::class,'store']);
            Route::get('/{id}/edit',[VacancyController::class,'edit'])->middleware(CanManageJob::class);
            Route::put('/{id}/update',[VacancyController::class,'update'])->middleware(CanManageJob::class);
            Route::delete('/{id}/delete',[VacancyController::class,'destroy'])->middleware(CanManageJob::class);
        });

        Route::prefix('application')->group(function () {
            Route::get('/list',[ApplicationController::class,'list']);
            Route::put('/{applicationId}/approval',[ApplicationController::class,'approval']);
        });
    });

    Route::group(['middleware' => ['role:seeker']], function () {
        Route::prefix('application')->group(function () {
            Route::post('/{jobId}/submit',[ApplicationController::class,'store']);
        });
    });

    Route::get('logout',[AuthController::class,'logout']);
});
