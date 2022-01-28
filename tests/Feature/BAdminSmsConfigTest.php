<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BAdminSmsConfigTest extends TestCase
{
    public $CONFIG = '/'.$this->prefix.'/sms_config';
    public $SAVE = '/'.$this->prefix.'/save_sms';

    public function test_admin_smsConfig()
    {
        $this->jsonGet(self::CONFIG, 0);
    }

    public function test_admin_smsConfig_save()
    {
        $data = [
            'data' => '{"cloud_key":"","cloud_sign":"","cloud_temp":"","ju_key":"","ju_sign":"","ju_id":"","status":"0"}',
        ];
        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];

        $this->jsonPost(self::SAVE, $data,$res);
    }

    public function test_admin_smsConfig_save_with_empty_input()
    {
        $data = [];
        $res = [
            'code' => 0,
            'msg' => '请求数据有误',
            'data' => [],
        ];

        $this->jsonPost(self::SAVE, $data,$res);
    }
}
