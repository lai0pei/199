<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminTest extends TestCase
{
    const URL = '/6ucwfN@Bt/add_person';
    const EDIT = '/6ucwfN@Bt/edit_person';
    const VIEW = '/6ucwfN@Bt/view_person';
    const SAVE = '/6ucwfN@Bt/save_admin';
    const DELETE = '/6ucwfN@Bt/delete_admin';

    public function test_add_new_admin()
    {
        $data = [
            'account' => 'admin12',
            'password' => '123456',
            'username' => '12',
            'role' => 1,
            'status' => 1,
        ];
        $response = $this->withSession(['user_id' => 1])->postJson(self::URL, $data);
        $response
            ->assertStatus(200)
            ->assertJson([
                'code' => 1,
                'msg' => '添加成功',
                'data' => [],
            ]);
    }

    public function test_add_new_admin_with_same_account()
    {
        $data = [
            'account' => 'admin',
            'password' => '123456',
            'username' => '12',
            'role' => 1,
            'status' => 1,
        ];
        $response = $this->withSession(['user_id' => 1])->postJson(self::URL, $data);
        $response
            ->assertStatus(200)
            ->assertJson([
                'code' => 0,
                'msg' => '登录账号已存在',
                'data' => [],
            ]);
    }

    public function test_add_new_admin_with_same_username()
    {
        $data = [
            'account' => 'admin223',
            'password' => '123456',
            'username' => 'admin',
            'role' => 1,
            'status' => 1,
        ];
        $response = $this->withSession(['user_id' => 1])->postJson(self::URL, $data);
        $response
            ->assertStatus(200)
            ->assertJson([
                'code' => 0,
                'msg' => '昵称已存在',
                'data' => [],
            ]);
    }

    public function test_add_new_admin_with_undefined_status()
    {
        $data = [
            'account' => 'admin223',
            'password' => '123456',
            'username' => 'admin',
            'role' => 1,
            'status' => 3,
        ];
        $response = $this->withSession(['user_id' => 1])->postJson(self::URL, $data);
        $response
            ->assertStatus(200)
            ->assertJson([
                'code' => 0,
                'msg' => '请求数据有误',
                'data' => [],
            ]);
    }

    public function test_edit_admin()
    {
        $response = $this->withSession(['user_id' => 1])->get(self::EDIT . '/1');
        $response->assertSuccessful();
    }

    public function test_edit_admin_without_id()
    {
        $response = $this->withSession(['user_id' => 1])->get(self::EDIT);
        $response
            ->assertStatus(200)
            ->assertJson([
                'code' => 0,
                'msg' => 'ID必须',
                'data' => [],
            ]);
    }

    public function test_edit_admin_with_invalidId()
    {
        $response = $this->withSession(['user_id' => 1])->get(self::EDIT . '/1000');
        $response->assertSuccessful();
    }

    public function test_view_admin()
    {
        $response = $this->withSession(['user_id' => 1])->get(self::VIEW . '/1');
        $response->assertSuccessful();
    }

    public function test_view_admin_without_id()
    {
        $response = $this->withSession(['user_id' => 1])->get(self::VIEW);
        $response
            ->assertStatus(200)
            ->assertJson([
                'code' => 0,
                'msg' => 'ID必须',
                'data' => [],
            ]);
    }

    public function test_view_admin_with_invalidId()
    {
        $response = $this->withSession(['user_id' => 1])->get(self::VIEW . '/1000');
        $response->assertSuccessful();
    }

    public function test_save_admin()
    {
        $data = [
            'id' => 1,
            'account' => 'admin223',
            'password' => '123456',
            'username' => 'admin',
            'role' => 1,
            'status' => 1,
        ];
        $response = $this->withSession(['user_id' => 1])->postJson(self::SAVE, $data);
        $response
            ->assertStatus(200)
            ->assertJson([
                'code' => 1,
                'msg' => '编辑成功',
                'data' => [],
            ]);
    }

    public function test_save_admin_must_pass_with_samename_and_account()
    {
        $data = [
            'id' => 1,
            'account' => 'admin',
            'password' => '123456',
            'username' => 'admin',
            'role' => 1,
            'status' => 1,
        ];
        $response = $this->withSession(['user_id' => 1])->postJson(self::SAVE, $data);
        $response
            ->assertStatus(200)
            ->assertJson([
                'code' => 1,
                'msg' => '编辑成功',
                'data' => [],
            ]);
    }

    public function test_save_admin_must_fail_with_same_account()
    {
        $data = [
            'id' => 3,
            'account' => 'admin',
            'password' => '123456',
            'username' => 'admin12',
            'role' => 1,
            'status' => 1,
        ];
        $response = $this->withSession(['user_id' => 1])->postJson(self::SAVE, $data);
        $response
            ->assertStatus(200)
            ->assertJson([
                'code' => 0,
                'msg' => '登录账号已存在',
                'data' => [],
            ]);
    }

    public function test_save_admin_must_fail_with_same_name()
    {
        $data = [
            'id' => 3,
            'account' => 'admin12',
            'password' => '123456',
            'username' => 'admin',
            'role' => 1,
            'status' => 1,
        ];
        $response = $this->withSession(['user_id' => 1])->postJson(self::SAVE, $data);
        $response
            ->assertStatus(200)
            ->assertJson([
                'code' => 0,
                'msg' => '昵称已存在',
                'data' => [],
            ]);
    }

    public function test_save_admin_with_invalidId()
    {
        $data = [
            'id' => 200,
            'account' => 'admin',
            'password' => '123456',
            'username' => 'admin',
            'role' => 1,
            'status' => 1,
        ];
        $response = $this->withSession(['user_id' => 1])->postJson(self::SAVE, $data);
        $response
            ->assertStatus(200)
            ->assertJson([
                'code' => 0,
                'msg' => '账号不存在',
                'data' => [],
            ]);
    }

    public function test_save_admin_prevent_disable_admin()
    {
        $data = [
            'id' => 1,
            'account' => 'admin',
            'password' => '123456',
            'username' => 'admin',
            'role' => 1,
            'status' => 0,
        ];
        $response = $this->withSession(['user_id' => 1])->postJson(self::SAVE, $data);
        $response
            ->assertStatus(200)
            ->assertJson([
                'code' => 0,
                'msg' => '总管理员不可禁用',
                'data' => [],
            ]);
    }

    public function test_delete_admin_with_invalidID()
    {
        $data = [
            'id' => 200,
        ];
        $response = $this->withSession(['user_id' => 1])->postJson(self::DELETE, $data);
        $response
            ->assertStatus(200)
            ->assertJson([
                'code' => 0,
                'msg' => '此管理员不存在',
                'data' => [],
            ]);
    }

    public function test_delete_admin_cant_delete()
    {
        $data = [
            'id' => 1,
        ];
        $response = $this->withSession(['user_id' => 1])->postJson(self::DELETE, $data);
        $response
            ->assertStatus(200)
            ->assertJson([
                'code' => 0,
                'msg' => '总管理员不可删除',
                'data' => [],
            ]);
    }

    public function test_delete_admin_without_id()
    {
        $data = [];
        $response = $this->withSession(['user_id' => 1])->postJson(self::DELETE, $data);
        $response
            ->assertStatus(200)
            ->assertJson([
                'code' => 0,
                'msg' => '请求数据有误',
                'data' => [],
            ]);
    }

    public function test_delete_admin()
    {
        $data = [
            'id' => 3,
        ];
        $response = $this->withSession(['user_id' => 1])->postJson(self::DELETE, $data);
        $response
            ->assertStatus(200)
            ->assertJson([
                'code' => 1,
                'msg' => '删除成功',
                'data' => [],
            ]);
    }

    

}
