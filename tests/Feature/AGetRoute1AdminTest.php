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
use Config;

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
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/clear');
        $response->assertSuccessful();
    }
  
    // public function test_admin_login(){
    //     $response = $this->get('/'.self::PREFIX.'/login');
    //     $response->assertSuccessful();
    // }

    public function test_admin(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX);
        $response->assertSuccessful();
    }

    public function test_admin_ueditor(){
        $response = $this->withSession(['user_id'=>1])->get('/ueditor');
        $response->assertSuccessful();
    }

    public function test_admin_control(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/control');
        $response->assertSuccessful();
    }

    public function test_admin_person(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/person');
        $response->assertSuccessful();
    }

    public function test_admin_add_person(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/add_person');
        $response->assertSuccessful();
    }

    public function test_admin_list_admin(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/list_admin');
        $response->assertSuccessful();
    }

    public function test_admin_edit_admin(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/edit_person/1');
        $response->assertSuccessful();
    }

    public function test_admin_admin_group(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/admin_group');
        $response->assertSuccessful();
    }

    public function test_admin_group_add_index(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/group_add_index/1');
        $response->assertSuccessful();
    }

    public function test_admin_permission(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/permission/1');
        $response->assertSuccessful();
    }

    public function test_admin_get_role_permission(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/get_role_permission');
        $response->assertSuccessful();
    }

    public function test_admin_get_role(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/get_role');
        $response->assertSuccessful();
    }

    public function test_admin_auth_permission(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/auth_permission');
        $response->assertSuccessful();
    }

    public function test_admin_permission_show(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/permission_show');
        $response->assertSuccessful();
    }
    public function test_admin_log(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/log');
        $response->assertSuccessful();
    }
    public function test_admin_getLog(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/getLog');
        $response->assertSuccessful();
    }
    

 
}
