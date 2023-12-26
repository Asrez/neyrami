<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// routes/api.php

Route::post('/register', [\App\Http\Controllers\Auth\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Auth\AuthController::class, 'login']);



// routes/api.php

Route::group(['prefix' => 'v1',
    'middleware' => 'auth:sanctum'
], function () {
    // Channel routes
    Route::prefix('channels')->group(function () {
        // Route to create a new channel
        Route::post('/create', [\App\Http\Controllers\ChannelController::class, 'store']);
        // Route to subscribe to a channel
        Route::get('/{channel}/subscribe', [\App\Http\Controllers\ChannelController::class, 'subscribe']);
        // Route to unsubscribe from a channel
        Route::delete('/{channel}/unsubscribe', [\App\Http\Controllers\ChannelController::class, 'unsubscribe']);
        // Route to post a new message to a channel
        Route::post('/{channel}/messages', [\App\Http\Controllers\ChannelController::class, 'storeMessage']);
        Route::get('/{channel}/messages', [\App\Http\Controllers\MessageController::class, 'getMessageByChannelId']);

    });
    Route::prefix('users')->group(function () {
        Route::get('/', [\App\Http\Controllers\UserController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\UserController::class, 'find']);



    });
});
