<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Models\Admin\EventModel;
use App\Models\Admin\UserApplyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function user()
    {
        $applyModel = new UserApplyModel($this->request->all());
        $status = $applyModel->getStatus();
        $eventList = (new EventModel())->getEvent();
        return view('admin.user_apply.apply', ['status' => $status, 'eventList' => $eventList]);
    }

    public function userList()
    {
        $data = (new UserApplyModel($this->request->all()))->userList();
        $result['code'] = self::FAIL;
        $result['msg'] = '操作成功';
        $result['data'] = $data['data'];
        $result['count'] = $data['count'];

        return response()->json($result);
    }

    public function userAuditIndex()
    {
        $input = $this->request->route()->parameters();
        $validator = Validator::make($input, [
            'id' => 'required|numeric|min:1',
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            $data = (new UserApplyModel($input))->toAudit();
            return view('admin.user_apply.audit', ['data' => $data]);
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function saveAudit()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'id' => 'required|numeric|min:1',
            'status' => ['required', Rule::in(0, 1, 2)],
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            (new UserApplyModel($input))->saveAudit();
            return self::json_success();
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function delete()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'data' => 'required',
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            if ((new UserApplyModel($input))->delete()) {
                return self::json_success();
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function refuse()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'data' => 'required',
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            (new UserApplyModel($input))->audit(UserApplyModel::REFUSE);
            return self::json_success();
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function pass()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'data' => 'required',
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            (new UserApplyModel($this->request->all()))->audit(UserApplyModel::PASS);
            return self::json_success();
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }
}
