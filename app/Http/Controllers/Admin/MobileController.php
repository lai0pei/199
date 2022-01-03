<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Models\Admin\MobileModel;
use Illuminate\Http\Request;

class MobileController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function mobile()
    {
        return view('admin.mobile.mobile');
    }

    public function getMobile()
    {
        $data = (new MobileModel($this->request->all()))->getMobile();

        $result['code'] = self::FAIL;
        $result['msg'] = '操作成功';
        $result['data'] = $data['data'];
        $result['count'] = $data['count'];

        return response()->json($result);
    }

    public function deleteMobile()
    {
        try {
            if ((new MobileModel($this->request->all()))->deleteMobile()) {
                return self::json_success([], '操作成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function addMobile()
    {
        return view('admin.mobile.addmobile');
    }

    public function maniMobile()
    {
        return self::json_success((new MobileModel($this->request->all()))->maniMobile(), '添加、成功');
    }

    public function oneClick()
    {
        (new MobileModel($this->request->all()))->oneClick();
        return self::json_success([], '操作成功');
    }
}
