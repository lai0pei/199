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

use App\Exceptions\LogicException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            $param = json_decode($data['searchParams'], true, 512, JSON_THROW_ON_ERROR);
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
        $res['count'] = self::where($where)->count();
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
        $res = [];

        $sms = self::find($data['id']);
        if ($sms !== null) {
            $res = $sms->toArray();
            $res['is_send'] = $this->sendName($res['is_send']);
            $res['is_match'] = $this->matchName($res['is_match']);
            $res['value'] = @unserialize($res['value']) ? unserialize($res['value']) : [];
        }

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

        if ((int) $data['state'] === 0 || (int) $data['state'] === 2) {
            $save['is_send'] = 0;
        } else {
            $save['is_send'] = 1;
        }

        return self::where('id', $data['id'])->update($save);
    }

    public function delete()
    {
        $data = $this->data;

        DB::beginTransaction();

        try {
            $ids = array_column($data['data'], 'id');
            $count = count($ids);
            if ($count === 0) {
                throw new LogicException('删除失败');
            }
            $status = self::whereIn('id', $ids)->delete();
            $title = '删除了' . $count . '行新人申请记录';
        } catch (LogicException $e) {
            DB::rollBack();
            throw new LogicException($e->getMessage());
        }

        if (!$status) {
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

            $audit = [
                'state' => $status,
                'updated_at' => now(),
            ];
            if ($status === self::PASS) {
                $pass = (new ConfigModel())->getConfig('bulkPass');
                $msg = $pass['pass'] ?? '';
                $tx = '通过';
                $audit['send_remark'] = $msg;
                $audit['is_send'] = 1;
            } elseif ($status === self::REFUSE) {
                $deny = (new ConfigModel())->getConfig('bulkDeny');
                $msg = $deny['refuse'] ?? '';
                $audit['send_remark'] = $msg;
                $tx = '拒绝';
                $audit['is_send'] = 0;
            } else {
                $msg = '';
                $audit['send_remark'] = $msg;
                $tx = '未审核';
                $audit['is_send'] = 0;
            }
            $count = count($ids);
            if ($count === 0) {
                throw new LogicException('审核失败');
            }

            $status = self::whereIn('id', $ids)->update($audit);
            $title = '审核' . $tx . '了    ' . $count . '行新人申请记录';
        } catch (LogicException $e) {
            DB::rollBack();
            throw new LogicException($e->getMessage());
        }

        if (!$status) {
            throw new LogicException('审核失败');
        }

        $log_data = ['type' => LogModel::SAVE_TYPE, 'title' => $title];

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
        $type = $this->data['id'];

        try {
            $where = match (true) {
                $type == 0 => [],
                $type == 1 => ['is_match'=>1],
                $type == 2 => ['is_match'=>0],
                $type == 3 => ['is_send'=>0],
                $type == 4 => ['is_send'=> 1],
                $type == 5 => ['state'=>0],
                $type == 6 => ['state'=>1],
                $type == 7 => ['state'=>2],
                default => [],
            };

            return self::where($where)->get();
        } catch (LogicException $e) {
            Log::channel('sms_export')->error($e->getMessage());
        }
    }

    /**
     * @var smsApply
     */
    public function map($apply): array
    {
        $apply->state = match (true) {
            $apply->state === 1 => '通过',
            $apply->state === 2 => '拒绝',
            default => '未审核',
        };

        $apply->is_match = $apply->is_match === 1 ? '匹配' : '不匹配';

        return [
            $apply->id,
            $apply->user_name,
            $apply->mobile,
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
            '会员账号',
            '手机号',
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
        return match (true) {
            $id === 1 => '匹配',
            $id === 0 => '不匹配',
            default => '无',
        };
    }

    private function sendName($id)
    {
        return match (true) {
            $id === 1 => '已发',
            $id === 0 => '未发',
            default => '无',
        };
    }

    private function stateName($id)
    {
        return match (true) {
            $id === 1 => '通过',
            $id === 2 => '失败',
            default => '未审核',
        };
    }
}
