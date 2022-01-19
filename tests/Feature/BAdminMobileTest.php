<?php

namespace Tests\Feature;

use Tests\TestCase;

class BAdminMobileTest extends TestCase
{
    const ADD = '/6ucwfN@Bt/addMobile';
    const DELETE = '/6ucwfN@Bt/deleteMobile';

    public function test_admin_add_mobile()
    {
        $data = [
            'mobile' => 16744736415,
        ];
        $res = [
            'code' => 1,
            'msg' => '添加、成功',
            'data' => [],
        ];
        $this->jsonPost(self::ADD, $data, $res);
    }

    public function test_admin_add_mobile_with_invalidPhoneNo()
    {
        $data = [
            'mobile' => 123456,
        ];
        $res = [
            'code' => 0,
            'msg' => '手机格式不对',
            'data' => [],
        ];
        $this->jsonPost(self::ADD, $data, $res);
    }

    public function test_admin_add_mobile_with_invalid_input()
    {
        $data = [
        ];
        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];
        $this->jsonPost(self::ADD, $data, $res);
    }

    public function test_admin_delete_mobile()
    {
        $data['id'] = [
            ['id' => 1],
        ];
        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];
        $this->jsonPost(self::DELETE, $data, $res);
    }

    public function test_admin_delete_mobile_with_invalid_input()
    {
        $data = ['id' => 0];
        $res = [
            'code' => 0,
            'msg' => '删除失败',
            'data' => [],
        ];
        $this->jsonPost(self::DELETE, $data, $res);
    }

}
