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
use App\Http\Controllers\Admin\IpController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SmsConfigController;
use App\Http\Controllers\Admin\SmsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PermissionMenuController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\EventTypeController;
use App\Http\Controllers\Admin\UploadController;



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
    //后台页面
    Route::get('/', [AuthMenuController::class, 'index'])->name('admin_menu'); 
    Route::get('/control', [ControlController::class, 'control'])->name('admin_control');  
    Route::get('/event_lists', [EventController::class, 'list'])->name('admin_event_list');
    Route::get('/mobile_management', [MobileController::class, 'mobile'])->name('admin_mobile_management');
    Route::get('/user_apply', [UserController::class, 'user'])->name('admin_user_apply');
    Route::get('/sms_apply', [SmsController::class, 'sms'])->name('admin_sms_apply');

    //管理员 页面 和 接口
    Route::get('/person', [AdminController::class, 'person'])->name('admin_person');
    Route::get('/add_person', [AdminController::class, 'addPerson'])->name('admin_person_add');
    Route::get('/edit_person/{id?}', [AdminController::class, 'editPerson'])->name('admin_person_edit');
    Route::get('/view_person/{id?}', [AdminController::class, 'viewPerson'])->name('admin_person_view');
    Route::post('/add_person', [AdminController::class, 'addNewAdmin'])->name('admin_add_person');
    Route::post('/save_admin', [AdminController::class, 'saveAdmin'])->name('admin_save_admin');
    Route::post('/delete_admin', [AdminController::class, 'deleteAdmin'])->name('admin_person_delete');
    Route::get('/list_admin', [AdminController::class, 'listAdmin'])->name('admin.admin_list');
    Route::get('/edit_admin', [AdminController::class, 'addNewAdmin'])->name('admin_edit_person');
   

    //管理组
    Route::get('/admin_group', [AdminGroupController::class, 'group'])->name('admin_group');
    Route::get('/group_add/{id?}', [AdminGroupController::class, 'groupAdd'])->name('group_add');
    Route::post('/group_add/{id?}', [AdminGroupController::class, 'newGroup'])->name('group_add');
    Route::post('/group_delete/{id?}', [AdminGroupController::class, 'deleteGroup'])->name('group_delete');
    Route::get('/permission/{role_id?}', [PermissionMenuController::class, 'getPermission'])->name('admin_permission');
    Route::post('/permissionList', [PermissionMenuController::class, 'permissionList'])->name('admin_permission_list');
    Route::post('/submitList', [PermissionMenuController::class, 'submitList'])->name('admin_submit_list');

    Route::get('/get_role_permission', [RoleController::class, 'getRoleByPermission'])->name('admin_get_role_permission');
    Route::get('/get_role/{id?}', [RoleController::class, 'getRole'])->name('admin_get_role');

    //修改密码
    Route::get('/change_password', [ChangePasswordController::class, 'password'])->name('admin_password');
    Route::post('/change_password', [ChangePasswordController::class, 'changePassword'])->name('admin_password_change');

    //权限列表
    Route::get('/auth_permission', [AuthPermissionController::class, 'auth'])->name('admin_auth_permission');
    Route::get('/permission_show', [AuthPermissionController::class, 'authList'])->name('admin_permission_show');
    Route::get('/view_permission/{id?}', [AuthPermissionController::class, 'viewPermission'])->name('admin_view_permission');

    //日志列表
    Route::get('/log', [LogController::class, 'log'])->name('admin_log');
    Route::get('/getLog', [LogController::class, 'getLog'])->name('admin_getLog');
    Route::get('/detailLog/{id?}', [LogController::class, 'detailLog'])->name('admin_detailLog');

    //短信配置
    Route::get('/sms_config', [SmsConfigController::class, 'sms_config'])->name('admin_sms_config');
    Route::post('/save_sms', [SmsConfigController::class, 'saveSms'])->name('admin_save_sms');

    //ip地址
    Route::get('/allow_ip', [IpController::class, 'allow_ip'])->name('admin_allow_ip');
    Route::post('/mani_ip', [IpController::class, 'mani_ip'])->name('admin_mani_ip');
    Route::get('/add_ip/{id?}', [IpController::class, 'add_ip'])->name('admin_add_ip');
    Route::get('/ip_list', [IpController::class, 'ip_list'])->name('admin_ip_list');
    Route::post('/delete_ip', [IpController::class, 'ip_delete'])->name('admin_delete_ip');
    
    //公共配置
    Route::get('/common_settings', [CommonSettingController::class, 'common'])->name('admin_common_settings');

    //拒绝
    Route::get('/bulk_refuse', [ConfigsController::class, 'refuse'])->name('admin_bulk_refuse');
    Route::post('/refuse_save', [ConfigsController::class, 'refuseSave'])->name('admin_bulk_save');

    //通过
    Route::get('/bulk_pass', [ConfigsController::class, 'pass'])->name('admin_bulk_pass');
    Route::post('/pass_save', [ConfigsController::class, 'passSave'])->name('admin_pass_save');

    //链接
    Route::get('/link_management', [ConfigsController::class, 'link'])->name('admin_link_management');
    Route::post('/link_save', [ConfigsController::class, 'linkSave'])->name('admin_link_save');

    //游戏        
    Route::get('/game_management', [ConfigsController::class, 'game'])->name('admin_game_management');
    Route::post('/game_save', [ConfigsController::class, 'gameSave'])->name('admin_game_save');

    //公告
    Route::get('/announcement', [ConfigsController::class, 'announcement'])->name('admin_announcement');
    Route::post('/announcement_save', [ConfigsController::class, 'announcementSave'])->name('admin_announcement_save');

    //活动类型
    Route::get('/event_type', [EventTypeController::class, 'type'])->name('admin_event_type');
    Route::post('/mani_type', [EventTypeController::class, 'maniType'])->name('admin_mani_type');
    Route::get('/add_type/{id?}', [EventTypeController::class, 'addType'])->name('admin_add_type');
    Route::get('/type_list', [EventTypeController::class, 'typeList'])->name('admin_type_list');
    Route::post('/delete_type', [EventTypeController::class, 'typeDelete'])->name('admin_delete_type');

    //活动add_event
    Route::get('/add_event/{id?}', [EventController::class, 'event'])->name('admin_add_event');
    Route::post('/uploadContent', [UploadController::class, 'eventContent'])->name('admin_upload');
    Route::post('/uploadPhoto', [UploadController::class, 'eventPhotoUpload'])->name('admin_upload_content');


    


    
    
    

// |------------------------------------------------------------------------------------------------------------------------------------------------------

    //get 接口
    Route::get('/clear', [AuthMenuController::class, 'clear'])->name('admin.clear');
    Route::get('/init', [AuthMenuController::class, 'init'])->name('admin.init');
    //post 接口
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin_logout');


});
