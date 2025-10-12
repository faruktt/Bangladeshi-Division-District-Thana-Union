<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeoController;

Route::get('/locations', [GeoController::class, 'index']);
Route::get('/get-districts/{division}', [GeoController::class, 'getDistricts']);
Route::get('/get-thanas/{district}', [GeoController::class, 'getThanas']);
Route::get('/get-unions/{thana}', [GeoController::class, 'getUnions']);

Route::get('/', function () {
    return view('locations.index');
});
