<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: testAllRoute.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Tuesday, 11th January 2022 3:53:04 pm
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2022 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AGetRoute1AdminTest extends TestCase
{    
    use RefreshDatabase;

     /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    public function test_seed(){
        $this->seed();
    }

    public function test_admin_clear(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/clear');
        $response->assertSuccessful();
    }

    public function test_admin_login(){
        $response = $this->get('/6ucwfN@Bt/login');
        $response->assertSuccessful();
    }

    public function test_admin(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt');
        $response->assertSuccessful();
    }

    public function test_admin_ueditor(){
        $response = $this->withSession(['user_id'=>1])->get('/ueditor');
        $response->assertSuccessful();
    }

    public function test_admin_control(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/control');
        $response->assertSuccessful();
    }

    public function test_admin_person(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/person');
        $response->assertSuccessful();
    }

    public function test_admin_add_person(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/add_person');
        $response->assertSuccessful();
    }

    public function test_admin_list_admin(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/list_admin');
        $response->assertSuccessful();
    }

    public function test_admin_edit_admin(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/edit_person/1');
        $response->assertSuccessful();
    }

    public function test_admin_admin_group(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/admin_group');
        $response->assertSuccessful();
    }

    public function test_admin_group_add_index(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/group_add_index/1');
        $response->assertSuccessful();
    }

    public function test_admin_permission(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/permission/1');
        $response->assertSuccessful();
    }

    public function test_admin_get_role_permission(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/get_role_permission');
        $response->assertSuccessful();
    }

    public function test_admin_get_role(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/get_role');
        $response->assertSuccessful();
    }

    public function test_admin_auth_permission(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/auth_permission');
        $response->assertSuccessful();
    }

    public function test_admin_permission_show(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/permission_show');
        $response->assertSuccessful();
    }
    public function test_admin_log(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/log');
        $response->assertSuccessful();
    }
    public function test_admin_getLog(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/getLog');
        $response->assertSuccessful();
    }
    

 
}
