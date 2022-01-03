<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Models\Admin\IpModel;
use Illuminate\Http\Request;

class IpController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function allow_ip()
    {
        return view('admin.allow_ip.ip');
    }

    public function add_ip()
    {
        $ip = (new IpModel($this->request->route()->parameters()))->getIp();
        return view('admin.allow_ip.add', ['ip' => $ip]);
    }

    public function mani_ip()
    {
        try {
            if ((new IpModel($this->request->all()))->mani_ip()) {
                return self::json_success([], '操作成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function ip_list()
    {
        $data = (new IpModel($this->request->all()))->listIp();
        $result['code'] = self::FAIL;
        $result['msg'] = '操作成功';
        $result['data'] = $data['data'];
        $result['count'] = $data['count'];

        return response()->json($result);
    }

    public function ip_delete()
    {
        try {
            if ((new IpModel($this->request->all()))->ip_delete()) {
                return self::json_success([], '操作成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }
}
