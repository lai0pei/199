<?php

namespace Tests\Feature;

use Tests\TestCase;

class BAdminFormTest extends TestCase
{   

    public function __construct()
    {
        $this->prefix = config('admin.url_prefix');
        $this->get = '/'.$this->prefix.'/form';
        $this->add = '/'.$this->prefix.'/form_add';
        $this->detail = '/'.$this->prefix.'/form_detail';
        $this->delete = '/'.$this->prefix.'/delete_form'; 
    }

  

    public function test_admin_form_get_with_negative_id()
    {

        $this->jsonGet($this->get . '/-100', 0);
    }

    public function test_admin_form_get_with_empty_data()
    {

        $this->jsonGet($this->get . '/100', 0);
    }

    public function test_admin_form_add()
    {
        $data = [
            'id' => -1,
            'type' => 4,
            'event_id' => 1,
            'name' => 'test',
            'sort' => 0,
        ];

        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];

        $this->jsonPost($this->add, $data, $res);
    }

    public function test_admin_form_add_for_save()
    {
        $data = [
            'id' => -1,
            'type' => 3,
            'event_id' => 1,
            'name' => 'test1',
            'sort' => 0,
        ];

        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];

        $this->jsonPost($this->add, $data, $res);
    }

    public function test_admin_form_add_double_pic()
    {
        $data = [
            'id' => -1,
            'type' => 4,
            'event_id' => 1,
            'name' => 'test',
            'sort' => 0,
        ];

        $res = [
            'code' => 0,
            'msg' => '最多一个图片框',
            'data' => [],
        ];

        $this->jsonPost($this->add, $data, $res);
    }

    public function test_admin_form_add_with_invalidInput()
    {
        $data = [
            'id' => -1,
            'type' => 0,
            'event_id' => 1,
            'name' => 'test',
        ];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost($this->add, $data, $res);
    }

    public function test_admin_form_save()
    {
        $data = [
            'id' => 1,
            'type' => 4,
            'event_id' => 1,
            'name' => 'test_save',
            'sort' => 0,
        ];

        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];

        $this->jsonPost($this->add, $data, $res);
    }

    public function test_admin_form_save_double_pic()
    {
        $data = [
            'id' => 2,
            'type' => 4,
            'event_id' => 1,
            'name' => 'test',
            'sort' => 0,
        ];

        $res = [
            'code' => 0,
            'msg' => '最多一个图片框',
            'data' => [],
        ];

        $this->jsonPost($this->add, $data, $res);
    }

    public function test_admin_form_save_empty_data()
    {
        $data = [
            'id' => 100,
            'type' => 2,
            'event_id' => 1,
            'name' => 'test',
            'sort' => 0,
        ];

        $res = [
            'code' => 0,
            'msg' => '保存失败',
            'data' => [],
        ];

        $this->jsonPost($this->add, $data, $res);
    }

    public function test_admin_form_detail()
    {
        $this->jsonGet($this->detail, '/1/1', 0);
    }

    public function test_admin_form_detail_without_event_id()
    {
        $this->jsonGet($this->detail, 0);
    }
    public function test_admin_form_detail_without_form_id()
    {
        $this->jsonGet($this->detail . '/1', 0);
    }

    public function test_admin_form_detail_without_invalid_event_id()
    {
        $this->jsonGet($this->detail . '/1000/1', 0);
    }

    public function test_admin_form_detail_without_invalid_form_id()
    {
        $this->jsonGet($this->detail . '/1/10000', 0);
    }

    public function test_admin_form_detail_without_invalid_form_id_and_event_id()
    {
        $this->jsonGet($this->detail . '/1000/10000', 0);
    }

    public function test_admin_delete_form_with_invalid_input()
    {
        $data = [

        ];
        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];
        $this->jsonPost($this->delete, $data, $res);
    }

    public function test_admin_delete_form_with_empty_id()
    {
        $data = [
            'id' => 1000,
        ];
        $res = [
            'code' => 0,
            'msg' => '删除失败',
            'data' => [],
        ];
        $this->jsonPost($this->delete, $data, $res);
    }

    public function test_admin_delete_form()
    {
        $data = [
            'id' => 1,
        ];
        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];
        $this->jsonPost($this->delete, $data, $res);
    }
}
