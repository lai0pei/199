<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: ApplyModel.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Thursday, 30th December 2021 1:43:23 pm
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Models\Index;

use App\Exceptions\LogicException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ApplyModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_apply';
    public function __construct($data = [])
    {
        $this->data = $data;
        $this->formModel = new FormModel();
    }

    public function __destruct()
    {
        unset($this->data);
    }

    /**
     * getApplyList
     *
     * @return void
     */
    public function getApplyList()
    {
        $where = [];
        $where['status'] = 1;
        $where['is_delete'] = 0;
        $column = ['id', 'username', 'event_id'];
        $applyList = self::where($where)->select($column)->limit(20)->orderby('id', 'desc')->get()->toArray();

        $eventModel = new EventModel();
        foreach ($applyList as &$v) {
            $v['username'] = substr($v['username'], 0, 3) . '****';
            $v['event'] = $eventModel::where('id', $v['event_id'])->value('name');
        }
        unset($v);
        return $applyList;
    }

    /**
     * applyForm
     */
    public function applyForm()
    {
        $data = $this->data;
        $eventId = $data['eventId'];
        $username = $data['username'];
        $pic_url = $data['imageUrl'] ?? '';

        $form = [];

        $eventModel = new EventModel();
        $isExist = $eventModel::where('id', $eventId)->value('id');
        if($isExist === null){
            throw new LogicException('活动不存在');
        }
        
        $limit = $eventModel::where('id', $eventId)->value('daily_limit');
        $is_daily = $eventModel::where('id', $eventId)->value('is_daily');
        $is_sms = $eventModel::where('id', $eventId)->value('is_sms');

        if ($is_sms === 1) {
            throw new LogicException('申请有误');
        }

        $startOfDay = Carbon::now()->startOfDay();
        $endOfDay = Carbon::now()->endOfDay();
        $count = self::where('username', $username)->whereBetween('apply_time', [$startOfDay, $endOfDay])->where('event_id', $eventId)->count();

        if ((int) $is_daily === 1 && (((int) $limit <= (int) $count) || (int) $limit === 0)) {
            throw new LogicException('今日申请次数，已超过' . $limit . '次');
        }

        try {
            DB::beginTransaction();

            $form = $this->removeNull($data['form'] ?? '');

            if ($pic_url !== '') {
                foreach ($pic_url as &$v) {
                    $v['name'] = $this->formModel::where('id', $v['id'])->value('name');
                    $v['type'] = 'photo';
                    unset($v['id']);
                }
                unset($v);
                $form = array_merge($form, $pic_url);
            }

            $insert = [
                'event_id' => $eventId,
                'username' => $username,
                'value' => serialize($form),
                'apply_time' => now(),
                'status' => 0,
                'is_delete' => 0,
                'ip' => request()->ip(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $status = self::insert($insert);
            if (! $status) {
                throw new LogicException('申请失败');
            }
        } catch (LogicException $e) {
            throw new LogicException($e->getMessage());
        }
        if (! $status) {
            DB::rollBack();
            throw new LogicException('申请失败，请联系客服');
        }

        DB::commit();

        return true;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function removeNull($form)
    {
        $data = [];

        if (empty($form) || ! is_array($form)) {
            return [];
        }
        $i = 0;
        foreach ($form as &$subForm) {
            foreach ($subForm as $k => $v) {
                if (! empty($v)) {
                    $data[$i]['name'] = $this->formModel::where('id', $k)->value('name');
                    $data[$i]['value'] = $v;
                }

                $i++;
            }
        }
        return array_values($data);
    }

    public function checkForm()
    {
        $data = $this->data;
        $eventId = $data['eventId'];
        $username = $data['username'];

        $event = new EventModel();
        $is_sms = $event::where('id', $eventId)->value('is_sms');

        if ($is_sms === 1) {
            $column = ['user_name', 'apply_time', 'state', 'send_remark'];
            $smsModel = new SmsApplyModel();
            $res = $smsModel::where('event_id', $eventId)->where('user_name', $username)->select($column)->take(5)->orderBy('id','desc')->get()->toArray();
            foreach ($res as &$v) {
                $v['username'] = $v['user_name'];
                switch (true) {
                    case $v['state'] === 1:
                        $v['status'] = '通过';
                        break;
                    case $v['state'] === 2:
                        $v['status'] = '拒绝';
                        break;
                    default:
                        $v['status'] = '未审核';
                }
                $v['description'] = empty($v['send_remark']) ? '暂无回复' : $v['send_remark'];
                $v['apply_time'] = Carbon::parse($v['apply_time'])->format('Y年-m月-d日 | H时:i分:s秒');
            }
        } else {
            $column = ['username', 'apply_time', 'status', 'description'];
            $res = self::where('event_id', $eventId)->where('username', $username)->take(10)->orderBy('id','desc')->select($column)->get()->toArray();
            foreach ($res as &$v) {
                switch (true) {
                    case $v['status'] === 1:
                        $v['status'] = '通过';
                        break;
                    case $v['status'] === 2:
                        $v['status'] = '拒绝';
                        break;
                    default:
                        $v['status'] = '未审核';
                }
                $v['description'] = empty($v['description']) ? '暂无回复' : $v['description'];
                $v['apply_time'] = Carbon::parse($v['apply_time'])->format('Y年-m月-d日 | H时:i分:s秒');
            }
        }

        unset($v);
        return $res;
    }
}
