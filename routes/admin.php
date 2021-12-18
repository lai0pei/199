<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\AuthMenuController;
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
Route::get("admin/login", [LoginController::class, 'index'])->name('admin.login.index');
Route::post("admin/login", [LoginController::class, 'login'])->name('admin.login.login');
Route::get("admin/captcha", [LoginController::class, 'captcha'])->name('admin.login.captcha');

/*
| 后台路由
*/
Route::middleware(['admin'])->prefix('admin')->group(function () {
    Route::get('/', [AuthMenuController::class, 'index'])->name('admin_menu');
});
