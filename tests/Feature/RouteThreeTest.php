<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RouteThreeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_admin_exportList(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/exportList');
        $response->assertSuccessful();
    }

    public function test_admin_sms_apply(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/sms_apply');
        $response->assertSuccessful();
    }

    public function test_admin_sms_list(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/sms_list');
        $response->assertSuccessful();
    }

    public function test_admin_exportSmsList(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/exportSmsList');
        $response->assertSuccessful();
    }

    public function test_admin_sms_import_index(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/sms_import_index');
        $response->assertSuccessful();
    }

    public function test_admin_init(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/init');
        $response->assertSuccessful();
    }

    public function test_add_event(){
        $response = $this->withSession(['user_id'=>1])->get('/6ucwfN@Bt/add_event');
        $response->assertSuccessful();
    }
}
