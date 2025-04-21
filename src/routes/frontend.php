<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendAuthController;
use App\Http\Controllers\Admin\SubscriptionUserController;
use App\Http\Controllers\Frontend\FrontendLandingPageController;

Route::group(['as' => 'frontend.'], function () {

    Route::get('/home', [FrontendLandingPageController::class, 'index'])->name('landing.index');
    Route::get('/home2', [FrontendLandingPageController::class, 'index'])->name('landing.index2')->middleware('auth:sanctum');
    Route::get('/login', [FrontendLandingPageController::class, 'loginFormShow'])->name('login');
    Route::get('/register', [FrontendLandingPageController::class, 'registerFormShow'])->name('register');

    Route::post('/login', [FrontendAuthController::class, 'login'])->name('login.submit')->middleware('guest');
    Route::post('/register', [FrontendAuthController::class, 'register'])->name('register.submit')->middleware('guest');

    Route::post('/logout', [FrontendAuthController::class, 'logout'])->name('logout')->middleware('auth');
});

Route::group(['Middleware' => 'auth:sanctum'], function () {

    Route::post('/subscribe', [SubscriptionUserController::class, 'subscribe'])->name('subscribe');

    Route::get('/subscription-view/{id}', [SubscriptionUserController::class, 'subscriptionShowFrontend'])->middleware('auth:sanctum');

    Route::post('/subscription-cancel', [SubscriptionUserController::class, 'cancelSubscription'])->name('subscription.cancel')->middleware('auth:sanctum');
});

// Route::middleware('auth:sanctum')->get('/dashboard', function () {
//     return view('frontend.login_form');
// });
