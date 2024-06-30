<?php

use App\Mail\RegisterMail;
use App\Jobs\SendRegisteredMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('send-mail',function(){
    $userMail='bishalcodeslaravel@gmail.com';
    // dispatch(new SendRegisteredMail($userMail));
    $application=[
        'id'=>'1',
        'name'=>'Bishal',
    ];
    Mail::to($userMail)->send(new RegisterMail($application));
});
