<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Models\Admin\SmsEventModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SmsController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function sms()
    {
        $data = (new SmsEventModel($this->request->all()))->getType();
        return view('admin.sms.sms_apply', ['is_match' => $data['is_match'], 'state' => $data['state'], 'is_send' => $data['is_send']]);
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
        $input = $this->request->route()->parameters();
        $validator = Validator::make($input, [
            'id' => 'required|numeric|min:1',
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            $data = (new SmsEventModel($input))->smsAudit();
            return view('admin.sms.audit_sms', ['data' => $data]);
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function saveSms()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'id' => 'required|numeric|min:1',
            'state' => ['required', Rule::in(0, 1, 2)],
            'send_remark' => 'required',
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            (new SmsEventModel($input))->saveSms();

            return self::json_success();
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function deleteSms()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'data' => 'required',
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            if ((new SmsEventModel($input))->delete()) {
                return self::json_success();
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function refuseSms()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'data' => 'required',
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            if ((new SmsEventModel($input))->audit(SmsEventModel::REFUSE)) {
                return self::json_success();
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function passSms()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'data' => 'required',
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            if ((new SmsEventModel($input))->audit(SmsEventModel::PASS)) {
                return self::json_success();
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function importIndex()
    {
        return view('admin.sms.import_sms');
    }
}
