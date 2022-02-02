<?php

namespace Tests\Feature;

use Tests\TestCase;

class BAdminBulkConfigTest extends TestCase
{   


        public $refuseSave = '/'.self::PREFIX.'/refuse_save';    
        public $passwordSave = '/'.self::PREFIX.'/pass_save';
        public $linkSave = '/'.self::PREFIX.'/link_save';
        public $gameSave = '/'.self::PREFIX.'/game_save';
        public $anNave = '/'.self::PREFIX.'/announcement_save';
    



    public function test_admin_refuse_save()
    {
        $data = [
            'data' => '{"refuse":"ff"}',
        ];

        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => true,
        ];

        $this->jsonPost($this->refuseSave, $data, $res);
    }

    public function test_admin_refuse_save_withInvalidInput()
    {
        $data = [
            'invalid' => '{"refuse":"ff"}',
        ];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost($this->refuseSave, $data, $res);
    }

    public function test_admin_refuse_save_withNotProperJsoned()
    {
        $data = [
            'data' => ["refuse" => "ff"],
        ];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost($this->refuseSave, $data, $res);
    }

    public function test_admin_refuse_save_with_empty_input()
    {
        $data = [];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost($this->refuseSave, $data, $res);
    }

    public function test_admin_pass_save()
    {
        $data = [
            'data' => '{"pass":"ff"}',
        ];

        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => true,
        ];

        $this->jsonPost($this->passwordSave, $data, $res);
    }

    public function test_admin_pass_save_withInvalidInput()
    {
        $data = [
            'invalid' => '{"pass":"ff"}',
        ];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost($this->passwordSave, $data, $res);
    }

    public function test_admin_pass_save_withNotProperJsoned()
    {
        $data = [
            'data' => ["pass" => "ff"],
        ];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost($this->passwordSave, $data, $res);
    }

    public function test_admin_pass_save_with_empty_input()
    {
        $data = [];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost($this->passwordSave, $data, $res);
    }

    public function test_admin_link_save()
    {
        $data = [
            'data' => '{"link":"ff"}',
        ];

        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => true,
        ];

        $this->jsonPost($this->linkSave, $data, $res);
    }

    public function test_admin_link_save_withInvalidInput()
    {
        $data = [
            'invalid' => '{"link":"ff"}',
        ];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost($this->linkSave, $data, $res);
    }

    public function test_admin_link_save_withNotProperJsoned()
    {
        $data = [
            'data' => ["link" => "ff"],
        ];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost($this->linkSave, $data, $res);
    }

    public function test_admin_link_save_with_empty_input()
    {
        $data = [];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost($this->linkSave, $data, $res);
    }

    public function test_admin_game_save()
    {
        $data = [
            'data' => '{"game":"ff"}',
        ];

        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => true,
        ];

        $this->jsonPost($this->gameSave, $data, $res);
    }

    public function test_admin_game_save_withInvalidInput()
    {
        $data = [
            'invalid' => '{"game":"ff"}',
        ];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost($this->gameSave, $data, $res);
    }

    public function test_admin_game_save_withNotProperJsoned()
    {
        $data = [
            'data' => ["game" => "ff"],
        ];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost($this->gameSave, $data, $res);
    }

    public function test_admin_game_save_with_empty_input()
    {
        $data = [];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost($this->gameSave, $data, $res);
    }

    public function test_admin_ann_save()
    {
        $data = [
            'data' => '{"ann":"ff"}',
        ];

        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => true,
        ];

        $this->jsonPost($this->anNave, $data, $res);
    }

    public function test_admin_ann_save_withInvalidInput()
    {
        $data = [
            'invalid' => '{"ann":"ff"}',
        ];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost($this->anNave, $data, $res);
    }

    public function test_admin_ann_save_withNotProperJsoned()
    {
        $data = [
            'data' => ["ann" => "ff"],
        ];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost($this->anNave, $data, $res);
    }

    public function test_admin_ann_save_with_empty_input()
    {
        $data = [];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost($this->anNave, $data, $res);
    }
}
