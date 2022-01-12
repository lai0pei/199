<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: LogController.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Tuesday, 4th January 2022 8:04:00 am
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2022 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\LogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use LogicException;

class LogController extends Controller
{

    const MSG = '请求数据有误';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function log()
    {
        $data = (new LogModel($this->request->all()))->logType();
        return view('admin.log.log', ['data' => $data]);
    }

    public function getLog()
    {
        $data = (new LogModel($this->request->all()))->log();

        $result['code'] = self::FAIL;
        $result['msg'] = '操作成功';
        $result['data'] = $data['data'];
        $result['count'] = $data['count'];

        return response()->json($result);
    }

    public function detailLog()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'id' => 'required',
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            $log = (new LogModel($this->request->route()->parameters()))->detailLog();
            return view('admin.log.logcheck', ['log' => $log]);
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }
}
