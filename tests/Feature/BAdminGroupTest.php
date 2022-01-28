<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: BAdminGroupTest.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Wednesday, 12th January 2022 2:12:31 pm
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2022 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace Tests\Feature;

use Tests\TestCase;

class BAdminGroupTest extends TestCase
{   
    public function __construct()
    {
        $this->prefix = config('admin.url_prefix');
        $this->index = '/'.$this->prefix.'/group_add_index';
        $this->add = '/'.$this->prefix.'/group_add';
        $this->delete = '/'.$this->prefix.'/group_delete';
        $this->permission = '/'.$this->prefix.'/permission';
        $this->submit = '/'.$this->prefix.'/submitList';
        $this->list = '/'.$this->prefix.'/permissionList';
    }
  

    public function test_admin_group_index_with_invalidId()
    {
        $this->jsonGet($this->index . '/1000', 0);
    }

    public function test_admin_group_index_without_Id()
    {
        $data = [
            'code' => 0,
            'msg' => 'ID必须',
            'data' => [],
        ];
        $this->jsonGet($this->index, 1, $data);
    }

    public function test_admin_group_add()
    {
        $data = [
            'id' => '-1',
            'role_name' => 'test',
            'status' => '0',
        ];

        $res = ['code' => 1, 'msg' => '操作成功', 'data' => []];
        $this->jsonPost($this->add , $data, $res);
    }

    public function test_admin_group_add_invalidInput()
    {
        $data = [
            'role_name' => 'test',
            'status' => '0',
        ];

        $res = ['code' => 0, 'msg' => '请求数据有误', 'data' => []];
        $this->jsonPost($this->add , $data, $res);
    }

    public function test_admin_group_add_with_negative_id()
    {
        $data = [
            'id' => '-100',
            'role_name' => 'test',
            'status' => '0',
        ];

        $res = ['code' => 0, 'msg' => '请求数据有误', 'data' => []];
        $this->jsonPost($this->add , $data, $res);
    }

    public function test_admin_group_add_with_invalid_status()
    {
        $data = [
            'id' => '-1',
            'role_name' => 'test',
            'status' => '3',
        ];

        $res = ['code' => 0, 'msg' => '请求数据有误', 'data' => []];
        $this->jsonPost($this->add , $data, $res);
    }

    public function test_admin_group_add_fail_with_same_name()
    {
        $data = [
            'id' => '-1',
            'role_name' => 'test',
            'status' => '1',
        ];

        $res = ['code' => 0, 'msg' => '同名称已存在', 'data' => []];
        $this->jsonPost($this->add , $data, $res);
    }

    public function test_admin_group_save_pass_with_same_name()
    {
        $data = [
            'id' => '2',
            'role_name' => 'test',
            'status' => '1',
        ];

        $res = ['code' => 1, 'msg' => '操作成功', 'data' => []];
        $this->jsonPost($this->add , $data, $res);
    }

    public function test_admin_group_save_fail_with_same_name()
    {
        $data = [
            'id' => '1',
            'role_name' => 'test',
            'status' => '1',
        ];

        $res = ['code' => 0, 'msg' => '同名称已存在', 'data' => []];
        $this->jsonPost($this->add , $data, $res);
    }

    public function test_admin_group_delete_without_id()
    {
        $data = [];

        $res = ['code' => 0, 'msg' => '请求数据有误', 'data' => []];
        $this->jsonPost($this->delete, $data, $res);
    }

    public function test_admin_group_delete_with_empty_group()
    {
        $data = [
            'id' => '1000',
        ];

        $res = ['code' => 0, 'msg' => '此管理员组不存在', 'data' => []];
        $this->jsonPost($this->delete, $data, $res);
    }

    public function test_admin_group_delete_with_master_group()
    {
        $data = [
            'id' => '1',
        ];

        $res = ['code' => 0, 'msg' => '总管理组不可删除', 'data' => []];
        $this->jsonPost($this->delete, $data, $res);
    }

    public function test_admin_group_permission_index()
    {
        $this->jsonGet($this->permission . '/1', 0);
    }

    public function test_admin_group_permission_index_without_id()
    {

        $this->jsonGet($this->permission, 0);
    }

    public function test_admin_group_permission_submit()
    {
        $data = [
            'id' => 2,
            'checked' => '[{"id":0,"title":"管理员","checked":false,"spread":true,"field":"node","type":1,"children":[{"checked":true,"id":29,"title":"添加","field":"node","type":1},{"checked":true,"id":30,"title":"编辑","field":"node","type":1},{"checked":true,"id":31,"title":"删除","field":"node","type":1},{"checked":true,"id":32,"title":"查看身份","field":"node","type":1}]}]',
        ];
        $res = ['code' => 1, 'msg' => '操作成功', 'data' => []];
        $this->jsonPost($this->submit, $data, $res);
    }

    public function test_admin_group_permission_submit_without_validInput()
    {
        $data = [
            'id' => 2,
        ];
        $res = ['code' => 0, 'msg' => '请求数据有误', 'data' => []];
        $this->jsonPost($this->submit, $data, $res);
    }

    public function test_admin_group_delete(){
        $data = [
            'id' => 2,
        ];
        $res = ['code' => 1, 'msg' => '删除成功', 'data' => []];
        $this->jsonPost($this->delete, $data, $res);
    }

    public function test_admin_group_permissionList(){
        $data = [
            'id' => 1,
        ];
        $res = ['code' => 1, 'msg' => '操作成功'];
        $this->jsonPost($this->list, $data, $res);
    }

    public function test_admin_group_permissionList_without_id(){
        $data = [  ];
        $res = ['code' => 0, 'msg' => '请求数据有误'];
        $this->jsonPost($this->list, $data, $res);
    }

    

}
