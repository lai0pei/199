<?php

namespace App\Models\Admin;

use App\Exceptions\LogicException;
use Illuminate\Support\Facades\DB;

class IpModel extends CommonModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ip';

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function getIp()
    {
        $data = $this->data;

        if (! empty($data['id'])) {
            $res = self::find($data['id'])->toArray();
        } else {
            $res = [];
        }
        return $res;
    }

    public function mani_ip()
    {
        $data = $this->data;
        $admin_id = session('user_id');

        DB::beginTransaction();

        if ($data['id'] === -1) {
            $add = [
                'ip' => $data['ip'],
                'description' => $data['description'],
                'admin_id' => $admin_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $status = self::insert($add);

            if ($status === false) {
                DB::rollBack();

                throw new LogicException('添加失败');
            }

            $log_data = ['type' => LogModel::ADD_TYPE, 'title' => '添加允许登录ip地址'];

            (new LogModel($log_data))->createLog();

            DB::commit();

            return true;
        }
        $save = [
            'id' => $data['id'],
            'ip' => $data['ip'],
            'admin_id' => $admin_id,
            'description' => $data['description'],
            'updated_at' => now(),
        ];

        $status = self::where('id', $data['id'])->update($save);

        if ($status === false) {
            DB::rollBack();

            throw new LogicException('添加失败');
        }

        $log_data = ['type' => LogModel::SAVE_TYPE, 'title' => '编辑允许登录ip地址'];

        (new LogModel($log_data))->createLog();

        DB::commit();

        return true;
    }

    public function listIp()
    {
        $data = $this->data;
        $limit = $data['limit'] ?? 15;
        $page = $data['page'] ?? 1;

        $where = [];

        if (! empty($data['searchParams'])) {
            $param = json_decode($data['searchParams'], true);
            if ($param['ip'] !== '') {
                $where['ip'] = $param['ip'];
            }
        }

        $column = ['id', 'ip', 'admin_id', 'description','created_at','updated_at'];

        $item = self::select($column)->where($where)->paginate($limit, '*', 'page', $page);

        $admin = new AdminModel();

        $result = [];

        foreach ($item->items() as $k => $v) {
            $result[$k]['id'] = $v['id'];
            $result[$k]['ip'] = $v['ip'];
            $result[$k]['username'] = $admin::where('id', $v['admin_id'])->value('account');
            $result[$k]['description'] = $v['description'];
            $result[$k]['created_at'] = $this->toTime($v['created_at']);
            $result[$k]['updated_at'] = $this->toTime($v['updated_at']);
        }

        $res['data'] = $result;
        $res['count'] = $item->count();
        return $res;
    }

    public function ip_delete()
    {
        $data = $this->data;

        DB::beginTransaction();

        $status = self::where('id', $data['id'])->delete();

        if ($status === false) {
            DB::rollBack();

            throw new LogicException('删除失败');
        }

        $log_data = ['type' => LogModel::DELETE_TYPE, 'title' => '删除了一行ip允许登录地址'];

        (new LogModel($log_data))->createLog();

        DB::commit();

        return true;
    }
}
