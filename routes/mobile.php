<?php

use App\Http\Controllers\Index\IndexController;
use App\Http\Controllers\Index\MessageController;
use App\Http\Controllers\Index\UploadController;
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
| 前台路由
 */

Route::post('/nav_link', [IndexController::class, 'navLink'])->name('index_nav');

Route::post('/getForm', [IndexController::class, 'getFormById'])->name('get_index_form');

Route::post('/applyForm', [IndexController::class, 'applyForm'])->name('apply_form');

Route::post('/uploadImage', [UploadController::class, 'uploadImage'])->name('uploadImage');

Route::post('/getMessage', [MessageController::class, 'smsMessage'])->name('sms_message');

Route::post('/getEventList', [IndexController::class, 'getAllEvent'])->name('event_list');

Route::post('/checkForm', [IndexController::class, 'checkForm'])->name('check_form');

Route::get('/getCaptcha', [IndexController::class, 'captcha'])->name('index_captcha');

Route::get('/', [IndexController::class, 'index']);

Route::get('/detail', [IndexController::class, 'detail'])->name('detail');
