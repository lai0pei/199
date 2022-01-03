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
 * | 创建时间: Thursday, 30th December 2021 8:31:34 am
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2022 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Models\Index;

use Illuminate\Database\Eloquent\Model;

class EventModel extends Model
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
    protected $table = 'event';

    /**
     * event
     *
     * @return void
     */
    public function event()
    {
        return $this->belongsTo(EventTypeModel::class);
    }

    /**
     * getAllEvent
     *
     * @return void
     */
    public function getAllEvent()
    {
        return self::select('id', 'name')->get()->toArray();
    }

    public function getContent()
    {
        $data = $this->data;
        $res['content'] =  self::find($data['event_id'])->value("content");
        $res['name'] =  self::find($data['event_id'])->value("name");
        return $res;
    }

}
