<?php

namespace Tests\Feature;

use Tests\TestCase;

class BAdminIpTest extends TestCase
{
    const ADD = '/6ucwfN@Bt/add_ip';

    public function test_admin_ip_add_index()
    {
        $this->jsonGet(self::ADD . '/-1', 0);
    }

    public function test_admin_ip_add_overflow_negative_id()
    {
        $data = [
            'code' => 0,
            'msg' => '请求数据有误',
            'data' => []
        ];

        $this->jsonGet(self::ADD . '/-100', 1, $data);
    }

    public function test_admin_ip_edit_index_with_()
    {
        $this->jsonGet(self::ADD . '/-1', 0);
    }
}
