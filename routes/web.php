<?php

use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
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
    return view('auth.login');
});

Route::get('change-language/{lang}', function($lang){
    if(in_array($lang, ['en', 'vi'])) {
        session(['applocale' => $lang]);
    }
    return redirect()->back();
});


Auth::routes();

// With role: admin | student
Route::group(['middleware' => ['role:admin|student', 'auth']], function() {
    Route::group(['prefix' => 'departments'], function() {
        Route::get('/', [DepartmentController::class, 'index'])->name('departments.index')->middleware('permission:show-department');
        Route::get('create', [DepartmentController::class, 'create'])->name('departments.create')->middleware('permission:create-department');
        Route::get('{department}/edit', [DepartmentController::class, 'edit'])->name('departments.edit')->middleware('permission:update-department');
        Route::post('department', [DepartmentController::class, 'store'])->name('departments.store')->middleware('permission:create-department');
        Route::put('{department}', [DepartmentController::class, 'update'])->name('departments.update')->middleware('permission:update-department');
        Route::delete('{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy')->middleware('permission:delete-department');
    });

    Route::group(['prefix' => 'subjects'], function() {
        Route::get('/', [SubjectController::class, 'index'])->name('subjects.index')->middleware('permission:show-subject');
        Route::get('/create', [SubjectController::class, 'create'])->name('subjects.create')->middleware('permission:create-subject');
        Route::get('/{subject}/edit', [SubjectController::class, 'edit'])->name('subjects.edit')->middleware('permission:update-subject');
        Route::post('/subject', [SubjectController::class, 'store'])->name('subjects.store')->middleware('permission:create-subject');
        Route::put('/{subject}', [SubjectController::class, 'update'])->name('subjects.update')->middleware('permission:update-subject');
        Route::delete('/{subject}', [SubjectController::class, 'destroy'])->name('subjects.destroy')->middleware('permission:delete-subject');
    });

    Route::get('students/transcripts/{student}', [StudentController::class, 'getStudentTranscriptById'])->name('students.student-result')->middleware('permission:show-student-result');
    Route::get('students/subjects/register/{student}', [StudentController::class, 'registerSubjects'])->name('students.register-subjects')->middleware('permission:register-subject');
    Route::put('students/subjects/register/{student}', [StudentController::class, 'registerSubjectsUpdate'])->name('students.register-subjects-update')->middleware('permission:register-subject');

    // Chat
    Route::get('chats', [ChatController::class, 'index'])->name('chats.index');
    Route::post('chats/message', [ChatController::class, 'messageRecieved'])->name('chats.messageRecieved');
});

// With role: student
Route::group(['middleware' => ['role:student', 'auth']], function () {
    Route::get('students/profile', [StudentController::class, 'profileStudent'])->name('students.profile');
    Route::put('students/profile', [StudentController::class, 'updateProfileStudent'])->name('students.update-profile');
});

// With role: admin
Route::group(['middleware' => ['role:admin', 'auth']], function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'roles'], function() {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
        Route::get('/{role}', [RoleController::class, 'show'])->name('roles.show');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::post('/store', [RoleController::class, 'store'])->name('roles.store');
        Route::put('/{role}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    });

    Route::post('students/import-scores', [StudentController::class, 'importScores'])->name('students.import-scores');
    Route::get('students/edit-scores/{student}', [StudentController::class, 'editScores'])->name('students.edit-scores');
    Route::put('students/edit-scores/{student}', [StudentController::class, 'updateScoreByStudentId'])->name('students.update-student-scores');
    Route::get('students/export-scores', [StudentController::class, 'exportScores'])->name('students.export-scores');

    Route::resource('students', StudentController::class);

});
