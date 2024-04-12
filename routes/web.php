<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\Dash\UserController;
use App\Http\Controllers\Dash\CategoryController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ],
    function () {

        Route::get('/', [HomePageController::class , 'index'])->name('main');
        Route::resources([
            'carts' => CartController::class ,
        ]);
        Route::middleware(['auth', 'verified' ,'dashboardAccess'])->as('dashboard.')->prefix('dashboard')->group(function () {
            Route::get('/', function () {
                return view('dash.index');
            })->name('main');

            Route::resources([
                'users' => UserController::class ,
                'categories' => CategoryController::class ,
                'products' => ProductController::class ,

            ]);
        });
        Route::middleware('auth')->as('profile.')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('destroy');
        });

    }
);




require __DIR__.'/auth.php';
