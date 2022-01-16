<?php

namespace Tests\Feature;

use Tests\TestCase;

class BAdminAddEventTest extends TestCase
{
    const ADD = '/6ucwfN@Bt/add_event';
    const MANI = '/6ucwfN@Bt/mani_event';

    public function test_admin_add_event_index()
    {
        $this->jsonGet(self::ADD . '/-1', 0);
    }

    public function test_admin_add_event_index_with_negativeId()
    {
        $data = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];
        $this->jsonGet(self::ADD . '/-100', 1, $data);
    }

    public function test_admin_save_event_index()
    {
        $this->jsonGet(self::ADD . '/1', 0);
    }

    public function test_admin_save_event_index_with_emptyData()
    {
        $this->jsonGet(self::ADD . '/1000', 0);
    }

    public function test_admin_add_event_mani()
    {
        $data = [
            'id' => -1,
            'name' => 'new event',
            'type_id' => '1',
            'type_pic' => 'pic_url',
            'start_time' => '2022-01-16 05:46:56',
            'end_time' => '2022-01-16 05:46:56',
        ];
        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];

        $this->jsonPost(self::MANI, $data, $res);
    }

    public function test_admin_add_event_mani_with_invalidInput()
    {
        $data = [
            'name' => 'new event',
            'type_id' => '1',
            'type_pic' => 'pic_url',
            'start_time' => '2022-01-16 05:46:56',
            'end_time' => '2022-01-16 05:46:56',
        ];
        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost(self::MANI, $data, $res);
    }

    public function test_admin_save_event_mani()
    {
        $data = [
            'id' => 2,
            'name' => 'new event 2',
            'type_id' => '1',
            'type_pic' => 'pic_url',
            'start_time' => '2022-01-16 05:46:56',
            'end_time' => '2022-01-16 05:46:56',
        ];
        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];

        $this->jsonPost(self::MANI, $data, $res);
    }

    public function test_admin_save_event_mani_with_emptyData()
    {
        $data = [
            'id' => 200,
            'name' => 'new event 2',
            'type_id' => '1',
            'type_pic' => 'pic_url',
            'start_time' => '2022-01-16 05:46:56',
            'end_time' => '2022-01-16 05:46:56',
        ];

        $res = [
            'code' => 0,
            'msg' => '保存失败',
            'data' => [],
        ];

        $this->jsonPost(self::MANI, $data, $res);
    }

    public function test_admin_save_event_mani_with_sms_on()
    {
        $data = [
            'id' => 2,
            'name' => 'new event 3',
            'type_id' => '1',
            'type_pic' => 'pic_url',
            'start_time' => '2022-01-16 05:46:56',
            'end_time' => '2022-01-16 05:46:56',
            'is_sms' => 'on',
        ];

        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];

        $this->jsonPost(self::MANI, $data, $res);
    }

}
