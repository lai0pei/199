<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Index\IndexController;
use Inertia\Inertia;


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
