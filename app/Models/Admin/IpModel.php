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

    /**
     * 获取允许登录IP
     */
    public function getIp()
    {
        $data = $this->data;

        return self::find($data['id']);
    }

    /**
     * Ip操作
     *
     * @return bool
     */
    public function maniIp(): bool
    {
        $data = $this->data;
        $admin_id = session('user_id');

        DB::beginTransaction();

        if ((int) $data['id'] === -1) {
            $add = [
                'ip' => $data['ip'],
                'description' => $data['description'],
                'admin_id' => $admin_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $status = self::insert($add);

            if (! $status) {
                DB::rollBack();

                throw new LogicException('添加失败');
            }

            $log_data = ['type' => LogModel::ADD_TYPE, 'title' => '添加允许登录ip地址'];

            (new LogModel($log_data))->createLog();
        } else {
            $save = [
                'id' => $data['id'],
                'ip' => $data['ip'],
                'admin_id' => $admin_id,
                'description' => $data['description'],
                'updated_at' => now(),
            ];

            $status = self::where('id', $data['id'])->update($save);

            if (! $status) {
                DB::rollBack();
                throw new LogicException('编辑失败');
            }
        }
        $log_data = ['type' => LogModel::SAVE_TYPE, 'title' => '编辑允许登录ip地址'];

        (new LogModel($log_data))->createLog();

        DB::commit();

        return true;
    }

    /**
     * listIp
     *
     * @return array
     */
    public function listIp(): array
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

        $column = ['id', 'ip', 'admin_id', 'description', 'created_at', 'updated_at'];

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
        $res['count'] = self::where($where)->count();
        return $res;
    }

    /**
     * ipDelete
     *
     * @return bool
     */
    public function ipDelete(): bool
    {
        $data = $this->data;

        DB::beginTransaction();

        $status = self::where('id', $data['id'])->delete();

        if (! $status) {
            DB::rollBack();

            throw new LogicException('删除失败');
        }

        $log_data = ['type' => LogModel::DELETE_TYPE, 'title' => '删除了一行ip允许登录地址'];

        (new LogModel($log_data))->createLog();

        DB::commit();

        return true;
    }

    /**
     * getAllIp
     *
     * @return array
     */
    public function getAllIp(): array
    {
        return self::select('ip')->get()->toArray();
    }
}
