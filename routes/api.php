<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\User\CategoryController;
use App\Http\Controllers\API\User\ProductController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login')->name('login');
    Route::post('forgot-password', 'forgotPassword');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('current-user', [AuthController::class, 'currentUser']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::post('change-password', [AuthController::class, 'changePassword']);
    Route::post('profile', [AuthController::class, 'updateProfile']);
});

Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    Route::resource('category', CategoryController::class);
    Route::resource('product', ProductController::class);

    Route::middleware('auth:sanctum')->group(function () {
        // Keranjang
    });
});
