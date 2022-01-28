<?php

namespace Tests\Feature;

use App\Exceptions\LogicException;
use App\Models\Index\ApplyModel;
use Tests\TestCase;

class BAdminUserApplyTest extends TestCase
{
    public $AUDIT = '/'.$this->prefix.'/userAuditIndex';
    public $APPLY = '/applyForm';
    public $SAVE = '/'.$this->prefix.'/save_audit_user';
    public $REFUSE = '/'.$this->prefix.'/bulk_refuse';
    public $PASS = '/'.$this->prefix.'/bulk_pass';
    public $DELETE = '/'.$this->prefix.'/bulk_delete';
    public $EXPORT = '/'.$this->prefix.'/exportList';

    public function test_admin_audit_index()
    {
        $this->jsonGet(self::AUDIT . '/1', 0);
    }

    public function test_admin_audit_index_without_id()
    {
        $this->jsonGet(self::AUDIT, 0);
    }

    public function test_user_audit_add_withInvalidInput()
    {
        $data = [
        ];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost(self::APPLY, $data, $res);
    }

    public function test_user_apply_add()
    {
        $data = [
            'eventId' => 2,
            'username' => "hi",
        ];
        $userApply = new ApplyModel($data);

        $this->assertTrue($userApply->applyForm());
    }

    public function test_user_apply_add_limit_exceed()
    {
        $data = [
            'eventId' => 2,
            'username' => "hi",
        ];
        $this->expectException(LogicException::class);
        $userApply = new ApplyModel($data);
        $userApply->applyForm();
    }

    public function test_user_audit_save()
    {
        $data = [
            'id' => 1,
            'status' => 1,
        ];

        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];

        $this->jsonPost(self::SAVE, $data, $res);
    }

    public function test_user_audit_save_with_invalid_id()
    {
        $data = [

        ];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost(self::SAVE, $data, $res);
    }

    public function test_user_audit_save_with_invalid_status()
    {
        $data = [
            'id' => 1,
            'status' => 100,
        ];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost(self::SAVE, $data, $res);
    }

    public function test_user_audit_refuse()
    {
        $data['data'] = [
            ['id' => 1],
        ];
        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];
        $this->jsonPost(self::REFUSE, $data, $res);
    }

    public function test_user_audit_refuse_with_invalid_id()
    {
        $data['data'] = [

        ];
        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];
        $this->jsonPost(self::REFUSE, $data, $res);
    }

    public function test_user_audit_refuse_with_emtpy_data()
    {
        $data['data'] = [
            ['id' => 1],
            ['id' => 2],
        ];
        $res = [
            'code' => 0,
            'msg' => '审核失败',
            'data' => [],
        ];
        $this->jsonPost(self::REFUSE, $data, $res);
    }

    public function test_user_audit_pass()
    {
        $data['data'] = [
            ['id' => 1],
        ];
        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];
        $this->jsonPost(self::PASS, $data, $res);
    }

    public function test_user_audit_pass_with_invalid_id()
    {
        $data['data'] = [

        ];
        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];
        $this->jsonPost(self::PASS, $data, $res);
    }

    public function test_user_audit_pass_with_emtpy_data()
    {
        $data['data'] = [
            ['id' => 1],
            ['id' => 2],
        ];
        $res = [
            'code' => 0,
            'msg' => '审核失败',
            'data' => [],
        ];
        $this->jsonPost(self::PASS, $data, $res);
    }

    public function test_user_audit_delete()
    {
        $data['data'] = [
            ['id' => 1],
        ];
        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];
        $this->jsonPost(self::DELETE, $data, $res);
    }

    public function test_user_audit_delete_with_invalid_id()
    {
        $data['data'] = [

        ];
        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];
        $this->jsonPost(self::DELETE, $data, $res);
    }

    public function test_user_audit_delete_with_emtpy_data()
    {
        $data['data'] = [
            ['id' => 1],
            ['id' => 2],
        ];
        $res = [
            'code' => 0,
            'msg' => '删除失败',
            'data' => [],
        ];
        $this->jsonPost(self::DELETE, $data, $res);
    }

    public function test_user_audit_export()
    {

        $response = $this->withSession(['user_id' => 1])->get(self::EXPORT);
        $response->assertDownload();

    }

}
