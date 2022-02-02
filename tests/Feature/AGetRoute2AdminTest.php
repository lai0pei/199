<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: GetRoute2AdminTest.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Tuesday, 11th January 2022 6:07:46 pm
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2022 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AGetRoute2AdminTest extends TestCase
{   

    public function test_admin_sms_config(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/sms_config');
        $response->assertSuccessful();
    }

    public function test_admin_get_allow_ip(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/allow_ip');
        $response->assertSuccessful();
    }

    public function test_admin_bulk_pass(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/bulk_pass');
        $response->assertSuccessful();
    }

    public function test_admin_common_settings(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/common_settings');
        $response->assertSuccessful();
    }

    public function test_admin_bulk_refuse(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/bulk_refuse');
        $response->assertSuccessful();
    }
    public function test_admin_link_management(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/link_management');
        $response->assertSuccessful();
    }
    public function test_admin_game_management(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/game_management');
        $response->assertSuccessful();
    }

    public function test_admin_announcement(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/announcement');
        $response->assertSuccessful();
    }

    public function test_admin_event_type(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/event_type');
        $response->assertSuccessful();
    }
    public function test_admin_type_list(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/type_list');
        $response->assertSuccessful();
    }
    public function test_admin_event_lists(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/event_lists');
        $response->assertSuccessful();
    }
    public function test_admin_get_list(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/get_list');
        $response->assertSuccessful();
    }

    public function test_admin_form_list(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/form_list');
        $response->assertSuccessful();
    }
    public function test_admin_mobile_management(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/mobile_management');
        $response->assertSuccessful();
    }
    public function test_admin_getMobile(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/getMobile');
        $response->assertSuccessful();
    }

    public function test_admin_Mobile(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/Mobile');
        $response->assertSuccessful();
    }

    public function test_admin_user_apply(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/user_apply');
        $response->assertSuccessful();
    }

    public function test_admin_user_apply_list(){
        $response = $this->withSession(['user_id'=>1])->get('/'.self::PREFIX.'/user_apply_list');
        $response->assertSuccessful();
    }

    
   
}
