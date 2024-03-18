<?php

use App\Http\Controllers\Admin\AdminUserController as AdminAdminUserController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KirimPesanController;
use App\Http\Controllers\KotakKeluarController;
use App\Http\Controllers\KotakMasukController;
use App\Http\Controllers\KotakPesanController;
use App\Http\Controllers\LogUserController;
use App\Http\Controllers\ReferensiController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UtilController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/login', [AuthController::class, 'login']);
Route::get('/getFakultasList', [UtilController::class, 'getFakultasList']);
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);


    Route::get('/role_list', [ReferensiController::class, 'getRoleList']);
    Route::post('/role_list_pagination', [ReferensiController::class, 'getRoleListPagination']);
    Route::middleware("role_admin")->group(function () {
        Route::prefix('admin')->group(function () {
            Route::post('/user_list_pagination', [AdminAdminUserController::class, 'getUserListPagination']);
            Route::post('/create_user', [AdminAdminUserController::class, 'createUser']);
            Route::post('/update_user', [AdminAdminUserController::class, 'updateUser']);
            Route::post('/delete_user', [AdminAdminUserController::class, 'deleteUser']);
        });
    });
    Route::middleware("role_user")->group(function () {
        Route::prefix('user')->group(function () {
        });
    });
});
