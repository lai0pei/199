<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\SmsEventModel;
use Illuminate\Http\Request;
use LogicException;

class SmsController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function sms()
    {
        $data = (new SmsEventModel($this->request->all()))->getType();
        return view('admin.sms.sms_apply', ['is_match' => $data['is_match'],'state' => $data['state'],'is_send' => $data['is_send']]);
    }

    public function smsEventList()
    {
        $data = (new SmsEventModel($this->request->all()))->smsList();
        $result['code'] = self::FAIL;
        $result['msg'] = '操作成功';
        $result['data'] = $data['data'];
        $result['count'] = $data['count'];

        return response()->json($result);
    }

    public function smsAuditIndex()
    {
        $data = (new SmsEventModel($this->request->route()->parameters()))->smsAudit();
        return view('admin.sms.audit_sms', ['data' => $data]);
    }

    public function saveSms()
    {
        return self::json_success((new SmsEventModel($this->request->all()))->saveSms());
    }

    public function deleteSms()
    {
        try {
            if ((new SmsEventModel($this->request->all()))->delete()) {
                return self::json_success();
            }
        } catch (LogicException $e) {
            return self::json_fail($e->getMessage());
        }
    }

    public function refuseSms()
    {
        try {
            if ((new SmsEventModel($this->request->all()))->audit(SmsEventModel::REFUSE)) {
                return self::json_success();
            }
        } catch (LogicException $e) {
            return self::json_fail($e->getMessage());
        }
    }

    public function passSms()
    {
        try {
            if ((new SmsEventModel($this->request->all()))->audit(SmsEventModel::PASS)) {
                return self::json_success();
            }
        } catch (LogicException $e) {
            return self::json_fail($e->getMessage());
        }
    }

    public function importIndex()
    {
        return view('admin.sms.import_sms');
    }
}
