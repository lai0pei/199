<?php

namespace Tests\Feature;

use Tests\TestCase;

class BAdminIpTest extends TestCase
{   

    public $add = '/'.self::PREFIX.'/add_ip';
        public $mani = '/'.self::PREFIX.'/mani_ip';
        public $detele = '/'.self::PREFIX.'/delete_ip';

    public function test_admin_ip_add_index()
    {
        $this->jsonGet($this->add . '/-1', 0);
    }

    public function test_admin_ip_add_overflow_negative_id()
    {
        $data = [
            'code' => 0,
            'msg' => '请求数据有误',
            'data' => [],
        ];

        $this->jsonGet($this->add . '/-100', 1, $data);
    }

    public function test_admin_ip_edit_index_with_no_data()
    {
        $this->jsonGet($this->add . '/100', 0);
    }

    public function test_admin_ip_add_data()
    {
        $data = [
            'id' => '-1',
            'ip' => '127.0.0.1',
            'description' => '允许',
        ];

        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];
        $this->jsonPost($this->mani, $data, $res);
    }

    public function test_admin_ip_add_data_with_invalidInput()
    {
        $data = [
            'ip' => '127.0.0.1',
            'description' => '允许',
        ];

        $res = [
            'code' => 0,
            'msg' => '请求数据有误',
            'data' => [],
        ];

        $this->jsonPost($this->mani, $data, $res);
    }

    public function test_admin_ip_add_data_with_overflow_id()
    {
        $data = [
            'id' => '-1111',
            'ip' => '127.0.0.1',
            'description' => '允许',
        ];

        $res = [
            'code' => 0,
            'msg' => '请求数据有误',
            'data' => [],
        ];

        $this->jsonPost($this->mani, $data, $res);
    }

    
    public function test_admin_ip_edit_data()
    {
        $data = [
            'id' => '1',
            'ip' => '127.0.0.2',
            'description' => '允许',
        ];

        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];

        $this->jsonPost($this->mani, $data, $res);
    }

    public function test_admin_ip_edit_data_with_invalidId()
    {
        $data = [
            'id' => '200',
            'ip' => '127.0.0.2',
            'description' => '允许',
        ];

        $res = [
            'code' => 0,
            'msg' => '编辑失败',
            'data' => [],
        ];

        $this->jsonPost($this->mani, $data, $res);
    }

    public function test_admin_delete_with_invalidInput(){

        $data = [
            'ip' => '127.0.0.2',
            'description' => '允许',
        ];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost($this->detele, $data, $res);

    }

    public function test_admin_delete_with_invalidId(){

        $data = [
            'id' => '10000',
            'ip' => '127.0.0.2',
            'description' => '允许',
        ];

        $res = [
            'code' => 0,
            'msg' => '删除失败',
            'data' => [],
        ];

        $this->jsonPost($this->detele, $data, $res);

    }

    
    public function test_admin_delete(){

        $data = [
            'id' => '1',
        ];

        $res = [
            'code' => 1,
            'msg' => '删除成功',
            'data' => [],
        ];

        $this->jsonPost($this->detele, $data, $res);

    }


}
