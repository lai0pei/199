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

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use LogicException;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SmsEventModel extends CommonModel implements WithMapping, FromCollection, WithHeadings
{
    public const PASS = 1;
    public const REFUSE = 2;
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

        if (! empty($data['searchParams'])) {
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

        $item = self::where($where)->orderBy('id', 'desc')->paginate($limit, '*', 'page', $page);
   
        $result = [];

        foreach ($item->items() as $k => $v) {
            $result[$k]['id'] = $v['id'];
            $result[$k]['is_send'] = $this->sendName($v['is_send']);
            $result[$k]['user_name'] = $v['user_name'];
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
        $res['count'] = self::count();
        return $res;
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
        $res['value'] = array_values(unserialize($res['value']));

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

        if (! $status) {
            DB::rollBack();

            throw new LogicException('删除失败');
        }

        $log_data = ['type' => LogModel::DELETE_TYPE, 'title' => $title];

        (new LogModel($log_data))->createLog();

        DB::commit();

        return true;
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

        if (! $status) {
            DB::rollBack();

            throw new LogicException('审核失败');
        }

        $log_data = ['type' => LogModel::DELETE_TYPE, 'title' => $title];

        (new LogModel($log_data))->createLog();

        DB::commit();

        return true;
    }

    public function getNewMember()
    {
        return self::count();
    }

    public function getTodayMember()
    {
        return self::whereDate('created_at', Carbon::today())->count();
    }

    public function smsAppr()
    {
        return self::where('state', 0)->count();
    }

    public function collection()
    {
        return self::all();
    }

    /**
     * @var smsApply
     */
    public function map($apply): array
    {
        switch (true) {
            case $apply->state === 1:
                $apply->state = '通过';
                break;
            case $apply->state === 2:
                $apply->state = '拒绝';
                break;
            default:
                $apply->state = '未审核';
        }

        if ($apply->is_match === 1) {
            $apply->is_match = '匹配';
        } else {
            $apply->is_match = '不匹配';
        }

        return [
            $apply->id,
            $apply->username,
            $apply->game,
            $apply->apply_time,
            $apply->send_remark,
            $apply->ip,
            $apply->is_match,
            $apply->state,
        ];
    }

    public function headings(): array
    {
        return [
            '编号',
            '会员名称',
            '活动',
            '申请时间',
            '派送备注',
            'ip',
            '匹配',
            '状态',
        ];
    }

    private function matchName($id)
    {
        switch (true) {
            case $id === 1:
                $name = '匹配';
                break;
            case $id === 0:
                $name = '不匹配';
                break;
            default:
                $name = '无';
        }
        return $name;
    }

    private function sendName($id)
    {
        switch (true) {
            case $id === 1:
                $name = '已发';
                break;
            case $id === 0:
                $name = '未发';
                break;
            default:
                $name = '无';
        }
        return $name;
    }

    private function stateName($id)
    {
        switch (true) {
            case $id === 1:
                $name = '通过';
                break;
            case $id === 2:
                $name = '失败';
                break;
            default:
                $name = '未审核';
        }
        return $name;
    }
}
