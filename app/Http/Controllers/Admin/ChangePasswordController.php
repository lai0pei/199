<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Models\Admin\PasswordModel;
use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
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
        try {
            if ((new PasswordModel($this->request->all()))->changePassword()) {
                return self::json_success([], '修改成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }
}
