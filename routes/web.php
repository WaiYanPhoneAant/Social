<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\gitHubAuthController;
use App\Http\Controllers\GoogleAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/login/google', [GoogleAuthController::class, 'redirect'])->name('login.google');
Route::get('/auth/google/call-back', [GoogleAuthController::class, 'callBackGoogle']);

Route::get('/login/github', [gitHubAuthController::class, 'redirect'])->name('login.github');
Route::get('/auth/github/call-back', [gitHubAuthController::class, 'callBackGitHub']);



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
});
