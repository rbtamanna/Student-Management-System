<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
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

Route::get('login', [AuthController::class, 'index'])->name('viewLogin');
Route::post('login', [AuthController::class, 'authenticate'])->name('login');
Route::get('/', [DashboardController::class, 'index']);
Route::get('/get_student_profile_data', [DashboardController::class, 'getProfileInfo']);
Route::get('forget_password', [AuthController::class, 'viewForgetPassword']);
Route::post('forget_password', [AuthController::class, 'forgetPassword']);
Route::post('forget_password/validate_email', [AuthController::class, 'validateEmail']);
Route::group(['middleware'=> 'auth'], function() {
    Route::get('/user/profile', [DashboardController::class, 'getProfile']);
    Route::get('/user/profile/edit', [DashboardController::class, 'editProfile']);
    Route::post('/user/profile/update', [DashboardController::class, 'updateProfile']);
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('change_password', [AuthController::class, 'viewChangePassword']);
    Route::post('change_password', [AuthController::class, 'changePassword']);
    Route::post('change_password/validate_inputs', [AuthController::class, 'validatePasswords']);
    Route::prefix('student')->group(function() {
        Route::get('/', [StudentController::class, 'index']);
        Route::get('/get_student_data', [StudentController::class, 'fetchData']);
        Route::get('/add', [StudentController::class, 'create']);
        Route::post('/store', [StudentController::class, 'store']);
        Route::get('/{id}/delete', [StudentController::class, 'delete']);
        Route::get('/{id}/edit', [StudentController::class, 'edit']);
        Route::post('/{id}/update', [StudentController::class, 'update']);
    });
});

