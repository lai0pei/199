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

        $column = ['id','name','type','option'];

        $rawForm = self::where('event_id', $eventId)->select($column)->orderBy('sort', 'desc')->get()->toArray();

        foreach ($rawForm as &$value) {
            $value['option'] = explode(',', $value['option']);
        }

        return $rawForm;
    }
}
