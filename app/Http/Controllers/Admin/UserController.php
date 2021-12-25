<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\EventModel;
use App\Models\Admin\UserApplyModel;
use Illuminate\Http\Request;
use LogicException;

class UserController extends Controller
{
    //
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
        $data = (new UserApplyModel($this->request->route()->parameters()))->toAudit();
        return view('admin.user_apply.audit', ['data' => $data]);
    }

    public function saveAudit()
    {

        return self::json_success((new UserApplyModel($this->request->all()))->saveAudit());
    }

    public function delete()
    {
        try {
            if ((new UserApplyModel($this->request->all()))->delete()) {
                return self::json_success();
            }
        } catch (LogicException $e) {
            return self::json_fail($e->getMessage());
        }

    }

    public function refuse()
    {
        try {
            if ((new UserApplyModel($this->request->all()))->audit(UserApplyModel::REFUSE)) {
                return self::json_success();
            }
        } catch (LogicException $e) {
            return self::json_fail($e->getMessage());
        }

    }

    public function pass()
    {
        try {
            if ((new UserApplyModel($this->request->all()))->audit(UserApplyModel::PASS)) {
                return self::json_success();
            }
        } catch (LogicException $e) {
            return self::json_fail($e->getMessage());
        }

    }
}
