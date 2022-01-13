<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PermissionMenuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use LogicException;

class AuthPermissionController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function auth()
    {
        $data = (new PermissionMenuModel($this->request->all()))->menuType();
        return view('admin.auth_permission.auth', ['data' => $data]);
    }

    public function authList()
    {
        $data = (new PermissionMenuModel($this->request->all()))->authList();

        $result['code'] = self::FAIL;
        $result['msg'] = '操作成功';
        $result['data'] = $data['data'];
        $result['count'] = $data['count'];

        return response()->json($result);
    }

    public function viewPermission()
    {
        $input = $this->request->route()->parameters();
        $validator = Validator::make($input, [
            'id' => 'required|numeric|min:-1',
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            $data = (new PermissionMenuModel($input))->viewPermission();
            return view('admin.auth_permission.view_permission', ['data' => $data]);
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }
}
