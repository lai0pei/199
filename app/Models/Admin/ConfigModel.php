<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: ConfigModel.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Monday, 27th December 2021 10:45:33 am
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Models\Admin;

use App\Exceptions\LogicException;

class ConfigModel extends CommonModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'configs';

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function __destruct()
    {
        unset($this->data);
    }

    public function saveConfig($name, $title)
    {
        $data = $this->data;
        try {
            $smsConfig = json_decode($data['data'], true);

            $update = [
                'json_data' => serialize($smsConfig),
                'updated_at' => now(),
            ];

            $status = self::where('name', $name)->update($update);

            if (! $status) {
                throw new LogicException('保存失败');
            }

            $log_data = ['type' => LogModel::SAVE_TYPE, 'title' => $title];

            (new LogModel($log_data))->createLog();

            return true;
        } catch (LogicException $e) {
            throw new LogicException('保存失败');
        }
    }

    public function getConfig($name)
    {
        return unserialize(self::where('name', $name)->value('json_data'));
    }
}
