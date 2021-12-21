<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\PermissionMenuModel;
use App\Models\Admin\RoleModel;
use App\Models\Admin\AuthGroupModel;

class PermissionMenuController extends Controller
{
    //
    public function __construct(Request $request)
    {
        $this->request = $request; 
    }

    public function getPermission(){
        $data = (new RoleModel($this->request->route()->parameters()))->getRoleNameById();
        return view('admin.group.permission',['role'=>$data]);
    }

    public function permissionList(){
       return self::json_success((new PermissionMenuModel($this->request->all()))->permissionList());
    }

    public function submitList(){
        return self::json_success((new AuthGroupModel($this->request->all()))->submitList());
    }
}
