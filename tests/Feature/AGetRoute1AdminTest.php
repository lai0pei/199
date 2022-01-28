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

    public function __construct()
    {
        $this->prefix = config('admin.url_prefix');
    }

    public function test_seed(){
        $this->seed();
    }

    public function test_admin_clear(){
        $response = $this->withSession(['user_id'=>1])->get($this->prefix.'/clear');
        $response->assertSuccessful();
    }

    public function test_admin_login(){
        $response = $this->get('/'.$this->prefix.'/login');
        $response->assertSuccessful();
    }

    public function test_admin(){
        $response = $this->withSession(['user_id'=>1])->get('/'.$this->prefix);
        $response->assertSuccessful();
    }

    public function test_admin_ueditor(){
        $response = $this->withSession(['user_id'=>1])->get('/ueditor');
        $response->assertSuccessful();
    }

    public function test_admin_control(){
        $response = $this->withSession(['user_id'=>1])->get('/'.$this->prefix.'/control');
        $response->assertSuccessful();
    }

    public function test_admin_person(){
        $response = $this->withSession(['user_id'=>1])->get('/'.$this->prefix.'/person');
        $response->assertSuccessful();
    }

    public function test_admin_add_person(){
        $response = $this->withSession(['user_id'=>1])->get('/'.$this->prefix.'/add_person');
        $response->assertSuccessful();
    }

    public function test_admin_list_admin(){
        $response = $this->withSession(['user_id'=>1])->get('/'.$this->prefix.'/list_admin');
        $response->assertSuccessful();
    }

    public function test_admin_edit_admin(){
        $response = $this->withSession(['user_id'=>1])->get('/'.$this->prefix.'/edit_person/1');
        $response->assertSuccessful();
    }

    public function test_admin_admin_group(){
        $response = $this->withSession(['user_id'=>1])->get('/'.$this->prefix.'/admin_group');
        $response->assertSuccessful();
    }

    public function test_admin_group_add_index(){
        $response = $this->withSession(['user_id'=>1])->get('/'.$this->prefix.'/group_add_index/1');
        $response->assertSuccessful();
    }

    public function test_admin_permission(){
        $response = $this->withSession(['user_id'=>1])->get('/'.$this->prefix.'/permission/1');
        $response->assertSuccessful();
    }

    public function test_admin_get_role_permission(){
        $response = $this->withSession(['user_id'=>1])->get('/'.$this->prefix.'/get_role_permission');
        $response->assertSuccessful();
    }

    public function test_admin_get_role(){
        $response = $this->withSession(['user_id'=>1])->get('/'.$this->prefix.'/get_role');
        $response->assertSuccessful();
    }

    public function test_admin_auth_permission(){
        $response = $this->withSession(['user_id'=>1])->get('/'.$this->prefix.'/auth_permission');
        $response->assertSuccessful();
    }

    public function test_admin_permission_show(){
        $response = $this->withSession(['user_id'=>1])->get('/'.$this->prefix.'/permission_show');
        $response->assertSuccessful();
    }
    public function test_admin_log(){
        $response = $this->withSession(['user_id'=>1])->get('/'.$this->prefix.'/log');
        $response->assertSuccessful();
    }
    public function test_admin_getLog(){
        $response = $this->withSession(['user_id'=>1])->get('/'.$this->prefix.'/getLog');
        $response->assertSuccessful();
    }
    

 
}
