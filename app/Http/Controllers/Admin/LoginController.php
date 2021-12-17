<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    | 登录界面
    */
    public function index(){
        return view('admin.login.index');
    }

    /*
    | 后台登录
    */

}
