<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: EventController.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Sunday, 19th December 2021 6:21:56 pm
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Http\Controllers\Admin;

use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Models\Admin\EventModel;
use App\Models\Admin\EventTypeModel;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * 活动添加页面
     */
    public function event()
    {
        $model = new EventModel($this->request->route()->parameters());
        $data = $model->getEventBy();
        $types = (new EventTypeModel())->getAllType();
        return view('admin.event.add_event', ['type' => $data, 'event' => $types]);
    }

    /**
     * 活动操作
     */
    public function maniEvent()
    {   
        try{
            $data = (new EventModel($this->request->all()))->maniEvent();
            return self::json_success($data);
        }catch (LogicException $e){
            return self::json_fail([],$e->getMessage());
        }
  
    }

    /**
     * 活动列表 页面
     */
    public function list()
    {
        $model = new EventModel($this->request->all());
        $types = (new EventTypeModel())->getAllType();
        $status = $model->getStatus();
        $display = $model->getDisplay();
        $is_daily = $model->getDaily();
        return view('admin.event.event_list', ['data' => $types, 'status' => $status, 'display' => $display, 'daily' => $is_daily]);
    }

    /**
     * 活动列表 数据
     */
    public function getEventList()
    {
        $data = (new EventModel($this->request->all()))->getEventList();

        $result['code'] = self::FAIL;
        $result['msg'] = '操作成功';
        $result['data'] = $data['data'];
        $result['count'] = $data['count'];

        return response()->json($result);
    }

    /**
     * 活动删除
     */
    public function deleteEvent()
    {
        try {
            if ((new EventModel($this->request->all()))->deleteEvent()) {
                return self::json_success([], '操作成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }
}
