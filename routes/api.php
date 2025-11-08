<?php

use App\Http\Controllers\Authenticate\{LoginController, LogoutController, RegisterController};
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::get('/', function () {

        return response()->json([
            'success' => true,
            'data' => [
                'title' => 'API',
                'version' => '1.0',
                'author' => 'Darlysman'
            ]
        ], Response::HTTP_ACCEPTED);
    });
});


Route::prefix('v1/auth')->group(function () {

    Route::post('/login', [LoginController::class, '__invoke']);
    Route::post('/logout', [LogoutController::class, '__invoke']);
    Route::post('/register', [RegisterController::class, '__invoke']);
});
