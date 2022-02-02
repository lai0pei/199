<?php

namespace Tests\Feature;

use App\Exceptions\LogicException;
use App\Models\Index\SmsApplyModel;
use Tests\TestCase;

class BAdminSmsTest extends TestCase
{   

    public $index = '/'.self::PREFIX.'/smsAuditIndex';
    public $save = '/'.self::PREFIX.'/save_audit_sms';
    public $refuse = '/'.self::PREFIX.'/bulksms_refuse';
    public $pass = '/'.self::PREFIX.'/bulksms_pass';
    public $delete = '/'.self::PREFIX.'/bulksms_delete';
    
    

    public function test_admin_sms()
    {
        $this->jsonGet($this->index . '/1', 0);
    }

    public function test_admin_sms_without_id()
    {
        $this->jsonGet($this->index, 0);
    }

    public function test_user_sms_add()
    {

        $data = [
            'eventId' => 1,
            'username' => "hi",
            'imageUrl' => 'link',
            'gameName' => 'hello',
            'mobile' => '1234',
            'form' => '',
        ];

        $userApply = new SmsApplyModel($data);
        $this->assertTrue($userApply->smsForm());
    }

    public function test_user_sms_add_exceed_limit()
    {
        $data = [
            'eventId' => 1,
            'username' => "hi",
            'mobile' => '1234',
        ];
        $this->expectException(LogicException::class);
        $userApply = new SmsApplyModel($data);
        $userApply->smsForm();
    }

    public function test_admin_sms_save(){
        $data = [
            'id' => 1,
            'state' => 1,
            'send_remark' => 'jj',
        ];
        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];

        $this->jsonPost($this->save,$data, $res);
    }

    public function test_admin_sms_save_with_invalid_id(){
        $data = [
  
        ];
        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost($this->save,$data, $res);
    }

    public function test_admin_refuse_sms(){
        $data['data'] = [
            ['id' => 1]
        ];
        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];
        $this->jsonPost($this->refuse,$data,$res);
    }

    public function test_admin_refuse_sms_with_invalid_input(){
        $data = [
          
        ];
        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];
        $this->jsonPost($this->refuse,$data,$res);
    }

    public function test_admin_refuse_sms_with_invalid_input2(){
        $data['data'] = [
          'id' => 1,
          'id' => 200,
        ];
        $res = [
            'code' => 0,
            'msg' => '审核失败',
            'data' => [],
        ];
        $this->jsonPost($this->refuse,$data,$res);
    }

    public function test_admin_pass_sms(){
        $data['data'] = [
            ['id' => 1]
        ];
        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];
        $this->jsonPost($this->pass,$data,$res);
    }

    public function test_admin_pass_sms_with_invalid_input(){
        $data = [
          
        ];
        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];
        $this->jsonPost($this->pass,$data,$res);
    }

    public function test_admin_pass_sms_with_invalid_input2(){
        $data['data'] = [
          'id' => 1,
          'id' => 200,
        ];
        $res = [
            'code' => 0,
            'msg' => '审核失败',
            'data' => [],
        ];
        $this->jsonPost($this->pass,$data,$res);
    }

    public function test_admin_delete_sms(){
        $data['data'] = [
            ['id' => 1]
        ];
        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];
        $this->jsonPost($this->delete,$data,$res);
    }

    public function test_admin_delete_sms_with_invalid_input(){
        $data = [
          
        ];
        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];
        $this->jsonPost($this->delete,$data,$res);
    }

    public function test_admin_delete_sms_with_invalid_input2(){
        $data['data'] = [
          'id' => 1,
          'id' => 200,
        ];
        $res = [
            'code' => 0,
            'msg' => '删除失败',
            'data' => [],
        ];
        $this->jsonPost($this->delete,$data,$res);
    }
}
