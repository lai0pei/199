<?php

namespace Tests\Feature;

use Tests\TestCase;

class BAdminBulkConfigTest extends TestCase
{
    const REFUSESAVE = '/6ucwfN@Bt/refuse_save';
    const PASSSAVE = '/6ucwfN@Bt/pass_save';
    const LINKSAVE = '/6ucwfN@Bt/link_save';
    const GAMESAVE = '/6ucwfN@Bt/game_save';
    const ANNAVE = '/6ucwfN@Bt/announcement_save';

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

        $this->jsonPost(self::REFUSESAVE, $data, $res);
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

        $this->jsonPost(self::REFUSESAVE, $data, $res);
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

        $this->jsonPost(self::REFUSESAVE, $data, $res);
    }

    public function test_admin_refuse_save_with_empty_input()
    {
        $data = [];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost(self::REFUSESAVE, $data, $res);
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

        $this->jsonPost(self::PASSSAVE, $data, $res);
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

        $this->jsonPost(self::PASSSAVE, $data, $res);
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

        $this->jsonPost(self::PASSSAVE, $data, $res);
    }

    public function test_admin_pass_save_with_empty_input()
    {
        $data = [];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost(self::PASSSAVE, $data, $res);
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

        $this->jsonPost(self::LINKSAVE, $data, $res);
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

        $this->jsonPost(self::LINKSAVE, $data, $res);
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

        $this->jsonPost(self::LINKSAVE, $data, $res);
    }

    public function test_admin_link_save_with_empty_input()
    {
        $data = [];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost(self::LINKSAVE, $data, $res);
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

        $this->jsonPost(self::GAMESAVE, $data, $res);
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

        $this->jsonPost(self::GAMESAVE, $data, $res);
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

        $this->jsonPost(self::GAMESAVE, $data, $res);
    }

    public function test_admin_game_save_with_empty_input()
    {
        $data = [];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost(self::GAMESAVE, $data, $res);
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

        $this->jsonPost(self::ANNAVE, $data, $res);
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

        $this->jsonPost(self::ANNAVE, $data, $res);
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

        $this->jsonPost(self::ANNAVE, $data, $res);
    }

    public function test_admin_ann_save_with_empty_input()
    {
        $data = [];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost(self::ANNAVE, $data, $res);
    }
}
