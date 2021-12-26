<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: admin.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Friday, 17th December 2021 10:01:09 am
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminGroupController;
use App\Http\Controllers\Admin\AuthMenuController;
use App\Http\Controllers\Admin\AuthPermissionController;
use App\Http\Controllers\Admin\ChangePasswordController;
use App\Http\Controllers\Admin\CommonSettingController;
use App\Http\Controllers\Admin\ConfigsController;
use App\Http\Controllers\Admin\ControlController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\EventTypeController;
use App\Http\Controllers\Admin\FormController;
use App\Http\Controllers\Admin\IpController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\MobileController;
use App\Http\Controllers\Admin\PermissionMenuController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SmsConfigController;
use App\Http\Controllers\Admin\SmsController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

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
Route::middleware(['admin'])->group(function () {
    //后台页面


});
