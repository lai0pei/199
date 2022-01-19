<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: FormController.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Friday, 24th December 2021 3:16:28 pm
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Http\Controllers\Admin;

use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Models\Admin\FormModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function form()
    {
        $id = $this->request->route()->parameters();
        return view('admin.event.form_event', ['id' => $id['id'] ?? -1]);
    }

    public function getFormList()
    {
        $input = $this->request->all();

        try {
            $data = (new FormModel($input))->getFormList();
            $result['code'] = self::FAIL;
            $result['msg'] = '操作成功';
            $result['data'] = $data['data'];
            $result['count'] = $data['count'];

            return response()->json($result);
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function formDelete()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'id' => 'required|numeric|min:-1',
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            if ((new FormModel($input))->formDelete()) {
                return self::json_success([], '操作成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function formDetail()
    {
        $route = $this->request->route()->parameters();
        $formModel = new FormModel($route);
        $data = $formModel->getFormById();
        $formType = $formModel->getFormType();
        $event_id = $route['event_id'] ?? -1;
        return view('admin.event.add_form', ['form' => $data, 'type' => $formType, 'event_id' => $event_id]);
    }

    public function formAdd()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'id' => 'required|numeric|min:-1',
            'type' => 'required|min:0|max:5',
            'event_id' => 'required|min:1',
            'name' => 'required',
            'sort' => 'required|numeric|min:0',
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            if ((new FormModel($input))->formAdd()) {
                return self::json_success([], '操作成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }
}
