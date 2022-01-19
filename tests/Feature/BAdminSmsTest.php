<?php

namespace Tests\Feature;

use App\Exceptions\LogicException;
use App\Models\Index\SmsApplyModel;
use Tests\TestCase;

class BAdminSmsTest extends TestCase
{
    const INDEX = '/6ucwfN@Bt/smsAuditIndex';
    const SAVE = '/6ucwfN@Bt/save_audit_sms';
    const SMS = '/applyForm';
    const REFUSE = '/6ucwfN@Bt/bulksms_refuse';
    const PASS = '/6ucwfN@Bt/bulksms_pass';
    const DELETE = '/6ucwfN@Bt/bulksms_delete';
    

    public function test_admin_sms()
    {
        $this->jsonGet(self::INDEX . '/1', 0);
    }

    public function test_admin_sms_without_id()
    {
        $this->jsonGet(self::INDEX, 0);
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

    public function test_user_sms_add_second()
    {

        $data = [
            'eventId' => 1,
            'username' => "hi",
            'mobile' => '1234',
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

        $this->jsonPost(self::SAVE,$data, $res);
    }

    public function test_admin_sms_save_with_invalid_id(){
        $data = [
  
        ];
        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost(self::SAVE,$data, $res);
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
        $this->jsonPost(self::REFUSE,$data,$res);
    }

    public function test_admin_refuse_sms_with_invalid_input(){
        $data = [
          
        ];
        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];
        $this->jsonPost(self::REFUSE,$data,$res);
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
        $this->jsonPost(self::REFUSE,$data,$res);
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
        $this->jsonPost(self::PASS,$data,$res);
    }

    public function test_admin_pass_sms_with_invalid_input(){
        $data = [
          
        ];
        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];
        $this->jsonPost(self::PASS,$data,$res);
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
        $this->jsonPost(self::PASS,$data,$res);
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
        $this->jsonPost(self::DELETE,$data,$res);
    }

    public function test_admin_delete_sms_with_invalid_input(){
        $data = [
          
        ];
        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];
        $this->jsonPost(self::DELETE,$data,$res);
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
        $this->jsonPost(self::DELETE,$data,$res);
    }
}
