<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::namespace('Alive2212\LaravelMobilePassport\Http\Controllers')
    ->prefix('api')
    ->group(function () {
    Route::prefix('v1')->group(function () {
        Route::prefix('alive')->group(function () {
            Route::prefix('passport')->group(function () {
            });
        });
        Route::prefix('custom')->group(function () {
            Route::prefix('alive')->group(function () {
                Route::prefix('passport')->group(function () {
                });
            });
        });
    });
});

