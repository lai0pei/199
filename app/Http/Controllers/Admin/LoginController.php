<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: LoginController.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: vip
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Friday, 17th December 2021 9:50:05 am
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Http\Controllers\Admin;

use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Models\Admin\AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    /**
     * __construct
     *
     * @param  mixed $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->input = $request;

    }

    /**
     * index
     *
     * @return void
     */
    public function index()
    {   
        if(!empty(session('user_id'))){
            return redirect(route('admin_menu'));
        }
        return view('admin.login.index');
    }

    /**
     * login
     *
     * @return void
     */
    public function login()
    {
        $input = $this->input->all();
        $validator = Validator::make($input, [
            'username' => 'required',
            'password' => 'required',
            'captcha' => 'required',
        ], );
        if ($validator->fails()) {
            return self::json_fail();
        }

        // if (!captcha_check($input['captcha'])) {
        //     return self::json_fail('验证码不正确');
        // }
      
        try {
            $admin = new AdminModel($input);
            if ($admin->adminLogin()) {
                return self::json_return(self::SUCCESS, '登录成功', []);
            }
        } catch (LogicException $e) {
            return self::json_fail($e->getMessage());
        }

    }

    /**
     * captcha
     *
     * @return void
     */
    public function captcha()
    {
        return captcha('admin_login');
    }

}
