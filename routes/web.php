<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\VerificationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

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

############################## start admin routes ##############################

Route::prefix('admin')->group(function(){
    Route::as('admin.')->group(function(){
        Route::get('login'                   , [ LoginController::class          , 'showLoginForm'       ])->name('login');
        Route::post('login'                  , [ LoginController::class          , 'login'               ])->name('login.submit');
        Route::post('logout'                 , [ LoginController::class          , 'logout'              ])->name('logout');
        Route::get('password/reset'          , [ ForgotPasswordController::class , 'showLinkRequestForm' ])->name('password.request');
        Route::post('password/email'         , [ ForgotPasswordController::class , 'sendResetLinkEmail'  ])->name('password.email');
        Route::get('password/reset/{token}'  , [ ResetPasswordController::class  , 'showResetForm'       ])->name('password.reset');
        Route::post('password/reset'         , [ ResetPasswordController::class  , 'reset'               ])->name('password.update');
        Route::get('email/verify'             ,[ VerificationController::class   , 'show'                ])->name('verification.notice');
        Route::get('email/verify/{id}/{hash}' ,[ VerificationController::class   , 'verify'              ])->name('verification.verify');
        Route::post('email/resend'            ,[ VerificationController::class   , 'resend'              ])->name('verification.resend');
    });

    Route::middleware('auth:admin')->group(function(){
        Route::get('/', [DashboardController::class, 'index']);
    });
});


############################## end admin routes ##############################


############################## start client routes ###########################

Auth::routes();

Route::get('/', [HomeController::class, 'index']);


Route::middleware('auth:web')->group(function(){
    Route::get('/home', [ProfileController::class, 'index']);
    Route::get('/profile', [ProfileController::class, 'index']);
});

############################## end client routes ##############################








