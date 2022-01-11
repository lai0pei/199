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

use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AllRouteTest extends TestCase
{    
    use RefreshDatabase;

    public function test_seed(){
        $this->seed();
    }
    /**
     * test_admin_index
     *
     * @return void
     */
    public function test_admin_index(){

        $routes = [
            '/6ucwfN@Bt/clear',
            '/6ucwfN@Bt/login',
            '/6ucwfN@Bt/captcha',
            '/ueditor',
            '/6ucwfN@Bt',
            '/6ucwfN@Bt/control',
            '/6ucwfN@Bt/person',
            '/6ucwfN@Bt/add_person',
            '/6ucwfN@Bt/list_admin',
            '/6ucwfN@Bt/edit_admin',
            '/6ucwfN@Bt/admin_group',
            '/6ucwfN@Bt/group_add_index/1',
            '/6ucwfN@Bt/permission/1',
            '/6ucwfN@Bt/get_role_permission',
            '/6ucwfN@Bt/get_role/1',
            '/6ucwfN@Bt/change_password',
            '/6ucwfN@Bt/auth_permission',
            '/6ucwfN@Bt/permission_show',
            '/6ucwfN@Bt/log',
            '/6ucwfN@Bt/getLog',
            '/6ucwfN@Bt/sms_config',
            '/6ucwfN@Bt/allow_ip',
            '/6ucwfN@Bt/bulk_pass',
            '/6ucwfN@Bt/common_settings',
            '/6ucwfN@Bt/bulk_refuse',
            '/6ucwfN@Bt/link_management',
            '/6ucwfN@Bt/game_management',
            '/6ucwfN@Bt/announcement',
            '/6ucwfN@Bt/event_type',
            '/6ucwfN@Bt/type_list',
            '/6ucwfN@Bt/event_lists',
            '/6ucwfN@Bt/get_list',
            '/6ucwfN@Bt/form_list',
            '/6ucwfN@Bt/mobile_management',
            '/6ucwfN@Bt/getMobile',
            '/6ucwfN@Bt/Mobile',
            '/6ucwfN@Bt/user_apply',
            '/6ucwfN@Bt/user_apply_list',
            '/6ucwfN@Bt/exportList',
            '/6ucwfN@Bt/sms_apply',
            '/6ucwfN@Bt/sms_list',
            '/6ucwfN@Bt/exportSmsList',
            '/6ucwfN@Bt/sms_import_index',
            '/6ucwfN@Bt/init',
        ];
        
        foreach($routes as $v){
            $response = $this->withSession(['user_id'=>1])->get($v);
                $response->assertSuccessful();
          
        }
       
    }
    
    /**
     * test_mobile_index
     *
     * @return void
     */
    public function test_mobile_index(){
       
        $routes = [
            '/',
            '/detail',
            '/getCaptcha',
        ];
  
        foreach($routes as $v){
            $response = $this->get($v);
            $response->assertSuccessful();
        }
    }
}
