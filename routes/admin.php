<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use Illuminate\Auth\Events\Login;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "Admin" middleware group. Enjoy building your Admin!
|
*/

/*
| 后台登录
*/
Route::get("admin/login", [LoginController::class, 'index'])->name('admin.login');

/*
| 后台路由
*/
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('*', [LoginController::class,'index'])->name('admin.login');
});
