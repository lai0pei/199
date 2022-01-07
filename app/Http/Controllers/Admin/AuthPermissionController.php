<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PermissionMenuModel;
use Illuminate\Http\Request;

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
        $data = (new PermissionMenuModel($this->request->route()->parameters()))->viewPermission();
        return view('admin.auth_permission.view_permission', ['data' => $data]);
    }
}
