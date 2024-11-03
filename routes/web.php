<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuhuController;

Route::get('/', function () {
    return view(view: 'welcome');
});


Route::get('/suhu', [SuhuController::class, 'index']);
Route::get('/devices', [SuhuController::class, 'device'])->name('devices');

Route::get('/things', [SuhuController::class, 'thing']);
Route::get('/things/{device_id}', [SuhuController::class, 'showThings']);
Route::get('/get-things/{device_id}', [SuhuController::class, 'getThings']);
Route::get('/get-suhu-data/{device_id}', [SuhuController::class, 'getSuhuData']);
Route::get('/get-chart-data/{deviceId}', [SuhuController::class, 'getChartData']);

Route::get('/laporan/{device_id}', [SuhuController::class, 'getLaporanData']);





Route::post('/update-power-status', [SuhuController::class, 'updatePowerStatus']);

Route::post('/set-thermometer', [SuhuController::class, 'setThermometer']);
Route::post('/toggle-power', [SuhuController::class, 'togglePower']);
Route::get('/get-power-status', [SuhuController::class, 'getPowerStatus']);







