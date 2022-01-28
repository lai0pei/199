<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: BAdminAuthTest.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Thursday, 13th January 2022 8:05:56 am
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2022 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace Tests\Feature;

use Tests\TestCase;

class BAdminAuthTest extends TestCase
{

    public function __construct()
    {
        $this->prefix = config('admin.url_prefix');
        $this->view = '/'.$this->prefix.'/view_permission';    
    }

    
    public function test_admin_view_permission()
    {
       $this->jsonGet($this->view.'/1', 0);
    }

    public function test_admin_view_permission_with_invalidId()
    {
       $this->jsonGet($this->view.'/10000', 0);
    }


    public function test_admin_view_permission_with_invaldInput()
    {
        $data = [
            'code' => 0,
            'msg' => '请求数据有误',
            'data' => [],
        ];

        $this->jsonGet($this->view, 1, $data);
    }
}
