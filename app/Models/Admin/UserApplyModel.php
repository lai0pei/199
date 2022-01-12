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
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserApplyModel extends CommonModel implements WithMapping, FromCollection, WithHeadings
{
    public const PASS = 1;
    public const REFUSE = 2;
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

        if (! empty($data['searchParams'])) {
            $param = json_decode($data['searchParams'], true);
            if ($param['event_id'] !== '') {
                $where['event_id'] = $param['event_id'];
            }
            if ($param['status'] !== '' && (int)$param['status'] !== -1) {
                $where['status'] = $param['status'];
            }
            if ($param['username'] !== '') {
                $where['username'] = $param['username'];
            }
            if ($param['ip'] !== '') {
                $where['ip'] = $param['ip'];
            }
        }

        $item = self::where($where)->orderBy('id', 'desc')->paginate($limit, '*', 'page', $page);

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
        $res['count'] = self::count();
        return $res;
    }

    public function getStatus()
    {
        return [
            '0' => '未审核',
            '1' => '通过',
            '2' => '失败',
        ];
    }

    public function toAudit()
    {
        $data = $this->data;

        $res = self::find($data['id'])->toArray();
        $res['value'] = unserialize($res['value']);
        return $res;
    }

    public function saveAudit()
    {
        $data = $this->data;

        $save = [
            'status' => $data['status'],
            'description' => $data['description'],
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
            $title = '删除了' . $count . '行活动申请记录';
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
            if ($status === self::PASS) {
                $pass = (new ConfigModel())->getConfig('bulkPass');
                $msg = $pass['pass'] ?? '';
                $tx = '通过';
            } else {
                $deny = (new ConfigModel())->getConfig('bulkDeny');
                $msg = $deny['refuse'] ?? '';
                $tx = '拒绝';
            }
     
            $audit = [
                'status' => $status,
                'updated_at' => now(),
                'description' => $msg,
            ];
            $status = self::whereIn('id', $ids)->update($audit);
            
            $title = '审核'.$tx.'了    '. $count . '行活动申请记录';
        } catch (LogicException $e) {
            DB::rollBack();
            throw new LogicException($e->getMessage());
        }

        if (! $status) {
            DB::rollBack();

            throw new LogicException('审核失败');
        }

        $log_data = ['type' => LogModel::SAVE_TYPE, 'title' => $title];

        (new LogModel($log_data))->createLog();

        DB::commit();

        return true;
    }

    public function userAppr()
    {
        return self::where('status', 0)->count();
    }

    public function getTotalNumber()
    {
        return self::count();
    }

    public function getTodayEvent()
    {
        return self::whereDate('created_at', Carbon::today())->count();
    }

    public function collection()
    {
        return self::all();
    }

    /**
     * @var UserApply
     */
    public function map($apply): array
    {
        switch (true) {
            case $apply->status === 1:
                $apply->status = '通过';
                break;
            case $apply->status === 2:
                $apply->status = '拒绝';
                break;
            default:
                $apply->status = '未审核';
        }

        return [
            $apply->id,
            $apply->username,
            $apply->apply_time,
            $apply->description,
            $apply->status,
            $apply->ip,

        ];
    }

    public function headings(): array
    {
        return [
            '编号',
            '会员账号',
            '申请时间',
            '内容',
            '状态',
            'ip',
        ];
    }

    private function getEventName($id)
    {
        return EventModel::where('id', $id)->value('name');
    }

    private function statusToText($status)
    {
        $name = '';
        switch (true) {
            case $status === 1:
                $name = '通过';
                break;
            case $status === 2:
                $name = '拒绝';
                break;
            default:
                $name = '未审核';
        }
        return $name;
    }
}
