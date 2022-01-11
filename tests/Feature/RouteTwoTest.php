<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RouteTwoTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_admin_sms_config(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/sms_config');
        $response->assertSuccessful();
    }

    public function test_admin_get_allow_ip(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/allow_ip');
        $response->assertSuccessful();
    }

    public function test_admin_bulk_pass(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/bulk_pass');
        $response->assertSuccessful();
    }

    public function test_admin_common_settings(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/common_settings');
        $response->assertSuccessful();
    }

    public function test_admin_bulk_refuse(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/bulk_refuse');
        $response->assertSuccessful();
    }
    public function test_admin_link_management(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/link_management');
        $response->assertSuccessful();
    }
    public function test_admin_game_management(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/game_management');
        $response->assertSuccessful();
    }

    public function test_admin_announcement(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/announcement');
        $response->assertSuccessful();
    }

    public function test_admin_event_type(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/event_type');
        $response->assertSuccessful();
    }
    public function test_admin_type_list(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/type_list');
        $response->assertSuccessful();
    }
    public function test_admin_event_lists(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/event_lists');
        $response->assertSuccessful();
    }
    public function test_admin_get_list(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/get_list');
        $response->assertSuccessful();
    }

    public function test_admin_form_list(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/form_list');
        $response->assertSuccessful();
    }
    public function test_admin_mobile_management(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/mobile_management');
        $response->assertSuccessful();
    }
    public function test_admin_getMobile(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/getMobile');
        $response->assertSuccessful();
    }

    public function test_admin_Mobile(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/Mobile');
        $response->assertSuccessful();
    }

    public function test_admin_user_apply(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/user_apply');
        $response->assertSuccessful();
    }

    public function test_admin_user_apply_list(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/user_apply_list');
        $response->assertSuccessful();
    }

    
    
    /**
     * test_mobile_index
     *
     * @return void
     */
    public function test_mobile_index(){
       
        $routes = [
            '/',
            '/detail/event_id=1',
            '/getCaptcha',
        ];
  
        foreach($routes as $v){
            $response = $this->get($v);
            $response->assertSuccessful();
        }
    }
}