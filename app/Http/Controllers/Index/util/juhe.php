<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: juhe.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Sunday, 2nd January 2022 9:45:47 am
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2022 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Http\Controllers\Index\util;

use App\Exceptions\LogicException;
use Illuminate\Support\Facades\Log;

trait JuHe
{
    protected $juheUrl = 'http://v.juhe.cn/sms/send?';

    public function juheSms($params)
    {
        // 请求参数
        $paramsString = http_build_query($params);

        $message = '发送失败';
        // 发起接口网络请求
        $response = null;

        try {
            $response = $this->juheHttpRequest($this->juheUrl, $paramsString, 1);
        } catch (LogicException $e) {
            throw new LogicException($e);
        }

        if (! $response) {
            Log::channel('sms')->debug($response);
            throw new LogicException($message);
        }
        
        $result = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

        if (! $result) {
            Log::channel('sms')->debug($result);
            throw new LogicException($message);
        }

        if ($result['error_code'] !== 0) {
            Log::channel('sms')->debug($result);
            throw new LogicException('手机号码不支持');
        }
        return true;
    }

    /**
     * 发起网络请求函数
     *
     * @param string $url 请求的URL
     * @param bool $params 请求的参数内容
     * @param int $ispost 是否POST请求
     *
     * @return bool|string 返回内容
     */
    private function juheHttpRequest($url, $params = false, $ispost = 0): bool|string
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 12);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($ispost !== 0) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_URL, $url);
        } elseif ($params) {
            curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
        } else {
            curl_setopt($ch, CURLOPT_URL, $url);
        }
        
        $response = curl_exec($ch);
        if ($response === false) {
            Log::channel('sms')->error(curl_error($ch));
            return json_decode(curl_error($ch), true, 512, JSON_THROW_ON_ERROR);
        }
        curl_close($ch);
        return $response;
    }
}
