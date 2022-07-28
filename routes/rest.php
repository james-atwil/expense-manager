<?php

use App\Http\Controllers\Api;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| REST Routes
|--------------------------------------------------------------------------
|
| Similar to API routes but only visible to the site itself. No CORS required.
|
*/

Route::get('/dashboard', [Api\Index\IndexController::class, 'dashboard']);

// Expenses Management
Route::prefix('expenses')->name('expenses.')->middleware(['auth'])->group(function () {
    // Categories
    Route::prefix('categories')->group(function () {
        Route::get('/', ['uses' => Api\Expenses\CategoriesController::class . '@list']);
        Route::post('/', ['uses' => Api\Expenses\CategoriesController::class . '@store'])->middleware(['role:admin']);
        Route::put('/', ['uses' => Api\Expenses\CategoriesController::class . '@updateMultiple'])->middleware(['role:admin']);
        Route::delete('/', ['uses' => Api\Expenses\CategoriesController::class . '@destroyMultiple'])->middleware(['role:admin']);

        Route::prefix('{id}')->group(function () {
            Route::get('/', ['uses' => Api\Expenses\CategoriesController::class . '@show']);
            Route::put('/', ['uses' => Api\Expenses\CategoriesController::class . '@updateSingle'])->middleware(['role:admin']);
            Route::delete('/', ['uses' => Api\Expenses\CategoriesController::class . '@destroySingle'])->middleware(['role:admin']);
        });
    });

    // Expenses
    Route::prefix('expenses')->group(function () {
        Route::get('/', ['uses' => Api\Expenses\ExpensesController::class . '@list']);
        Route::post('/', ['uses' => Api\Expenses\ExpensesController::class . '@store']);
        Route::put('/', ['uses' => Api\Expenses\ExpensesController::class . '@updateMultiple']);
        Route::delete('/', ['uses' => Api\Expenses\ExpensesController::class . '@destroyMultiple']);

        Route::prefix('{id}')->group(function () {
            Route::get('/', ['uses' => Api\Expenses\ExpensesController::class . '@show']);
            Route::put('/', ['uses' => Api\Expenses\ExpensesController::class . '@updateSingle']);
            Route::delete('/', ['uses' => Api\Expenses\ExpensesController::class . '@destroySingle']);
        });
    });
});


// System Management
Route::prefix('system')->name('system.')->middleware(['auth', 'role:developer'])->group(function () {
    // Roles Management
    Route::prefix('roles')->group(function () {
        Route::get('/', ['uses' => Api\System\RolesController::class . '@list']);
        Route::post('/', ['uses' => Api\System\RolesController::class . '@store']);
        Route::put('/', ['uses' => Api\System\RolesController::class . '@updateMultiple']);
        Route::delete('/', ['uses' => Api\System\RolesController::class . '@destroyMultiple']);

        Route::prefix('{id}')->group(function () {
            Route::get('/', ['uses' => Api\System\RolesController::class . '@show']);
            Route::put('/', ['uses' => Api\System\RolesController::class . '@updateSingle']);
            Route::delete('/', ['uses' => Api\System\RolesController::class . '@destroySingle']);
        });
    });

    // Users Management
    Route::prefix('users')->group(function () {
        Route::get('/', ['uses' => Api\System\UsersController::class . '@list']);
        Route::post('/', ['uses' => Api\System\UsersController::class . '@store']);
        Route::put('/', ['uses' => Api\System\UsersController::class . '@updateMultiple']);
        Route::delete('/', ['uses' => Api\System\UsersController::class . '@destroyMultiple']);

        Route::post('/exists', ['uses' => Api\System\UsersController::class . '@exists']);

        Route::prefix('{id}')->group(function () {
            Route::get('/', ['uses' => Api\System\UsersController::class . '@show']);
            Route::put('/', ['uses' => Api\System\UsersController::class . '@updateSingle']);
            Route::delete('/', ['uses' => Api\System\UsersController::class . '@destroySingle']);
        });
    });

    // Options Management
    Route::prefix('options')->group(function () {
        Route::prefix('{slug}')->group(function () {
            Route::get('/', ['uses' => Api\System\Options\OptionsController::class . '@list']);
        });
    });

    // Settings Management
    Route::prefix('settings')->group(function () {
        Route::get('/', ['uses' => Api\System\SettingsController::class . '@list']);
        Route::put('/', ['uses' => Api\System\SettingsController::class . '@updateMultiple']);
    });
});

// User Profile
Route::post('/profile', [Api\System\ProfileController::class, 'update']);
