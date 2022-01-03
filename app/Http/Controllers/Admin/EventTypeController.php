<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Models\Admin\EventTypeModel;
use Illuminate\Http\Request;

class EventTypeController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function type()
    {
        return view('admin.event_type.type');
    }

    public function maniType()
    {
        try {
            if ((new EventTypeModel($this->request->all()))->maniType()) {
                return self::json_success([], '操作成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function addType()
    {
        $type = (new EventTypeModel($this->request->route()->parameters()))->getType();
        return view('admin.event_type.add', ['type' => $type]);
    }

    public function typeList()
    {
        $data = (new EventTypeModel($this->request->all()))->listType();
        $result['code'] = self::FAIL;
        $result['msg'] = '操作成功';
        $result['data'] = $data['data'];
        $result['count'] = $data['count'];

        return response()->json($result);
    }

    public function typeDelete()
    {
        try {
            if ((new EventTypeModel($this->request->all()))->typeDelete()) {
                return self::json_success([], '操作成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function getAllType()
    {
        return self::json_success((new EventTypeModel())->getAllType());
    }
}
