<?php

use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('change-language/{lang}', function($lang){
    if(in_array($lang, ['en', 'vi'])) {
        session(['applocale' => $lang]);
    }
    return redirect()->back();
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Admin

Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard')->middleware('auth');

Route::group(['prefix' => 'roles', 'middleware' => 'auth'], function() {
    Route::get('/', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
    Route::get('/{role}', [RoleController::class, 'show'])->name('roles.show');
    Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('/store', [RoleController::class, 'store'])->name('roles.store');
    Route::put('/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::DELETE('/{role}', [RoleController::class, 'destroy']);
});

// Route::group(['prefix' => '', 'middleware' => 'auth'], function() {
    Route::resource('departments', DepartmentController::class);
// });