<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: BAdminEventTypeTest.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Saturday, 15th January 2022 1:19:02 pm
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2022 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace Tests\Feature;

use Tests\TestCase;

class BAdminEventTypeTest extends TestCase
{   

        public $maniType = '/'.self::PREFIX.'/mani_type';
        public $addType = '/'.self::PREFIX.'/add_type';
        public $deleteType = '/'.self::PREFIX.'/delete_type';   
 

    public function test_admin_event_type_add()
    {

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

        $this->jsonPost($this->maniType, $data, $res);
    }

    public function test_admin_event_type_add_withInvalidInput()
    {

        $data = [
            'name' => '棋牌',
            'status' => 0,
        ];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost($this->maniType, $data, $res);
    }

    public function test_admin_event_type_add_with_negativeId()
    {

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

        $this->jsonPost($this->maniType, $data, $res);
    }

    public function test_admin_event_type_save_with_empty_record()
    {

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

        $this->jsonPost($this->maniType, $data, $res);
    }

    public function test_admin_event_type_save_with_same_name()
    {

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

        $this->jsonPost($this->maniType, $data, $res);
    }

    public function test_admin_event_type_add_index()
    {
        $this->jsonGet($this->addType, 0);
    }

    public function test_admin_event_type_edit()
    {
        $this->jsonGet($this->addType . '/2', 0);
    }

    public function test_admin_event_type_edit_with_negativeId()
    {
        $data = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];
        $this->jsonGet($this->addType . '/-200', 1, $data);
    }

    public function test_admin_event_type_edit_with_empty_data()
    {

        $this->jsonGet($this->addType . '/200', 0);
    }

    public function test_admin_event_type_save()
    {

        $data = [
            'id' => 7,
            'name' => '棋牌',
            'status' => 0,
            'sort' => 1,
        ];

        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];

        $this->jsonPost($this->maniType, $data, $res);
    }

    public function test_admin_event_type_delete()
    {
        $data = [
            'id' => 2,
        ];
        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];

        $this->jsonPost($this->deleteType, $data, $res);
    }

    public function test_admin_event_type_delete_with_eventExist()
    {
        $data = [
            'id' => 1,
        ];
        $res = [
            'code' => 0,
            'msg' => '此类型活动下还有其他活动,不可删除',
            'data' => [],
        ];

        $this->jsonPost($this->deleteType, $data, $res);
    }

    public function test_admin_event_type_delete_without_id()
    {
        $data = [];
        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost($this->deleteType, $data, $res);
    }

    public function test_admin_event_type_delete_with_emptyId()
    {
        $data = [
            'id' => 1000,
        ];
        $res = [
            'code' => 0,
            'msg' => '删除失败',
            'data' => [],
        ];

        $this->jsonPost($this->deleteType, $data, $res);
    }
}
