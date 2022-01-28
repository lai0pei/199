<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BAdminLogTest extends TestCase
{   
    public function __construct()
    {
        $this->prefix = config('admin.url_prefix');
        $this->log = '/'.$this->prefix.'/detailLog';
    }

   

    public function test_log_index_with_empty()
    {
        $this->jsonGet($this->log.'/1',0);
    }

    public function test_log_index_with_invalidInput()
    {   
        $res = [
            'code' => '0',
            'msg' => '请求数据有误',
            'data'=>[],
        ];

        $this->jsonGet($this->log,1,$res);
    }
}
