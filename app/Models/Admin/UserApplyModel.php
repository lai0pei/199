<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: UserApplyModel.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Saturday, 25th December 2021 12:12:55 pm
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Models\Admin;

use App\Exceptions\LogicException;
use App\Models\Admin\CommonModel;
use Illuminate\Support\Facades\DB;

class UserApplyModel extends CommonModel
{   

    const PASS = 1;
    const REFUSE = 2;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_apply';

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function userList()
    {
        $data = $this->data;
        $limit = $data['limit'] ?? 15;
        $page = $data['page'] ?? 1;

        $where = [];

        if (!empty($data['searchParams'])) {
            $param = json_decode($data['searchParams'], true);
            if ($param['event_id'] !== '') {
                $where['event_id'] = $param['event_id'];
            }
            if ($param['status'] !== '') {
                $where['status'] = $param['status'];
            }
            if ($param['username'] !== '') {
                $where['username'] = $param['username'];
            }
            if ($param['ip'] !== '') {
                $where['ip'] = $param['ip'];
            }
        }

        $item = self::where($where)->paginate($limit, "*", "page", $page);

        $result = [];

        foreach ($item->items() as $k => $v) {
            $result[$k]['id'] = $v['id'];
            $result[$k]['event'] = $this->getEventName($v['event_id']);
            $result[$k]['apply_time'] = $v['apply_time'];
            $result[$k]['username'] = $v['username'];
            $result[$k]['status_text'] = $this->statusToText($v['status']);
            $result[$k]['ip'] = $v['ip'];
            $result[$k]['description'] = $v['description'];
            $result[$k]['created_at'] = $this->toTime($v['created_at']);
            $result[$k]['updated_at'] = $this->toTime($v['updated_at']);
        }

        $res['data'] = $result;
        $res['count'] = $item->count();
        return $res;
    }

    private function getEventName($id)
    {
        return EventTypeModel::where('id', $id)->value('name');
    }

    private function statusToText($status)
    {
        $name = '';
        switch (true) {
            case $status == 1:$name = '通过';
                break;
            case $status == 2:$name = '拒绝';
                break;
            default:$name = "未审核";
        }
        return $name;
    }

    public function getStatus()
    {
        return [
            "0" => '未审核',
            "1" => '通过',
            "2" => '失败',
        ];
    }

    public function toAudit()
    {
        $data = $this->data;

        return self::find($data['id'])->toArray();
    }

    public function saveAudit()
    {

        $data = $this->data;
        
        $save = [
            'status' => $data['status'],
            'description' => $data['description'],
            'updated_at' => now(),
        ];

        return self::where('id',$data['id'])->update($save);

    }

    public function delete(){

        $data = $this->data;

        DB::beginTransaction();

        try {
            $ids = array_column($data['data'], 'id');
            $count = count($ids);
            $status = self::whereIn('id', $ids)->delete();
            $title = '删除了' . $count . '行用户申请记录';

        } catch (LogicException $e) {
            DB::rollBack();
            throw new LogicException($e->getMessage());
        }

        if (false === $status) {

            DB::rollBack();

            throw new LogicException('删除失败');

        } else {

            $log_data = ['type' => LogModel::DELETE_TYPE, 'title' => $title];

            (new LogModel($log_data))->createLog();

            DB::commit();

            return true;
        }
    }

    public function audit($status){

        $data = $this->data;

        DB::beginTransaction();

        try {
            $ids = array_column($data['data'], 'id');
            $count = count($ids);
            $audit = [
                'status' => $status,
                'updated_at' => now(),
            ];
            $status = self::whereIn('id', $ids)->update($audit);
            $title = '审核了    ' . $count . '行用户申请记录';

        } catch (LogicException $e) {
            DB::rollBack();
            throw new LogicException($e->getMessage());
        }

        if (false === $status) {

            DB::rollBack();

            throw new LogicException('审核失败');

        } else {

            $log_data = ['type' => LogModel::DELETE_TYPE, 'title' => $title];

            (new LogModel($log_data))->createLog();

            DB::commit();

            return true;
        }
    }
}
