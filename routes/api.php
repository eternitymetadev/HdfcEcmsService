<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EcmsController;

Route::post('/ecms/receive', [EcmsController::class, 'receiveTransaction']);
