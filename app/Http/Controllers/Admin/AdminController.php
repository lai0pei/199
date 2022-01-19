<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: AdminController.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Sunday, 19th December 2021 6:22:21 pm
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Http\Controllers\Admin;

use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Models\Admin\AdminModel;
use App\Models\Admin\RoleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * __construct
     *
     * @param  Request $request
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->validate = 'required|numeric|min:-1';
    }

    public function person()
    {
        $res['role'] = (new RoleModel($this->request))->getAllRole();
        $res['status'] = ['禁用', '正常'];
        return view('admin.person.person', ['data' => $res]);
    }

    public function listAdmin()
    {
        $data = (new AdminModel($this->request->all()))->listAdmin();
        $result['code'] = self::FAIL;
        $result['msg'] = '操作成功';
        $result['data'] = $data['data'];
        $result['count'] = $data['count'];

        return response()->json($result);
    }

    public function addPerson()
    {
        return view('admin.person.addperson');
    }

    public function addNewAdmin()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'account' => 'required',
            'password' => 'required',
            'username' => 'required',
            'role' => 'required',
            'status' => ['required', Rule::in(0, 1, 2)],
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }

            if ((new AdminModel($input))->addAdmin()) {
                return self::json_return([], '添加成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function editPerson()
    {
        $input = $this->request->route()->parameters();
        $validator = Validator::make($input, [
            'id' => $this->validate,
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException('ID必须');
            }
            $data = (new AdminModel($input))->editAdmin();
            return view('admin.person.editperson', ['edit_admin' => $data]);
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function viewPerson()
    {
        $input = $this->request->route()->parameters();
        $validator = Validator::make($input, [
            'id' => $this->validate,
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException('ID必须');
            }
            $data = (new AdminModel($input))->editAdmin();
            return view('admin.person.viewperson', ['edit_admin' => $data]);
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function saveAdmin()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'id' => $this->validate,
            'account' => 'required',
            'username' => 'required',
            'role' => 'required',
            'status' => ['required', Rule::in(0, 1, 2)],
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }

            if ((new AdminModel($input))->saveAdmin()) {
                return self::json_return([], '编辑成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function deleteAdmin()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'id' => $this->validate,
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }

            if ((new AdminModel($this->request->all()))->deleteAdmin()) {
                return self::json_return([], '删除成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }
}
