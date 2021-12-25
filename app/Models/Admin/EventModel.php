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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EventModel extends Model
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

    public function getEventBy()
    {

        $data = $this->data;

        if (empty($data['id'])) {
            return [];
        }
        $event = self::find($data['id'])->toArray();

        ($event['status'] == 1) ? $event['status_check'] = "checked" : 0;
        ($event['display'] == 1) ? $event['display_check'] = "checked" : 0;
        ($event['is_daily'] == 1) ? $event['is_daily_check'] = "checked" : 0;

        return $event;
    }

    public function maniEvent()
    {

        $data = $this->data;

        DB::beginTransaction();

        if (-1 == $data['id']) {
            $add = [
                'name' => $data['name'],
                'type_id' => $data['type_id'],
                'type_pic' => $data['type_pic'],
                'sort' => $data['sort'],
                'status' => ($data['status'] == 'on') ? 1 : 0,
                'display' => ($data['display'] == 'on') ? 1 : 0,
                'start_time' => $data['start'],
                'end_time' => $data['end'],
                'daily_limit' => $data['sort'],
                'is_daily' => ($data['is_daily'] == 'on') ? 1 : 0,
                'content' => $data['content'],
                'external_url' => $data['external_url'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $status = self::insert($add);

            if (false === $status) {

                DB::rollBack();

                throw new LogicException('添加失败');

            } else {

                $log_data = ['type' => LogModel::ADD_TYPE, 'title' => '添加了新活动 [' . $data['name'] . ']'];

                (new LogModel($log_data))->createLog();

                DB::commit();

                return true;
            }

        } else {
            $save = [
                'name' => $data['name'],
                'type_id' => $data['type_id'],
                'type_pic' => $data['type_pic'],
                'sort' => $data['sort'],
                'status' => ($data['status'] == 'on') ? 1 : 0,
                'display' => ($data['display'] == 'on') ? 1 : 0,
                'start_time' => $data['start'],
                'end_time' => $data['end'],
                'daily_limit' => $data['sort'],
                'is_daily' => ($data['is_daily'] == 'on') ? 1 : 0,
                'content' => $data['content'],
                'external_url' => $data['external_url'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $status = self::where('id', $data['id'])->update($save);

            if (false === $status) {

                DB::rollBack();

                throw new LogicException('添加失败');

            } else {

                $log_data = ['type' => LogModel::SAVE_TYPE, 'title' => '编辑了活动[' . $data['name'] . ']'];

                (new LogModel($log_data))->createLog();

                DB::commit();

                return true;
            }
        }
    }

    public function getEventList()
    {

        $data = $this->data;

        $limit = $data['limit'] ?? 15;
        $page = $data['page'] ?? 1;

        $where = [];

        if (!empty($data['searchParams'])) {
            $param = json_decode($data['searchParams'], true);
            if($param['name'] !== ''){
                $where['name'] = $where['name'] = $param['name'];
            }
            if($param['type_id'] !== ''){
                $where['type_id'] = $param['type_id'];
            }
            if($param['status'] !== ''){
                $where['status'] = $param['status'];
            }
            if($param['display'] !== ''){
                $where['display'] = $param['display'];
            }
            if($param['is_daily'] !== ''){
                $where['is_daily'] = $param['is_daily'];
            }
        }

        $item = self::where($where)->paginate($limit, "*", "page", $page);

        $result = [];
        foreach ($item->items() as $k => $v) {
            $result[$k]['id'] = $v['id'];
            $result[$k]['name'] = $v['name'];
            $result[$k]['type'] = $this->getEventName($v['type_id']);
            $result[$k]['sort'] = $v['sort'];
            $result[$k]['display'] = ($v['display'] == 1) ? '显示' : '隐藏';
            $result[$k]['status'] = ($v['status'] == 1) ? '开启' : '关闭';
            $result[$k]['is_daily'] = ($v['is_daily'] == 1) ? '限制' : '不限制';
            $result[$k]['created_at'] = $v['created_at'];

        }
        $res['data'] = $result;
        $res['count'] = $item->count();

        return $res;
    }

    private function getEventName($id)
    {
        return EventTypeModel::where('id', $id)->value('name');
    }

    public function getEvent()
    {
        return self::select('id','name')->get()->toArray();
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

        $name = self::find($data['id'])->value('name');

        $status = self::where('id', $data['id'])->delete();

        if (false === $status) {

            DB::rollBack();

            throw new LogicException('删除失败');

        } else {

            $log_data = ['type' => LogModel::DELETE_TYPE, 'title' => '删除了活动[' . $name . ']'];

            (new LogModel($log_data))->createLog();

            DB::commit();

            return true;
        }
    }
}
