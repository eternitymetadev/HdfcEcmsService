<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EcmsController;

Route::get('/', function () {
    return view('welcome');
});


// Route::post('/ecms/receive', [EcmsController::class, 'receiveTransaction']);