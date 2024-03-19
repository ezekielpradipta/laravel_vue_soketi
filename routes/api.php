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
use App\Http\Controllers\User\PesanController;
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
    Route::post('/reset_password', [ReferensiController::class, 'resetPassword']);
    Route::post('/ganti_password', [ReferensiController::class, 'gantiPassword']);
    Route::post('/user_list', [ReferensiController::class, 'getUserList']);

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
            Route::post('/kirim_pesan', [PesanController::class, 'kirimPesan']);
            Route::post('/kotak_keluar', [PesanController::class, 'kotakKeluar']);
            Route::post('/kotak_masuk', [PesanController::class, 'kotakMasuk']);
            Route::post('/read_pesan', [PesanController::class, 'readPesan']);
            Route::post('/delete_pesan', [PesanController::class, 'deletePesan']);
            Route::post('/detail_pesan', [PesanController::class, 'detailPesan']);
        });
    });
});
