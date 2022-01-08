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
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AdminModel extends CommonModel
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin';

    public function __construct($data = [])
    {
        $this->adminData = $data;
        $this->adminId = '';
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
     * @return bool
     */
    public function adminLogin(): bool
    {
        $data = $this->adminData;

        $admin = AdminModel::where('account', $data['username'])->where('is_delete', 0)->first();

        $envIp = config('admin.ip');
        $allowIp = array_column((new IpModel())->getAllIp(), 'ip');
        $adminIp = request()->ip();

        // if ($adminIp !== $envIp && ! in_array($adminIp, $allowIp)) {
        //     throw new LogicException('Ip不允许');
        // }

        if (empty($admin)) {
            throw new LogicException('账号不存在');
        }

        if (! password_verify($data['password'], $admin->password)) {
            throw new LogicException('账号密码不正确');
        }

        if ($admin->status !== 1) {
            throw new LogicException('该账号禁用 无法进行登录，请联系管理员');
        }

        $this->adminId = $admin->id;

        $this->setAdminSession();

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
     * 登出
     *
     * @return void
     */
    public function logout()
    {
        $log_data = ['type' => LogModel::LOGIN_TYPE, 'title' => '登出后台'];

        $log = new LogModel($log_data);

        $log->createLog();

        Cache::forget('admin_menu_' . session('user_id'));

        session()->flush();
    }

    /**
     * 获取用户名
     *
     * @return void
     */
    public function getName()
    {
        $name = self::where('id', session('user_id'))
            ->where('status', 1)
            ->value('user_name');
        if ($name === '') {
            $name = '昵称';
        }
        return $name;
    }

    /**
     * 管理员列表
     *
     * @return array
     */
    public function listAdmin(): array
    {
        $data = $this->adminData;
        $limit = $data['limit'] ?? 15;
        $page = $data['page'] ?? 1;

        $column = ['id', 'account', 'user_name', 'last_ip', 'status', 'login_count', 'last_date', 'role_id'];
        $where = [];
        $where['is_delete'] = 0;
        if (! empty($data['searchParams'])) {
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
        },
        ])->paginate($limit, '*', 'page', $page);

        $result = [];
        foreach ($item->items() as $k => $v) {
            $result[$k]['id'] = $v['id'];
            $result[$k]['account'] = $v['account'];
            $result[$k]['user_name'] = $v['user_name'];
            $result[$k]['last_ip'] = $v['last_ip'];
            $result[$k]['login_count'] = $v['login_count'];
            $result[$k]['last_date'] = $this->toTime($v['last_date']);
            $result[$k]['login_count'] = $v['login_count'];

            if ($v['status'] === 1) {
                $result[$k]['status'] = '正常';
            } else {
                $result[$k]['status'] = '禁用';
            }

            if (empty($v['role_name']['role_name'])) {
                $result[$k]['role_name'] = '无';
            } else {
                $result[$k]['role_name'] = $v['role_name']['role_name'];
            }
        }
        $res['data'] = $result;
        $res['count'] = self::count();
        return $res;
    }

    /**
     * 管理员 添加
     *
     * @return bool
     */
    public function addAdmin(): bool
    {
        $data = $this->adminData;
        $account = self::where('account', $data['account'])->where('is_delete', 0)->value('id');
        $user_name = self::where('user_name', $data['username'])->where('is_delete', 0)->value('id');

        if (isset($account)) {
            throw new LogicException('登录账号已存在');
        }

        if (isset($user_name)) {
            throw new LogicException('昵称已存在');
        }

        $admin_password = password_hash($data['password'], PASSWORD_DEFAULT);

        $new_admin = [
            'account' => $data['account'],
            'password' => $admin_password,
            'user_name' => $data['username'],
            'role_id' => $data['role'],
            'reg_ip' => request()->ip(),
            'status' => $data['status'],
            'is_delete' => 0,
            'number' => $data['number'],
            'login_count' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::beginTransaction();

        $status = self::insert($new_admin);

        if (! $status) {
            DB::rollBack();
            throw new LogicException('添加失败');
        }

        $log_data = ['type' => LogModel::ADD_TYPE, 'title' => '创建新管理员'];

        (new LogModel($log_data))->createLog();

        DB::commit();

        return true;
    }

    public function editAdmin()
    {
        $data = $this->adminData;
        $column = ['id', 'account', 'user_name', 'last_ip', 'status', 'login_count', 'last_date', 'role_id', 'number'];
        return self::where('id', $data['id'])->get($column);
    }

    /**
     * 保存管理员
     *
     * @return bool
     */
    public function saveAdmin(): bool
    {
        $data = $this->adminData;

        $save['account'] = $data['account'];
        $save['user_name'] = $data['username'];
        $save['role_id'] = $data['role'];
        $save['updated_at'] = now();
        $save['status'] = $data['status'];
        $save['number'] = $data['number'];

        if (! empty($data['password'])) {
            $save['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $accountId = self::where('account', $data['account'])->where('is_delete', 0)->value('id');
        $userId = self::where('user_name', $data['username'])->where('is_delete', 0)->value('id');

        if (isset($accountId) && (int) $data['id'] !== $accountId) {
            throw new LogicException('登录账号已存在');
        }

        if (isset($userId) && (int) $data['id'] !== $userId) {
            throw new LogicException('昵称已存在');
        }

        if ((int) $data['id'] === 1 && (int) $data['status'] === 0) {
            throw new LogicException('总管理员不可禁用');
        }

        try {
            DB::beginTransaction();

            $status = self::where('id', $data['id'])->update($save);

            if (! $status) {
                DB::rollBack();

                throw new LogicException('编辑失败');
            }

            $log_data = ['type' => LogModel::SAVE_TYPE, 'title' => '编辑管理员'];

            (new LogModel($log_data))->createLog();

            DB::commit();

            return true;
        } catch (LogicException $e) {
            throw new LogicException($e->getMessage());
        }
    }

    /**
     * 删除管理员
     *
     * @return bool
     */
    public function deleteAdmin(): bool
    {
        $data = $this->adminData;

        DB::beginTransaction();

        $admin = self::find($data['id']);

        if (! isset($admin)) {
            throw new LogicException('此管理员不存在');
        }

        if ((int) $data['id'] === 1) {
            throw new LogicException('总管理员不可删除');
        }

        $delete = [
            'is_delete' => 1,
        ];

        $status = self::where('id', $data['id'])->update($delete);

        if (! $status) {
            DB::rollBack();

            throw new LogicException('删除失败');
        }

        $log_data = ['type' => LogModel::DELETE_TYPE, 'title' => '删除管理员 ' . $admin->user_name];

        (new LogModel($log_data))->createLog();

        DB::commit();

        return true;
    }

    /**
     * 管理员session
     *
     * @return void
     */
    private function setAdminSession()
    {
        return session()->put('user_id', $this->adminId);
    }
}
