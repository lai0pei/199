<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: ChangePasswordController.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Tuesday, 4th January 2022 8:04:00 am
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2022 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Http\Controllers\Admin;

use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Models\Admin\PasswordModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    const MSG = '请求数据有误';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function password()
    {
        $data = (new PasswordModel($this->request->all()))->getPassword();
        return view('admin.password.change_password', ['data' => $data]);
    }

    public function changePassword()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'old' => 'required',
            'new' => 'required',
            're-new' => 'required',
        ], );
        try {

            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }

            if ((new PasswordModel($input))->changePassword()) {
                return self::json_success([], '修改成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }
}
