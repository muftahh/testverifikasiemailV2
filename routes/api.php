<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ActivationController;

Route::post('/send-activation-email', [ActivationController::class, 'sendActivationEmail']);
