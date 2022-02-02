<?php

namespace Tests\Feature;

use App\Exceptions\LogicException;
use App\Models\Index\ApplyModel;
use Tests\TestCase;

class BAdminUserApplyTest extends TestCase
{   

    public $audit = '/'.self::PREFIX.'/userAuditIndex';
    public $apply = '/applyForm';
    public $save = '/'.self::PREFIX.'/save_audit_user';
    public $refuse = '/'.self::PREFIX.'/bulk_refuse';
    public $pass = '/'.self::PREFIX.'/bulk_pass';
    public $delete = '/'.self::PREFIX.'/bulk_delete';
    public $export = '/'.self::PREFIX.'/exportList';
    
    

    public function test_admin_audit_index()
    {
        $this->jsonGet($this->audit . '/1', 0);
    }

    public function test_admin_audit_index_without_id()
    {
        $this->jsonGet($this->audit, 0);
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

        $this->jsonPost($this->apply, $data, $res);
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

        $this->jsonPost($this->save, $data, $res);
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

        $this->jsonPost($this->save, $data, $res);
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

        $this->jsonPost($this->save, $data, $res);
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
        $this->jsonPost($this->refuse, $data, $res);
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
        $this->jsonPost($this->refuse, $data, $res);
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
        $this->jsonPost($this->refuse, $data, $res);
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
        $this->jsonPost($this->pass, $data, $res);
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
        $this->jsonPost($this->pass, $data, $res);
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
        $this->jsonPost($this->pass, $data, $res);
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
        $this->jsonPost($this->delete, $data, $res);
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
        $this->jsonPost($this->delete, $data, $res);
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
        $this->jsonPost($this->delete, $data, $res);
    }

    public function test_user_audit_export()
    {

        $response = $this->withSession(['user_id' => 1])->get($this->export);
        $response->assertDownload();

    }

}
