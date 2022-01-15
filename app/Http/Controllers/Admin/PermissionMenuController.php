<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: PermissionMenuController.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Tuesday, 4th January 2022 8:04:00 am
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2022 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AuthGroupModel;
use App\Models\Admin\PermissionMenuModel;
use App\Models\Admin\RoleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use LogicException;

class PermissionMenuController extends Controller
{
    public const MSG = '请求数据有误';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * getPermission
     *
     * @return void
     */
    public function getPermission()
    {
        $input = $this->request->route()->parameters();
        $validator = Validator::make($input, [
            'role_id' => 'required',
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            $data = (new RoleModel($input))->getRoleNameById();
            return view('admin.group.permission', ['role' => $data]);
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    /**
     * permissionList
     *
     * @return void
     */
    public function permissionList()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'id' => 'required|numeric|min:-1',
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            return self::json_success((new PermissionMenuModel($input))->permissionList());
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    /**
     * submitList
     *
     * @return void
     */
    public function submitList()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'id' => 'required|numeric|min:-1',
            'checked' => 'required',
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }

            if ((new AuthGroupModel($input))->submitList()) {
                return self::json_success();
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }
}
