<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: SmsEventModel.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Saturday, 25th December 2021 3:30:21 pm
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Models\Admin;

use App\Models\Admin\CommonModel;
use Illuminate\Support\Facades\DB;
use LogicException;

class SmsEventModel extends CommonModel
{

    const PASS = 1;
    const REFUSE = 2;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sms_apply';

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function smsList()
    {
        $data = $this->data;
        $limit = $data['limit'] ?? 15;
        $page = $data['page'] ?? 1;

        $where = [];

        if (!empty($data['searchParams'])) {
            $param = json_decode($data['searchParams'], true);
            if ($param['is_match'] !== '') {
                $where['is_match'] = $param['is_match'];
            }
            if ($param['state'] !== '') {
                $where['state'] = $param['state'];
            }
            if ($param['is_send'] !== '') {
                $where['is_send'] = $param['is_send'];
            }
            if ($param['user_name'] !== '') {
                $where['user_name'] = $param['user_name'];
            }
            if ($param['ip'] !== '') {
                $where['ip'] = $param['ip'];
            }
        }

        $item = self::where($where)->paginate($limit, "*", "page", $page);

        $result = [];

        foreach ($item->items() as $k => $v) {
            $result[$k]['id'] = $v['id'];
            $result[$k]['is_send'] = $this->sendName($v['is_send']);
            $result[$k]['user_name'] = $v['user_name'];
            $result[$k]['money'] = $v['money'];
            $result[$k]['game'] = $v['game'];
            $result[$k]['ip'] = $v['ip'];
            $result[$k]['mobile'] = $v['mobile'];
            $result[$k]['apply_time'] = $v['apply_time'];
            $result[$k]['send_time'] = $v['send_time'];
            $result[$k]['state'] = $this->stateName($v['state']);
            $result[$k]['is_match'] = $this->matchName($v['is_match']);
            $result[$k]['message'] = $v['message'];
            $result[$k]['created_at'] = $this->toTime($v['created_at']);
            $result[$k]['updated_at'] = $this->toTime($v['updated_at']);
        }

        $res['data'] = $result;
        $res['count'] = $item->count();
        return $res;
    }

    private function matchName($id)
    {

        switch (true) {
            case 1 == $id:$name = '匹配';
                break;
            case 0 == $id:$name = '不匹配';
                break;
            default:$name = '无';
        }
        return $name;
    }

    private function sendName($id)
    {

        switch (true) {
            case 1 == $id:$name = '已发';
                break;
            case 0 == $id:$name = '未发';
                break;
            default:$name = '无';
        }
        return $name;
    }

    private function stateName($id)
    {

        switch (true) {
            case 1 == $id:$name = '通过';
                break;
            case 2 == $id:$name = '失败';
                break;
            default:$name = '未审核';
        }
        return $name;
    }

    public function getType()
    {
        return [
            'state' => [
                '0' => '未审核',
                '1' => '通过',
                '2' => '失败',
            ],
            'is_match' => [
                '0' => '不匹配',
                '1' => '匹配',
            ],
            'is_send' => [
                '0' => '未发',
                '1' => '已发',
            ],
        ];
    }

    public function smsAudit()
    {
        $data = $this->data;

        $res = self::find($data['id'])->toArray();
        $res['is_send'] = $this->sendName($res['is_send']);
        $res['is_match'] = $this->matchName($res['is_match']);
        return $res;
    }

    public function saveSms()
    {

        $data = $this->data;

        $save = [
            'state' => $data['state'],
            'send_remark' => $data['send_remark'],
            'updated_at' => now(),
        ];

        return self::where('id', $data['id'])->update($save);

    }

    public function delete()
    {

        $data = $this->data;

        DB::beginTransaction();

        try {
            $ids = array_column($data['data'], 'id');
            $count = count($ids);
            $status = self::whereIn('id', $ids)->delete();
            $title = '删除了' . $count . '行用户短信活动申请记录';

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

    public function audit($status)
    {

        $data = $this->data;

        DB::beginTransaction();

        try {
            $ids = array_column($data['data'], 'id');
            $count = count($ids);
            $audit = [
                'state' => $status,
                'updated_at' => now(),
            ];
            $status = self::whereIn('id', $ids)->update($audit);
            $title = '审核了    ' . $count . '行用户短信活动申请记录';

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
