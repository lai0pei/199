<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: AdminModel.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Friday, 17th December 2021 6:10:41 pm
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Models\Admin;

use App\Exceptions\LogicException;
use App\Models\Admin\LogModel;
use App\Models\Admin\RoleModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\CommonModel;

class AdminModel extends CommonModel
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['account', 'password', 'role_id', 'reg_ip', 'status', 'login_count', 'last_date', 'user_name'];

    public function __construct($data = [])
    {

        $this->adminData = $data;
    }

    /**
     * 链表获取 角色名称
     *
     * @return void
     */
    public function role_name()
    {
        return $this->hasOne(RoleModel::class, 'id', 'role_id');
    }

    /**
     * 管理员登录
     *
     * @return void
     */
    public function adminLogin()
    {
        $data = $this->adminData;

        $admin = AdminModel::where('account', $data['username'])->first();

        if (empty($admin)) {
            throw new LogicException('账号不存在');
        }

        if (!password_verify($data['password'], $admin->password)) {
            throw new LogicException('账号密码不正确');
        }

        if (1 != $admin->status) {
            throw new LogicException('该账号禁用 无法进行登录，请联系管理员');
        }

        $this->setAdminSession($admin->id);

        $admin->login_count += 1;

        $admin->last_date = now();

        $admin->last_ip = request()->ip();

        $admin->save();

        $log_data = ['type' => LogModel::LOGIN_TYPE, 'title' => '登录后台'];

        $log = new LogModel($log_data);

        $log->createLog();

        return true;

    }

    /**
     * 管理员session
     *
     * @return void
     */
    private function setAdminSession($user_id)
    {
        return session()->put('user_id', $user_id);
    }

    /**
     * 登出
     *
     * @return void
     */
    public function logout()
    {
        $log_data = ['type' => LogModel::LOGIN_TYPE, 'title' => '登出后台'];

        $log = new LogModel($log_data);

        $log->createLog();

        session()->flush();
    }

    /**
     * 获取用户名
     *
     * @return void
     */
    public function getName()
    {
        return self::where('id', session('user_id'))
            ->where('status', 1)
            ->value('user_name');
    }

    public function listAdmin()
    {
        $data = $this->adminData;
        $limit = $data['limit'] ?? 15;
        $page = $data['page'] ?? 1;

        $column = ['id', 'account', 'user_name', 'last_ip', 'status', 'login_count', 'last_date', 'role_id'];
        $where = [];
        $where['is_delete'] = 0;
        if (!empty($data['searchParams'])) {
            $param = json_decode($data['searchParams'], true);

            if ($param['role_id'] !== '') {
                $where['role_id'] = $param['role_id'];
            }
            if ($param['account'] !== '') {
                $where['account'] = $param['account'];
            }
            if ($param['user_name'] !== '') {
                $where['user_name'] = $param['user_name'];
            }
            if ($param['status'] !== '') {
                $where['status'] = $param['status'];
            }

        }

        $item = self::select($column)->where($where)->with(['role_name' => function ($query) {
            $query->select(['id', 'role_name']);
        }])->paginate($limit, "*", "page", $page);

        $result = [];
        foreach ($item->items() as $k => $v) {
            $result[$k]['id'] = $v['id'];
            $result[$k]['account'] = $v['account'];
            $result[$k]['user_name'] = $v['user_name'];
            $result[$k]['last_ip'] = $v['last_ip'];
            $result[$k]['login_count'] = $v['login_count'];
            $result[$k]['last_date'] = $this->toTime($v['last_date']);
            $result[$k]['login_count'] = $v['login_count'];

            if ($v['status'] == 1) {
                $result[$k]['status'] = "正常";
            } else {
                $result[$k]['status'] = "禁用";
            }

            if (empty($v['role_name']['role_name'])) {
                $result[$k]['role_name'] = "无";
            } else {
                $result[$k]['role_name'] = $v['role_name']['role_name'];
            }

        }
        $res['data'] = $result;
        $res['count'] = $item->count();
        return $res;
    }

    public function addAdmin()
    {$data = $this->adminData;
        $account = self::where('account', $data['account'])->value('account');
        $user_name = self::where('user_name', $data['username'])->value('user_name');
        

        if ($data['account'] == $account ) {
            throw new LogicException('账号已存在');
        }

        if ($data['username'] == $user_name) {
            throw new LogicException('昵称存在');
        }

        $admin_password = password_hash($data['password'], PASSWORD_DEFAULT);

        $new_admin = [
            'account' => $data['account'],
            'password' => $admin_password,
            'user_name' => $data['username'],
            'role_id' => $data['role'],
            'reg_ip' => request()->ip(),
            'status' => $data['status'],
            'is_delete' => 1,
            'number' => $data['number'],
            'login_count' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::beginTransaction();

        $status = self::insert($new_admin);

        if (false === $status) {
            DB::rollBack();
            throw new LogicException('添加失败');
        } else {

            $log_data = ['type' => LogModel::ADD_TYPE, 'title' => '创建新管理员'];

            (new LogModel($log_data))->createLog();

            DB::commit();

            return true;
        }

    }

    public function editAdmin()
    {
        $data = $this->adminData;
        $column = ['id', 'account', 'user_name', 'last_ip', 'status', 'login_count', 'last_date', 'role_id', 'number'];
        return self::where('id', $data['id'])->get($column);

    }

    public function saveAdmin()
    {
        $data = $this->adminData;

        $save['account'] = $data['account'];
        $save['user_name'] = $data['username'];
        $save['role_id'] = $data['role'];
        $save['updated_at'] = now();
        $save['status'] = $data['status'];
        $save['number'] = $data['number'];

        if (!empty($data['password'])) {
            $save['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        if(1 == $data['id'] && $data['status'] == 0){
            throw new LogicException('总管理员不可禁用');
        }

        try {

            DB::beginTransaction();

            $status = self::where("id", $data['id'])->update($save);

            if (false === $status) {

                DB::rollBack();

                throw new LogicException('编辑失败');

            } else {

                $log_data = ['type' => LogModel::SAVE_TYPE, 'title' => '编辑管理员'];

                (new LogModel($log_data))->createLog();

                DB::commit();

                return true;
            }
        } catch (LogicException $e) {

            throw new LogicException($e->getMessage());

        }

    }

    public function deleteAdmin()
    {

        $data = $this->adminData;

        DB::beginTransaction();

        $admin = self::find($data['id']);

        if (empty($admin)) {

            throw new LogicException('此管理员不存在');

        }

        if ($data['id'] == 1) {
            throw new LogicException('总管理员不可删除');
        }

        // $delete = [
        //     'is_delete' => 0,
        // ];

        $status = self::where("id", $data['id'])->delete();

        if (false === $status) {

            DB::rollBack();

            throw new LogicException('删除失败');

        } else {

            $log_data = ['type' => LogModel::DELETE_TYPE, 'title' => '删除管理员 ' . $admin->user_name];

            (new LogModel($log_data))->createLog();

            DB::commit();

            return true;
        }
    }

}
