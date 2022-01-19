<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: EventTypeController.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Tuesday, 4th January 2022 8:04:00 am
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2022 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Http\Controllers\Admin;

use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Models\Admin\EventTypeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EventTypeController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * 活动类型 列表页
     *
     * @return void
     */
    public function type()
    {
        return view('admin.event_type.type');
    }

    /**
     * 活动类型 添加 编辑
     *
     * @return void
     */
    public function maniType()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'id' => 'required|numeric|min:-1',
            'name' => 'required',
            'status' => ['required', Rule::in(0, 1)],
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            if ((new EventTypeModel($input))->maniType()) {
                return self::json_success([], '操作成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    /**
     * 活动类型 添加 操作页
     *
     * @return void
     */
    public function addType()
    {
        $input = $this->request->route()->parameters();
        $validator = Validator::make($input, [
            'id' => 'numeric|min:0',
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            $type = (new EventTypeModel($input))->getType();
            return view('admin.event_type.add', ['type' => $type]);
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    /**
     * 活动类型 列表页 数据
     *
     * @return void
     */
    public function typeList()
    {
        $data = (new EventTypeModel($this->request->all()))->listType();
        $result['code'] = self::FAIL;
        $result['msg'] = '操作成功';
        $result['data'] = $data['data'];
        $result['count'] = $data['count'];

        return response()->json($result);
    }

    /**
     * 活动类型 删除
     *
     * @return void
     */
    public function typeDelete()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'id' => 'required|min:1|numeric',
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            if ((new EventTypeModel($input))->typeDelete()) {
                return self::json_success([], '操作成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    /**
     * 活动类型 获取所有类型
     *
     * @return void
     */
    public function getAllType()
    {
        return self::json_success((new EventTypeModel())->getAllType());
    }
}
