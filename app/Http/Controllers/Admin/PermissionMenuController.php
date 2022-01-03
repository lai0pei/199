<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AuthGroupModel;
use App\Models\Admin\PermissionMenuModel;
use App\Models\Admin\RoleModel;
use Illuminate\Http\Request;
use LogicException;

class PermissionMenuController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getPermission()
    {
        $data = (new RoleModel($this->request->route()->parameters()))->getRoleNameById();
        return view('admin.group.permission', ['role' => $data]);
    }

    public function permissionList()
    {
        return self::json_success((new PermissionMenuModel($this->request->all()))->permissionList());
    }

    public function submitList()
    {
        try {
            return self::json_success((new AuthGroupModel($this->request->all()))->submitList());
        } catch (LogicException $e) {
            return self::json_fail($e->getMessage());
        }
    }
}
