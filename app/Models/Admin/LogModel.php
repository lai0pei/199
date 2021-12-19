<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: LogModel.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Saturday, 18th December 2021 1:08:48 pm
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class LogModel extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'title', 'content', 'is_delete', 'ip', 'admin_id'];

    const LOGIN_TYPE = 0;
    const ADD_TYPE = 1;
    const SAVE_TYPE = 2;
    const DELETE_TYPE = 3;

    /**
     * __construct
     *
     * @param  mixed $data
     * @return void
     */
    public function __construct($data = [])
    {
        $this->log = $data;
    }

    /**
     * 创造日志
     *
     * @return void
     */
    public function createLog()
    {
        $log = $this->log;
        $admin_id = session('user_id');
        $data = [
            'type' => $log['type'],
            'title' => $log['title'],
            'content' => '',
            'is_delete' => 0,
            'ip' => Request::ip(),
            'admin_id' => $admin_id,
            'created_at' => now(),
            'updated_at' => now(),
        ];

     
        return self::insert($data);
    }

}
