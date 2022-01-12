<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: BAdminPasswordTest.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Wednesday, 12th January 2022 4:36:46 pm
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2022 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace Tests\Feature;

use Tests\TestCase;

class BAdminPasswordTest extends TestCase
{
    const PASSWORD = '/6ucwfN@Bt/change_password';

    public function test_password_index()
    {
        $this->jsonGet(self::PASSWORD,0);
    }

    public function test_password_change()
    {
        $data = [
            'old' => '123456',
            'new' => '12345',
            're-new' => '12345',
        ];
        $res = [
            'code' => 1,
            'msg' => '修改成功',
            'data' => [],
        ];
        $this->jsonPost(self::PASSWORD, $data, $res);
    }

    public function test_password_change_with_invalidInput()
    {
        $data = [
            'old' => '12345',
        ];
        $res = [
            'code' => 0,
            'msg' => '请求数据有误',
            'data' => [],
        ];
        $this->jsonPost(self::PASSWORD, $data, $res);
    }

    public function test_password_change_not_the_same_userInput()
    {
        $data = [
            'old' => '12345',
            'new' => '123456',
            're-new' => '1234',
        ];
        $res = [
            'code' => 0,
            'msg' => '密码不一致',
            'data' => [],
        ];
        $this->jsonPost(self::PASSWORD, $data, $res);
    }

    public function test_password_change_old_one_not_correct()
    {
        $data = [
            'old' => '123457',
            'new' => '12345',
            're-new' => '12345',
        ];
        $res = [
            'code' => 0,
            'msg' => '老密码不正确',
            'data' => [],
        ];
        $this->jsonPost(self::PASSWORD, $data, $res);
    }
}
