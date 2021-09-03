<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\DepartmentController;

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

Route::get('/', function () {
    return view('welcome');
})->name("index");
Route::get('dashboard', [CustomAuthController::class, 'dashboard'])->name('dashboard.index');
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom');
Route::post('matric', [CustomAuthController::class, 'matric'])->name('matric.check');
Route::get('register', [CustomAuthController::class, 'register'])->name('student.register');
Route::post('register', [CustomAuthController::class, 'studentRegistration'])->name('student.submit');
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');
Route::resource('departments', 'App\Http\Controllers\DepartmentController')->middleware([
    "auth", "\App\Http\Middleware\XSS"
]);
Route::resource('faculties', 'App\Http\Controllers\FacultyController')->middleware([
    "auth", "\App\Http\Middleware\XSS"
]);
Route::resource('submissions', 'App\Http\Controllers\SubmissionsController')->middleware([
    "auth", "\App\Http\Middleware\XSS"
]);
Route::resource('clearance', 'App\Http\Controllers\ClearanceController')->middleware([
    "auth", "\App\Http\Middleware\XSS"
]);
Route::resource('staffs', 'App\Http\Controllers\StaffController')->middleware([
    "auth", "\App\Http\Middleware\XSS"
]);

Route::post('clearance/fetch', [\App\Http\Controllers\ClearanceController::class, 'fetch'])->name('clearance.fetch');
Route::get('document/print', [\App\Http\Controllers\ClearanceController::class, 'printDocument'])->name('document.print');
Route::post('department/fetch', [\App\Http\Controllers\DepartmentController::class, 'fetch'])->name('department.fetch');
Route::post('students/import', [\App\Http\Controllers\StudentController::class, 'import'])->name('students.import');
Route::get('students/import', [\App\Http\Controllers\StudentController::class, 'showImport'])->name('students.showimport');
Route::resource('students', 'App\Http\Controllers\StudentController')->middleware([
    "auth", "\App\Http\Middleware\XSS"
]);