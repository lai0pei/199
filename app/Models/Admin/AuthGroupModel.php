<?php

namespace App\Models\Admin;

use App\Exceptions\LogicException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class AuthGroupModel extends CommonModel
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'auth_group';

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * 权限提交
     *
     * @return bool
     */
    public function submitList(): bool
    {
        $data = $this->data;

        DB::beginTransaction();
        try {
            $menus = json_decode($data['checked'], true, 512, JSON_THROW_ON_ERROR);

            if (empty($data)) {
                return false;
            }

            $ids = [];
            $i = 0;
            foreach ($menus as $v) {
                foreach ($v['children'] as $vv) {
                    $ids[$i] = $vv['id'];
                    ++$i;
                }
            }
            $auth_id = implode(',', $ids);

            $update = [
                'updated_at' => now(),
                'auth_id' => $auth_id,
            ];

            $status = self::where('role_id', $data['id'])->update($update);
            if (! $status) {
                throw new LogicException('添加失败');
            }
        } catch (LogicException $e) {
            DB::rollBack();
            throw new LogicException('添加失败');
        }

        $log_data = ['type' => LogModel::DELETE_TYPE, 'title' => '更改管理员权限'];

        (new LogModel($log_data))->createLog();

        DB::commit();

        return true;
    }
}
