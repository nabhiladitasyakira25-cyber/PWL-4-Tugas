<?php

use App\Http\Controllers\APIController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [APIController::class, 'login']);