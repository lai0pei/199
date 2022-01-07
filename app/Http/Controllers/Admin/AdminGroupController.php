<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: AdminGroupController.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Sunday, 19th December 2021 6:22:30 pm
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Http\Controllers\Admin;

use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Models\Admin\RoleModel;
use Illuminate\Http\Request;

class AdminGroupController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function group()
    {
        return view('admin.group.admin_group');
    }

    public function groupAdd()
    {
        $res = (new RoleModel($this->request->route()->parameters()))->maniRole();
        return view('admin.group.group_add', ['role' => $res]);
    }

    public function newGroup()
    {
        try {
            if ((new RoleModel($this->request->all()))->newGroup()) {
                return self::json_success([], '操作成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function deleteGroup()
    {
        try {
            if ((new RoleModel($this->request->all()))->deleteGroup()) {
                return self::json_return([], '删除成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }
}
