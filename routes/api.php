<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\FileShareController;
use App\Http\Controllers\UserUsageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\StripeIntentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\UserPlanAvailabilityController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/file/{file:uuid}/download', [FileShareController::class, 'downloadFile']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/user', [UserController::class, 'getUser']);

    Route::post('/logout', [LoginController::class, 'logout']);
    Route::patch('/changePassword', [ChangePasswordController::class, 'changePassword']);

    Route::get('/files', [FileController::class, 'index']);
    Route::post('/files', [FileController::class, 'store']);
    Route::delete('/files/{file:uuid}', [FileController::class, 'destroy']);
    Route::post('/files/signed', [FileController::class, 'signedURL']);
    Route::get('/user/usage', [UserUsageController::class, 'getStorageUsage']);
    Route::post('/file/{file:uuid}/share', [FileShareController::class, 'createShareUrl']);

    Route::get('/plans', [PlanController::class, 'getPlans']);
    Route::get('/subscriptions/intent', [StripeIntentController::class, 'getClientSecret']);
    Route::post('/subscriptions/create', [SubscriptionController::class, 'createSubscription']);
    Route::get('/subscriptions/plans', [UserPlanAvailabilityController::class, 'getPlans']);
    Route::patch('/subscriptions/swap', [SubscriptionController::class, 'swapSubscription']);

});

