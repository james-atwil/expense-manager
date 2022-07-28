<?php

use App\Http\Controllers\Web;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [Web\Index\IndexController::class, 'index'])->name('home')->middleware(['auth']);
Route::get('/test', [Web\Index\IndexController::class, 'test'])->name('test')->middleware(['auth']);

// Login
Route::get('/login', ['as' => 'login', 'uses' => Web\Auth\LoginController::class . '@index']);
Route::post('/login', ['as' => 'login', 'uses' => Web\Auth\LoginController::class . '@login']);

// Logout
Route::get('/logout', ['as' => 'logout', 'uses' => Web\Auth\LoginController::class . '@logout']);
Route::post('/logout', ['as' => 'logout', 'uses' => Web\Auth\LoginController::class . '@logout']);

// User Profile
Route::get('/profile', ['as' => 'profile', 'uses' => Web\System\ProfileController::class . '@index']);


// Users Management
Route::prefix('users')->name('users.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [Web\System\IndexController::class, 'index'])->name('index');
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [Web\System\RolesController::class, 'index'])->name('index');
    });
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [Web\System\UsersController::class, 'index'])->name('index');
    });
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [Web\System\SettingsController::class, 'index'])->name('index');
        Route::get('/list.js', [Web\System\SettingsController::class, 'list'])->name('list');
    });
});

// Expenses Management
Route::prefix('expenses')->name('expenses.')->middleware(['auth'])->group(function () {
    Route::get('/', [Web\Expenses\IndexController::class, 'index'])->name('index');
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [Web\Expenses\CategoriesController::class, 'index'])->name('index');
    });
    Route::prefix('expenses')->name('expenses.')->group(function () {
        Route::get('/', [Web\Expenses\ExpensesController::class, 'index'])->name('index');
    });
});

// System
Route::prefix('system')->name('system.')->middleware(['auth'])->group(function () {
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [Web\System\SettingsController::class, 'index'])->name('index');
        Route::get('/list.js', [Web\System\SettingsController::class, 'list'])->name('list');
    });
});
