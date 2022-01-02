<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: EventTypeModel.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Thursday, 30th December 2021 8:31:37 am
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Models\Index;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Database\Eloquent\Model;

class EventTypeModel extends Model
{

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'type';

    /**
     * event
     *
     * @return void
     */
    public function eventList()
    {
        return $this->hasMany(EventModel::class, 'type_id', 'id');
    }

    public function getAllEventList()
    {
        $eventModel = new EventModel();
        $type = self::select("id as type_id", 'name')->where('status', 1)->get()->toArray();
       
        foreach ($type as &$type_id) {
            $where = [];
            $where['type_id'] = $type_id['type_id'];
            $where['status'] = 1;
            $where['display'] = 1;
            $type_id['event'] = $eventModel::select('id', 'name', 'type_pic', 'type_id', 'external_url','need_sms','is_sms')->where($where)->whereNotNull('type_pic')->orderBy('sort','asc')->get()->toArray();
        }

        unset($type_id);
        return $type;

    }
}
