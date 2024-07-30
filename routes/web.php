<?php

use App\Http\Controllers\Admin\HomeController;
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

Route::get('/dashboard', [HomeController::class, 'index'])->name('dasboard')->middleware('auth');