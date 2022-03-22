<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: FormModel.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Friday, 31st December 2021 8:16:24 am
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Models\Index;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class FormModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'form';
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function getFormById()
    {
        $data = $this->data;

        $eventId = $data['event_id'];

        $eventModel = new EventModel();

        $eventTypeModel = new EventTypeModel();

        $column = ['id', 'name', 'type', 'option'];

        $rawForm = self::where('event_id', $eventId)->select($column)->orderBy('sort', 'asc')->get()->toArray();

        foreach ($rawForm as &$value) {
            $value['option'] = explode(',', $value['option']);
        }
        $res = [];
        $eventData = $eventModel::where('id', $eventId)->select('is_sms', 'need_sms', 'description')->first();
        $res['form'] = $rawForm;
        $res['type'] = $eventTypeModel->where('status', 1)->select('id', 'name')->get()->toArray();
        $res['is_sms'] = $eventData->is_sms;
        $res['need_sms'] = $eventData->need_sms;
        $res['description'] = $eventData->description ?? '';
        return $res;
    }
}
