<?php

namespace Tests\Feature;

use Tests\TestCase;

class PostAdminTest extends TestCase
{


    public $logout = '/'.self::PREFIX.'/logout';
    public $init = '/'.self::PREFIX.'/init';
    public $clear = '/'.self::PREFIX.'/clear';


 

    public function test_admin_logout_test()
    {

        $res = [
            'code' => 1,
            'msg' => '成功登出',
            'data' => [],
        ];
        $response = $this->withSession(['user_id' => 1])->postJson($this->logout);
        $response
            ->assertStatus(200)
            ->assertJson($res);
    }

    public function test_admin_logout_test_without_session()
    {

        $res = [
            'code' => 1,
            'msg' => '成功登出',
            'data' => [],
        ];
        $response = $this->postJson($this->logout);
        $response
            ->assertStatus(200)
            ->assertJson($res);
    }

    public function test_admin_logout_test_with_wrong_session()
    {

        $res = [
            'code' => 1,
            'msg' => '成功登出',
            'data' => [],
        ];
        $response = $this->withSession(['user_id' => 100])->postJson($this->logout);
        $response
            ->assertStatus(200)
            ->assertJson($res);
    }

    public function test_admin_init_wrong_session()
    {
        $this->jsonGet($this->clear);
        $this->jsonGet($this->init);
    }
}
