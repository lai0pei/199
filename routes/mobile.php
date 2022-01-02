<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Index\IndexController;
use App\Http\Controllers\Index\UploadController;
use App\Http\Controllers\Index\TestController;
use App\Http\Controllers\Index\MessageController;


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
Route::get('/', [IndexController::class,'index']);

Route::post('/nav_link', [IndexController::class,'navLink'])->name('index_nav');

Route::post('/getForm', [IndexController::class,'getFormById'])->name('get_index_form');

Route::post('/applyForm', [IndexController::class,'applyForm'])->name('apply_form');

Route::post('/uploadImage', [UploadController::class,'uploadImage'])->name('uploadImage');

Route::get("/getCaptcha", [IndexController::class, 'captcha'])->name('index_captcha');

Route::post("/getMessage", [MessageController::class, 'smsMessage'])->name('sms_message');

// Route::get("/getCaptcha", [IndexController::class, 'captcha'])->name('index_captcha');

//函数 测试接口
Route::get('/test', [TestController::class,'test']);


