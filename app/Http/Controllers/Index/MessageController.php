<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: MessageController.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Sunday, 2nd January 2022 9:41:35 am
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2022 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Index\util\generateCode;
use App\Http\Controllers\Index\util\juhe;
use App\Http\Controllers\Index\util\yunpian;
use App\Models\Admin\ConfigModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use LogicException;

class MessageController extends Controller
{
    use juhe;
    use yunpian;
    use generateCode;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function smsMessage()
    {
        $smsConfig = (new ConfigModel())->getConfig('smsConfig');
        $all = $this->request->all();
        $validator = Validator::make($all, [
            'mobile' => 'required',
            'captcha' => 'required',
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException('请求数据不正确');
            }
            $mobile = $all['mobile'];
            $captch = $all['captcha'];

            if (! captcha_check($captch)) {
                throw new LogicException('验证码不正确');
            }

            $code = $this->getCode($mobile);

            return self::json_success([], '发送成功');

            // if ($smsConfig['status'] == 1) {

            //     $params = [
            //         // 模板id
            //         'tpl_id' => $smsConfig['ju_id'],
            //         // 您申请的接口调用Key
            //         'key' => $smsConfig['ju_key'],
            //         //发送的手机号
            //         'mobile' => $mobile,
            //         //结合自己的模板中的变量进行设置，如果没有变量，可以删除此参数
            //         'tpl_value' => urlencode('#code#=' . $code),
            //     ];

            //     if ($this->juheSms($params)) {
            //         return self::json_success([], '发送成功');
            //     }
            // } else {
            //     $params = [
            //         'apikey' => $smsConfig['cloud_key'],
            //         'mobile' => $mobile,
            //         'text' => str_replace("#code#", $code, $smsConfig['cloud_temp']),
            //     ];

            //     if ($this->yunPianSms($params)) {
            //         return self::json_success([], '发送成功');
            //     }
            // }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }
}
