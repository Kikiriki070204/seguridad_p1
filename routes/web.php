<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('register');
});

Route::post('store',[AuthController::class, 'register']);
Route::get('confirm', function(){
    return view('confirm');
})->name('confirm');

Route::get('login',function(){
    return view('login');
});
Route::post('log', [AuthController::class, 'login']);
Route::get('verify', function(){ 
return view ('verifycode');
});
Route::post('verifycode', [AuthController::class, 'verify']);