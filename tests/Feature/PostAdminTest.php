<?php

namespace Tests\Feature;

use Tests\TestCase;

class PostAdminTest extends TestCase
{

    public $LOGOUT = '/'.$this->prefix.'/logout';
    public $INIT = '/'.$this->prefix.'/init';
    public $CLEAR = '/'.$this->prefix.'/clear';

    public function test_admin_logout_test()
    {

        $res = [
            'code' => 1,
            'msg' => '成功登出',
            'data' => [],
        ];
        $response = $this->withSession(['user_id' => 1])->postJson(self::LOGOUT);
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
        $response = $this->postJson(self::LOGOUT);
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
        $response = $this->withSession(['user_id' => 100])->postJson(self::LOGOUT);
        $response
            ->assertStatus(200)
            ->assertJson($res);
    }

    public function test_admin_init_wrong_session()
    {
        $this->jsonGet(self::CLEAR);
        $this->jsonGet(self::INIT);
    }
}
