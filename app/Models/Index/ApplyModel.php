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

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use LogicException;

class ApplyModel extends Model
{
    public function __construct($data = [])
    {
        $this->data = $data;
        $this->formModel = new FormModel();
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_apply';

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
        $applyList = self::where($where)->select($column)->limit(20)->get()->toArray();

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
     *
     * @return void
     */
    public function applyForm()
    {
        $data = $this->data;
        $eventId = $data['eventId'];
        $username = $data['username'];
        $pic_url = $data['imageUrl'];
        $form = [];

        $eventModel = new EventModel();

        $event = $eventModel::find($eventId)->toArray();

        $count = self::where('username', $username)->where('event_id', $eventId)->count();

        if (1 == $event['is_daily'] && $event['daily_limit'] == $count) {
            throw new LogicException("今日申请次数，已超过" . $count . '次');

        }

        $form = $this->removeNull($data['form']);

        if (!empty($pic_url)) {
            foreach ($pic_url as &$v) {
                $v['name'] = $this->formModel::where('id', $v['id'])->value('name');
                $v['type'] = "photo";
                unset($v['id']);
            }
            unset($v);
            $form = array_merge($form, $pic_url);
        }

        try {

            DB::beginTransaction();

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
        } catch (LogicException $e) {
            throw new LogicException("申请失败");
        }
        if (!$status) {
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

        $i = 0;
        foreach ($form as &$subForm) {
            foreach ($subForm as $k => $v) {
                if (!empty($v)) {
                    $data[$i]['name'] = $this->formModel::where('id', $k)->value('name');
                    $data[$i]['value'] = $v;
                }

                $i++;
            }
        }
        return array_values($data);
    }

}
