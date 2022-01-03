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

class FormController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function form()
    {
        $id = $this->request->route()->parameters();
        return view('admin.event.form_event', ['id' => $id['id']]);
    }

    public function getFormList()
    {
        $data = (new FormModel($this->request->all()))->getFormList();

        $result['code'] = self::FAIL;
        $result['msg'] = '操作成功';
        $result['data'] = $data['data'];
        $result['count'] = $data['count'];

        return response()->json($result);
    }

    public function formDelete()
    {
        try {
            if ((new FormModel($this->request->all()))->formDelete()) {
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
        $event_id = $route['event_id'];
        return view('admin.event.add_form', ['form' => $data, 'type' => $formType, 'event_id' => $event_id]);
    }

    public function formAdd()
    {
        try {
            if ((new FormModel($this->request->all()))->formAdd()) {
                return self::json_success([], '操作成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }
}
