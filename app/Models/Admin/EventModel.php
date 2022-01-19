<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: EventModel.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Thursday, 23rd December 2021 1:05:13 pm
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Models\Admin;

use App\Exceptions\LogicException;
use Illuminate\Support\Facades\DB;

class EventModel extends CommonModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event';

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function userApply()
    {
        return $this->hasMany(UserApplyModel::class, 'event_id', 'id');
    }

    public function getEventBy()
    {
        $data = $this->data;

        if (empty($data['id'])) {
            return [];
        }

        $check = self::where('id', $data['id'])->first();

        if (empty($check)) {
            return [];
        }

        $event = $check->toArray();

        $event['status'] === 1 ? $event['status_check'] = 'checked' : 0;
        $event['display'] === 1 ? $event['display_check'] = 'checked' : 0;

        if ((int) $event['is_sms'] === 1) {
            $event['is_monthly'] === 1 ? $event['is_monthly_check'] = 'checked' : 0;
        } else {
            $event['is_daily'] === 1 ? $event['is_daily_check'] = 'checked' : 0;
        }

        $event['need_sms'] === 1 ? $event['need_sms_check'] = 'checked' : 0;
        $event['content'] = preg_replace('/[\t\n\r]/u', '', $event['content']);

        return $event;
    }

    public function maniEvent()
    {
        $input = $this->data;

        $data = $input['data'];

        DB::beginTransaction();

        $time = now();

        $mani = [
            'name' => $data['name'],
            'type_id' => $data['type_id'],
            'type_pic' => stripUrl($data['type_pic'] ?? ''),
            'sort' => $data['sort'] ?? 0,
            'status' => ($data['status'] ?? '') === 'on' ? 1 : 0,
            'display' => ($data['display'] ?? '') === 'on' ? 1 : 0,
            'start_time' => $data['start'],
            'end_time' => $data['end'],
            'description' => $data['description'] ?? '',
            'daily_limit' => $data['daily_limit'] ?? 0,
            'is_daily' => ($data['is_daily'] ?? '') === 'on' ? 1 : 0,
            'need_sms' => ($data['need_sms'] ?? '') === 'on' ? 1 : 0,
            'content' => stripUrl($data['content'] ?? ''),
            'external_url' => $data['external_url'] ?? '',
        ];

        if ((int) $data['id'] === -1) {
            if (self::where('name', $data['name'])->value('id') !== null) {
                throw new LogicException('相同活动名称, 已存在');
            }

            $mani['created_at'] = $time;
            $mani['updated_at'] = $time;

            $status = self::insert($mani);

            if (! $status) {
                DB::rollBack();
                throw new LogicException('添加失败');
            }

            $log_data = ['type' => LogModel::ADD_TYPE, 'title' => '添加了新活动 [' . $data['name'] . ']'];

            (new LogModel($log_data))->createLog();
        } else {
            $id = self::where('name', $data['name'])->value('id');

            if ($id !== null && $id !== (int) $data['id']) {
                throw new LogicException('相同活动名称, 已存在');
            }

            $mani['updated_at'] = $time;

            //短信活动 没有限制 每日
            if ((int) ($data['is_sms'] ?? 0) === 1) {
                $mani['is_monthly'] = ($data['is_monthly'] ?? '') === 'on' ? 1 : 0;
            } else {
                $mani['is_daily'] = ($data['is_daily'] ?? '') === 'on' ? 1 : 0;
                $mani['daily_limit'] = $data['daily_limit'] ?? 0;
            }

            $status = self::where('id', $data['id'])->update($mani);

            if (! $status) {
                DB::rollBack();

                throw new LogicException('保存失败');
            }

            $log_data = ['type' => LogModel::SAVE_TYPE, 'title' => '编辑了活动[' . $data['name'] . ']'];

            (new LogModel($log_data))->createLog();
        }
        DB::commit();
        return true;
    }

    public function getEventList()
    {
        $data = $this->data;

        $limit = $data['limit'] ?? 15;
        $page = $data['page'] ?? 1;

        $where = [];

        if (! empty($data['searchParams'])) {
            $param = json_decode($data['searchParams'], true);
            if ($param['name'] !== '') {
                $where['name'] = $where['name'] = $param['name'];
            }
            if ($param['type_id'] !== '') {
                $where['type_id'] = $param['type_id'];
            }
            if ($param['status'] !== '') {
                $where['status'] = $param['status'];
            }
            if ($param['display'] !== '') {
                $where['display'] = $param['display'];
            }
            if ($param['is_daily'] !== '') {
                $where['is_daily'] = $param['is_daily'];
            }
        }

        $item = self::where($where)->orderBy('id', 'desc')->paginate($limit, '*', 'page', $page);

        $result = [];
        foreach ($item->items() as $k => $v) {
            $result[$k]['id'] = $v['id'];
            $result[$k]['name'] = $v['name'];
            $result[$k]['type'] = $this->getEventName($v['type_id']);
            $result[$k]['sort'] = $v['sort'];
            $result[$k]['display'] = $v['display'] === 1 ? '显示' : '隐藏';
            $result[$k]['status'] = $v['status'] === 1 ? '开启' : '关闭';
            $result[$k]['is_daily'] = $v['is_daily'] === 1 ? '限制' : '不限制';
            if ((int) $v['is_sms'] === 1) {
                $result[$k]['is_daily'] = '无效';
            }
            $result[$k]['created_at'] = $this->toTime($v['created_at']);
        }
        $res['data'] = $result;
        $res['count'] = self::count();

        return $res;
    }

    public function getEvent()
    {
        return self::select('id', 'name')->get()->toArray();
    }

    public function getStatus()
    {
        return [
            '0' => '关闭',
            '1' => '开启',
        ];
    }

    public function getDisplay()
    {
        return [
            '0' => '隐藏',
            '1' => '显示',
        ];
    }

    public function getDaily()
    {
        return [
            '0' => '不限制',
            '1' => '限制',
        ];
    }

    public function deleteEvent()
    {
        $data = $this->data;

        DB::beginTransaction();

        $event = self::find($data['id']);

        if ($event === null) {
            throw new LogicException('删除失败');
        }

        if ($data['id'] === 1 || $event->is_sms === 1) {
            throw new LogicException('固定活动不能删除!');
        }

        $status = self::where('id', $data['id'])->delete();

        if (! $status) {
            DB::rollBack();

            throw new LogicException('删除失败');
        }

        $log_data = ['type' => LogModel::DELETE_TYPE, 'title' => '删除了活动[' . $event->name . ']'];

        (new LogModel($log_data))->createLog();

        DB::commit();

        return true;
    }

    private function getEventName($id)
    {
        return EventTypeModel::where('id', $id)->value('name');
    }
}
