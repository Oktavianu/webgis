<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CobaController;
//peta oke
use App\Http\Controllers\PetaController;
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
    $oke = url ('peta/11.geojson');
    return view('welcome', compact('oke'));
});

Route::get('/3', function () {
    return view('test-buton');
});

Route::get('/4', function () {
    return view('geo');
});


Route::get('/coba', [CobaController::class, 'index']);
Route::get('/tes-peta', [PetaController::class, 'index']);
Route::get('lokasi/json', [PetaController::class, 'lokasi']);



 

