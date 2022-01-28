<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: GetRoute3AdminTest.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Tuesday, 11th January 2022 6:16:32 pm
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2022 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace Tests\Feature;

use Tests\TestCase;

class AGetRoute3AdminTest extends TestCase
{   

    public function __construct()
    {
        $this->prefix = config('admin.url_prefix');
    }
    
    public function test_admin_exportList(){
        $response = $this->withSession(['user_id'=>1])->get('/'.$this->prefix.'/exportList');
        $response->assertSuccessful();
    }

    public function test_admin_sms_apply(){
        $response = $this->withSession(['user_id'=>1])->get('/'.$this->prefix.'/sms_apply');
        $response->assertSuccessful();
    }

    public function test_admin_sms_list(){
        $response = $this->withSession(['user_id'=>1])->get('/'.$this->prefix.'/sms_list');
        $response->assertSuccessful();
    }

    public function test_admin_exportSmsList(){
        $response = $this->withSession(['user_id'=>1])->get('/'.$this->prefix.'/exportSmsList');
        $response->assertSuccessful();
    }

    public function test_admin_sms_import_index(){
        $response = $this->withSession(['user_id'=>1])->get('/'.$this->prefix.'/sms_import_index');
        $response->assertSuccessful();
    }

    public function test_admin_init(){
        $response = $this->withSession(['user_id'=>1])->get('/'.$this->prefix.'/init');
        $response->assertSuccessful();
    }

    public function test_add_event(){
        $response = $this->withSession(['user_id'=>1])->get('/'.$this->prefix.'/add_event');
        $response->assertSuccessful();
    }

    public function test_edit_type(){
        $response = $this->withSession(['user_id'=>1])->get('/'.$this->prefix.'/add_type/1');
        $response->assertSuccessful();
    }

  

    
}
