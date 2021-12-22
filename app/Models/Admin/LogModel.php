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
            'ip' => request()->ip(),
            'admin_id' => $admin_id,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        return self::insert($data);
    }

    public function logType()
    {
        return [
            self::LOGIN_TYPE => '登录',
            self::ADD_TYPE => '添加',
            self::SAVE_TYPE => '编辑',
            self::DELETE_TYPE => '删除',
        ];
    }

    public function log()
    {

        $data = $this->log;

        $limit = $data['limit'] ?? 15;
        $page = $data['page'] ?? 1;

        $where = [];
       
        if (!empty($data['searchParams'])) {
            $param = json_decode($data['searchParams'], true);
            switch (true) {
                case (!empty($param['user'])):
                    $where['admin_id'] = AdminModel::where('account', $param['user'])->value('id');
                    break;
                case (!empty($param['type'])): $where['type'] = $param['type'];
                    break;
                case (!empty($param['ip'])): $where['ip'] = $param['ip'];
                    break;
                case (!empty($param['start'])): $where['created_at'] = $param['start'];
                    break;
                default : $where = [];
            }
        }
     
        $item = self::where($where)->paginate($limit, "*", "page", $page);

        $result = [];
        foreach ($item->items() as $k => $v) {
            $result[$k]['id'] = $v['id'];
            $result[$k]['type'] = $this->typeToName($v['type']);
            $result[$k]['title'] = $v['title'];
            $result[$k]['ip'] = $v['ip'];
            $result[$k]['admin_name'] = $this->getName($v['admin_id']);
            $result[$k]['created_at'] = $v['created_at'];

        }
        $res['data'] = $result;
        $res['count'] = $item->count();

        return $res;
    }

    private function typeToName($type)
    {
        switch (true) {
            case $type == self::LOGIN_TYPE:$name = '登录相关';
                break;
            case $type == self::ADD_TYPE:$name = '添加相关';
                break;
            case $type == self::SAVE_TYPE:$name = '保存相关';
                break;
            case $type == self::DELETE_TYPE:$name = '删除相关';
                break;
            default:$name = '其他操作';
        }
        return $name;
    }

    private function getName($admin_id)
    {
        $name = AdminModel::where('id', $admin_id)->value('account');

        if (empty($name)) {
            $name = '无该用户';
        }

        return $name;
    }

    public function detailLog(){
        $data = $this->log;
        $log = self::find($data['id'])->toArray();
        $log['user'] = $this->getName($log['admin_id']);
        $log['type'] = $this->typeToName($log['type']);
        return $log;
    }

}
