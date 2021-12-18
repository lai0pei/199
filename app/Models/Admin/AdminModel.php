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
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
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

        $admin->save();

        $log_data = ['type' => LogModel::LOGIN_TYPE, 'title' => '登录后台'];

        $log = new LogModel($log_data);

        $log->createLog();

        return true;

    }

    /**
     * 植入管理员session
     *
     * @return void
     */
    private function setAdminSession($user_id)
    {
        return session()->put('user_id', $user_id);
    }

}
