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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\AuthMenuController;
use App\Http\Controllers\Admin\ControlController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminGroupController;
use App\Http\Controllers\Admin\AuthPermissionController;
use App\Http\Controllers\Admin\ChangePasswordController;
use App\Http\Controllers\Admin\CommonSettingController;
use App\Http\Controllers\Admin\ConfigsController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GameConfigController;
use App\Http\Controllers\Admin\IpController;
use App\Http\Controllers\Admin\LinkController;
use App\Http\Controllers\Admin\MobileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SmsConfigController;
use App\Http\Controllers\Admin\SmsController;
use App\Http\Controllers\Admin\UserController;

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
    //页面
    Route::get('/', [AuthMenuController::class, 'index'])->name('admin_menu'); 
    Route::get('/control', [ControlController::class, 'control'])->name('admin_control'); 

    Route::get('/add_event', [EventController::class, 'add'])->name('admin_add_event'); 
    Route::get('/event_lists', [EventController::class, 'list'])->name('admin_event_list');
    Route::get('/mobile_management', [MobileController::class, 'mobile'])->name('admin_mobile_management');
    Route::get('/user_apply', [UserController::class, 'user'])->name('admin_user_apply');
    Route::get('/sms_apply', [SmsController::class, 'sms'])->name('admin_sms_apply');

    Route::get('/person', [AdminController::class, 'person'])->name('admin_person');
    Route::get('/admin_group', [AdminGroupController::class, 'group'])->name('admin_group');
    Route::get('/change_password', [ChangePasswordController::class, 'password'])->name('admin_password');

    Route::get('/log', [LogController::class, 'log'])->name('admin_log');

    Route::get('/announcement', [AnnouncementController::class, 'announcement'])->name('admin_announcement');
    Route::get('/sms_config', [SmsConfigController::class, 'sms_config'])->name('admin_sms_config');
    Route::get('/bulk_refuse', [ConfigsController::class, 'refuse'])->name('admin_bulk_refuse');
    Route::get('/bulk_pass', [ConfigsController::class, 'pass'])->name('admin_bulk_pass');
    Route::get('/link_management', [LinkController::class, 'link'])->name('admin_link_management');
    Route::get('/game_management', [GameConfigController::class, 'game'])->name('admin_game_management');
    Route::get('/allow_ip', [IpController::class, 'allow_ip'])->name('admin_allow_ip');

    Route::get('/common_settings', [CommonSettingController::class, 'common'])->name('admin_common_settings');
    Route::get('/auth_permission', [AuthPermissionController::class, 'auth'])->name('admin_auth_permission');

    // 接口
    Route::post('/clear', [AuthMenuController::class, 'clear'])->name('admin.clear');
    Route::get('/clear', [AuthMenuController::class, 'clear'])->name('admin.clear');
});
