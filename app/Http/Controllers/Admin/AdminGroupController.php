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
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminGroupController extends Controller
{   
    const MSG = '请求数据有误';
    
    /**
     * __construct
     *
     * @param  mixed $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    /**
     * group
     *
     * @return void
     */
    public function group()
    {
        return view('admin.group.admin_group');
    }
    
    /**
     * groupAdd
     *
     * @return void
     */
    public function groupAdd()
    {   
        $input = $this->request->route()->parameters();
        $validator = Validator::make($input, [
            'id' => 'required|numeric|min:-1',
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException('ID必须');
            }
        $res = (new RoleModel($input))->maniRole();
        return view('admin.group.group_add', ['role' => $res]);
        }catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }
    
    /**
     * newGroup
     *
     * @return void
     */
    public function newGroup()
    {   
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'id' => 'required|numeric|min:-1',
            'role_name' => 'required',
            'status' => ['required', Rule::in(0, 1, 2)],
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            if ((new RoleModel($input))->newGroup()) {
                return self::json_success([], '操作成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }
    
    /**
     * deleteGroup
     *
     * @return void
     */
    public function deleteGroup()
    {   
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'id' => 'required|numeric|min:-1',
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            if ((new RoleModel($this->request->all()))->deleteGroup()) {
                return self::json_return([], '删除成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }
}
