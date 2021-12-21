<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: RoleModel.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Monday, 20th December 2021 10:39:45 am
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Models\Admin;

use App\Exceptions\LogicException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RoleModel extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'role';

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * Get the user that owns the phone.
     */
    public function role_name()
    {
        return $this->belongsTo(AdminModel::class, 'role_id');
    }

    /**
     * getAllRole
     *
     * @return void
     */
    public function getAllRole()
    {

        $data = $this->data;

        $column = ['id', 'role_name'];

        if (!empty($data['id'])) {

            $result = self::where('status', 1)->where('id', $data['id'])->get($column)->toArray();

        } else {

            $result = self::where('status', 1)->get($column)->toArray();
        }

        return $result;

    }

    /**
     * getRoleByPermission
     *
     * @return void
     */
    public function getRoleByPermission()
    {

        $data = $this->data;
        $limit = $data['limit'] ?? 15;
        $page = $data['page'] ?? 1;

        $where = [];
        if (!empty($data['searchParams'])) {
            $param = json_decode($data['searchParams'], true);
            if (!empty($param['title'])) {
                $where['role_name'] = $param['title'];
            }
        }

        $item = self::where($where)->paginate($limit, "*", "page", $page);

        $result = [];
        foreach ($item->items() as $k => $v) {
            $result[$k]['id'] = $v['id'];
            $result[$k]['role_name'] = $v['role_name'];
            $result[$k]['created_at'] = $v['created_at'];
            $result[$k]['updated_at'] = $v['updated_at'];
            $result[$k]['auth_count'] = 1;

            if ($v['status'] == 1) {
                $result[$k]['status'] = "开启";
            } else {
                $result[$k]['status'] = "关闭";
            }

        }
        $res['data'] = $result;
        $res['count'] = $item->count();

        return $res;
    }

    public function maniRole()
    {
        $data = $this->data;
        $fake = [
            'id' => '-1',
            'role_name' => '',
            'status' => 1,
        ];

        if (!empty($data['id'])) {
            return self::where('id', $data['id'])->get()->toArray()[0];
        } else {
            return $fake;
        }
    }

    /**
     * newGroup
     *
     * @return void
     */
    public function newGroup()
    {
        $data = $this->data;

        $role = self::where('role_name', $data['role_name'])->first();

        $insert = [
            'role_name' => $data['role_name'],
            'status' => $data['status'],
            'updated_at' => now(),
        ];
        //添加
        if ($data['id'] == -1) {

            if (isset($role)) {
                throw new LogicException('同名称已存在');
            }

            $insert['created_at'] = now();

            $status = self::insertGetId($insert);

            if (false == $status) {
                throw new LogicException('添加失败');
            }

            $log_data = ['type' => LogModel::ADD_TYPE, 'title' => '创建管理组'];

            (new LogModel($log_data))->createLog();

            $auth_group = [
                'role_id' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            AuthGroupModel::insert($auth_group);

        } else { //保存

            $edit = self::where('id', $data['id'])->first()->toArray();

            if (!($edit['id'] == $data['id'] && $edit['role_name'] == $data['role_name'])) {
                throw new LogicException('同名称已存在');
            }

            $status = self::where('id', $data['id'])->update($insert);

            if (false == $status) {
                throw new LogicException('保存失败');
            }

            $log_data = ['type' => LogModel::SAVE_TYPE, 'title' => '编辑管理组'];

            (new LogModel($log_data))->createLog();
        }

        return true;
    }

    /**
     * deleteGroup
     *
     * @return void
     */
    public function deleteGroup()
    {

        $data = $this->data;

        DB::beginTransaction();

        $admin = self::find($data['id']);

        if (empty($admin)) {
            throw new LogicException('此管理员不存在');
        }

        $status = self::where("id", $data['id'])->delete();

        if (false === $status) {
            DB::rollBack();
            throw new LogicException('删除失败');
        } else {

            $log_data = ['type' => LogModel::DELETE_TYPE, 'title' => '删除管理组 ' . $admin->role_name];

            (new LogModel($log_data))->createLog();

            DB::commit();

            return true;
        }
    }

    public function getRoleNameById()
    {
        $data = $this->data;

        $role_id = $data['role_id'];
        
        return self::where('id', $role_id)->select('id', 'role_name')->get()->toArray()[0];
    }
}
