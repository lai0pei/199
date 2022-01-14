<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: TestCase.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Monday, 27th December 2021 10:47:19 am
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2022 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    
    public const MSG = '请求数据有误';

    public function jsonGet($url, $isJson = 1, $data = [])
    {

        $response = $this->withSession(['user_id' => 1])->get($url);

        if ($isJson == 1) {
            $response
                ->assertStatus(200)
                ->assertJson($data);
        } else {
            $response->assertSuccessful();
        }
    }

    public function jsonPost($url, $data = [], $res = [])
    {
        $response = $this->withSession(['user_id' => 1])->postJson($url, $data);
        $response
            ->assertStatus(200)
            ->assertJson($res);

    }

    public function uploadPost($url, $data = [])
    {
        $response = $this->withSession(['user_id' => 1])->postJson($url, $data);
        $response->assertStatus(200);
        $content = json_decode($response->getContent(),true);
        $this->assertTrue('' !== $content['data']['src']);    
    }

   
}
