<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: MobileModel.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Friday, 24th December 2021 7:28:48 pm
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Models\Admin;

use App\Exceptions\LogicException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MobileModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vip_mobile';

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function getMobile()
    {
        $data = $this->data;

        $limit = $data['limit'] ?? 15;
        $page = $data['page'] ?? 1;

        $where = [];

        if (!empty($data['searchParams'])) {
            $param = json_decode($data['searchParams'], true);

            if ($param['mobile'] !== '') {
                $where['mobile'] = $param['mobile'];
            }
        }

        $item = self::where($where)->orderbydesc('id')->paginate($limit, "*", "page", $page);

        $result = [];

        foreach ($item->items() as $k => $v) {
            $result[$k]['id'] = $v['id'];
            $result[$k]['mobile'] = $v['mobile'];
            $result[$k]['created_at'] = $v['created_at'];
        }

        $res['data'] = $result;
        $res['count'] = $item->count();

        return $res;
    }

    public function deleteMobile()
    {

        $data = $this->data;

        DB::beginTransaction();

        try {
            $ids = array_column($data['id'], 'id');
            $count = count($ids);
            $status = self::whereIn('id', $ids)->delete();
            $title = '删除了' . $count . '行vip电话号码';

        } catch (LogicException $e) {
            DB::rollBack();
            throw new LogicException($e->getMessage());
        }

        if (false === $status) {

            DB::rollBack();

            throw new LogicException('删除失败');

        } else {

            $log_data = ['type' => LogModel::DELETE_TYPE, 'title' => $title];

            (new LogModel($log_data))->createLog();

            DB::commit();

            return true;
        }
    }

    public function maniMobile()
    {

        $data = $this->data;

        DB::beginTransaction();
        try {
            self::insert([
                'mobile' => $data['mobile'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (LogicException $e) {

            DB::rollBack();
            throw new LogicException($e->getMessage());

        }

        $log_data = ['type' => LogModel::DELETE_TYPE, 'title' => '添加了一行vip手机号码'];

        (new LogModel($log_data))->createLog();

        DB::commit();

        return true;
    }

    public function oneClick()
    {

        self::truncate();

        $log_data = ['type' => LogModel::DELETE_TYPE, 'title' => '一键清除了所有电话数据'];

        (new LogModel($log_data))->createLog();
    }

}
