<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\StatusController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\TeamController;
use App\Http\Controllers\api\AttendanceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'statuses'], function (){
    Route::get('/', [StatusController::class, 'index']);
});

Route::group(['prefix' => 'users'], function (){
    Route::get('/names', [UserController::class, 'names']);
});

Route::group(['prefix' => 'teams'], function (){
    Route::get('/names', [TeamController::class, 'names']);
});

Route::group(['prefix' => 'attendances'], function(){
    Route::get('/', [AttendanceController::class, 'index'])->middleware('pagination');
});
