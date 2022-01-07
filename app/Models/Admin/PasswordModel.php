<?php

namespace App\Models\Admin;

use App\Exceptions\LogicException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class PasswordModel extends CommonModel
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
        $this->data = $data;
    }

    public function getPassword()
    {
        $user_id = session('user_id');

        $admin = self::where('id', $user_id)->find($user_id)->toArray();
        $role = RoleModel::where('id', $admin['role_id'])->value('role_name');
        $admin['role_name'] = $role;
        return $admin;
    }

    public function changePassword()
    {
        $data = $this->data;
        $user_id = session('user_id');
        $password = $data['old'];
        $new_password = $data['new'];
        $re_password = $data['re-new'];

        $admin = self::find($user_id);

        if (! password_verify($password, $admin->password)) {
            throw new LogicException('老密码不正确');
        }

        if ($re_password !== $new_password) {
            throw new LogicException('密码不一致');
        }

        $admin_password = password_hash($new_password, PASSWORD_DEFAULT);

        $new_admin = [
            'password' => $admin_password,
            'updated_at' => now(),
        ];

        DB::beginTransaction();

        $status = self::where('id', $user_id)->where('is_delete', 0)->update($new_admin);

        if (! $status) {
            DB::rollBack();

            throw new LogicException('修改密码失败');
        }

        $log_data = ['type' => LogModel::SAVE_TYPE, 'title' => $admin->account . ' 修改了登录密码'];

        (new LogModel($log_data))->createLog();

        DB::commit();

        return true;
    }
}
