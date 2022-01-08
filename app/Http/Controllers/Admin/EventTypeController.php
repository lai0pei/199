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
        try {
            if ((new EventTypeModel($this->request->all()))->maniType()) {
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
        $type = (new EventTypeModel($this->request->route()->parameters()))->getType();
        return view('admin.event_type.add', ['type' => $type]);
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
        try {
            if ((new EventTypeModel($this->request->all()))->typeDelete()) {
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
