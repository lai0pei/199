<?php

namespace Tests\Feature;

use Tests\TestCase;

class BAdminEventTypeTest extends TestCase
{
    const MANITYPE = '/6ucwfN@Bt/mani_type';

    public function test_admin_event_type_add(){

        $data = [
            'id' => -1,
            'name' => '棋牌',
            'status' => 0,
        ];

        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];

        $this->jsonPost(self::MANITYPE,$data,$res);
    }

    public function test_admin_event_type_add_withInvalidInput(){

        $data = [
            'name' => '棋牌',
            'status' => 0,
        ];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost(self::MANITYPE,$data,$res);
    }

    public function test_admin_event_type_add_with_negativeId(){

        $data = [
            'id' => -100,
            'name' => '棋牌',
            'status' => 0,
        ];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost(self::MANITYPE,$data,$res);
    }

    public function test_admin_event_type_save(){

        $data = [
            'id' => 7,
            'name' => '棋牌',
            'status' => 0,
        ];

        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];

        $this->jsonPost(self::MANITYPE,$data,$res);
    }

    public function test_admin_event_type_save_with_empty_record(){

        $data = [
            'id' => 7000,
            'name' => '没有',
            'status' => 0,
        ];

        $res = [
            'code' => 0,
            'msg' => '编辑失败',
            'data' => [],
        ];

        $this->jsonPost(self::MANITYPE,$data,$res);
    }

    public function test_admin_event_type_save_with_same_name(){

        $data = [
            'id' => 1,
            'name' => '棋牌',
            'status' => 0,
        ];

        $res = [
            'code' => 0,
            'msg' => '类型名称已存在',
            'data' => [],
        ];

        $this->jsonPost(self::MANITYPE,$data,$res);
    }
}
