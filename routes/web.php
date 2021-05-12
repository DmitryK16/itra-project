<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Admin\AdminCompanyController;

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


Auth::routes();
Route::get('/', [HomeController::class, 'welcome']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth', 'prefix' => 'admin/account'], function () {
    Route::get('/', [AccountController::class, 'profile']);
});

Route::group(['middleware' => 'auth', 'prefix' => 'admin/company'], function () {
    Route::get('/', [AdminCompanyController::class, 'list']);
});

Route::group(['prefix' => 'company'], function () {
    Route::get('/view/{company}', [CompanyController::class, 'view'])->name('view_company');
});
