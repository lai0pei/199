<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: SmsConfigController.php
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
use App\Models\Admin\ConfigModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SmsConfigController extends Controller
{
    const MSG = '请求数据有误';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function smsConfig()
    {
        $sms = (new ConfigModel())->getConfig('smsConfig');
        return view('admin.sms_config.sms_config', ['sms' => $sms]);
    }

    public function saveSmsConfig()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'data' => 'required',
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }

            if((new ConfigModel($input))->saveConfig('smsConfig', '更新了后台短信配置')){
                return self::json_success( );
            }
  
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }
}
