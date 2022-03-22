<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: yuanpian.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Sunday, 2nd January 2022 11:59:39 am
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2022 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Http\Controllers\Index\util;

use App\Exceptions\LogicException;
use Illuminate\Support\Facades\Log;

trait YunPian
{
    protected $url = 'https://sms.yunpian.com/v2/sms/single_send.json';

    public function yunPianSms($params)
    {
        try {
            $response = $this->post('https://sms.yunpian.com/v2/sms/single_send.json', $params);

            if (! $response) {
                throw new LogicException('手机号码不支持');
            }

            if ($response['code'] !== 0) {
                Log::channel('sms')->debug($response);
                throw new LogicException('发送失败');
            }
        } catch (LogicException $e) {
            throw new LogicException($e->getMessage());
        }
        return true;
    }

    private function post($url, $params)
    {
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curlHandle, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36');
        curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 12);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_POST, true);
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curlHandle);
        if ($response === false) {
            Log::channel('sms')->error(curl_error($curlHandle));
            return false;
        }
        
        curl_close($curlHandle);

        return json_decode($response, true, 512, JSON_THROW_ON_ERROR);
    }
}
