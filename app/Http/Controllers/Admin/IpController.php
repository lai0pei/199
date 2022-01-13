<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: IpController.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Tuesday, 4th January 2022 8:04:00 am
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2022 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Http\Controllers\Admin;

use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Models\Admin\IpModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IpController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function allowIp()
    {
        return view('admin.allow_ip.ip');
    }

    public function addIp()
    {
        $input = $this->request->route()->parameters();
        $validator = Validator::make($input, [
            'id' => 'required|numeric|min:-1',
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            $ip = (new IpModel($input))->getIp();
            return view('admin.allow_ip.add', ['ip' => $ip]);
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function maniIp()
    {
        try {
            if ((new IpModel($this->request->all()))->maniIp()) {
                return self::json_success([], '操作成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function ipList()
    {
        $data = (new IpModel($this->request->all()))->listIp();
        $result['code'] = self::FAIL;
        $result['msg'] = '操作成功';
        $result['data'] = $data['data'];
        $result['count'] = $data['count'];

        return response()->json($result);
    }

    public function ipDelete()
    {
        try {
            if ((new IpModel($this->request->all()))->ipDelete()) {
                return self::json_success([], '操作成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }
}
