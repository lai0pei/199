<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: EventTypeModel.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Thursday, 23rd December 2021 12:24:52 pm
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Models\Admin;

use App\Exceptions\LogicException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EventTypeModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'type';

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function maniType()
    {
        $data = $this->data;

        DB::beginTransaction();

        if ($data['id'] == -1) {
            $add = [
                'name' => $data['name'],
                'status' => $data['status'],
                'sort' => $data['sort'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $status = self::insert($add);

            if (false === $status) {

                DB::rollBack();

                throw new LogicException('添加失败');

            } else {

                $log_data = ['type' => LogModel::ADD_TYPE, 'title' => '添加新活动类型'];

                (new LogModel($log_data))->createLog();

                DB::commit();

                return true;
            }

        } else {
            $save = [
                'name' => $data['name'],
                'status' => $data['status'],
                'sort' => $data['sort'],
                'updated_at' => now(),
            ];

            $status = self::where('id', $data['id'])->update($save);

            if (false === $status) {

                DB::rollBack();

                throw new LogicException('添加失败');

            } else {

                $log_data = ['type' => LogModel::SAVE_TYPE, 'title' => '编辑允许登录ip地址'];

                (new LogModel($log_data))->createLog();

                DB::commit();

                return true;
            }
        }
    }

    public function getType()
    {
        $data = $this->data;
    
        if (!empty($data['id'])) {
            $res = self::find($data['id'])->toArray();
        } else {
            $res = [];
        }
        return $res;
    }

    public function listType()
    {
        $data = $this->data;
        $limit = $data['limit'] ?? 15;
        $page = $data['page'] ?? 1;

        $column = ['id', 'name','status', 'created_at', 'updated_at','sort'];

        $item = self::select($column)->paginate($limit, "*", "page", $page);

        $result = [];

        foreach ($item->items() as $k => $v) {
            $result[$k]['id'] = $v['id'];
            $result[$k]['name'] = $v['name'];
            $result[$k]['status'] = $this->getStatus($v['status']);
            $result[$k]['sort'] = $v['sort'];
            $result[$k]['created_at'] = $v['created_at'];
            $result[$k]['updated_at'] = $v['updated_at'];
        }

        $res['data'] = $result;
        $res['count'] = $item->count();
        return $res;
    }

    private function getStatus($status)
    {
        if (1 == $status) {
            $name = '正常';
        } else {
            $name = '禁用';
        }

        return $name;
    }

    public function typeDelete()
    {
        $data = $this->data;

        DB::beginTransaction();

        $status = self::where('id', $data['id'])->delete();

        if (false === $status) {

            DB::rollBack();

            throw new LogicException('删除失败');

        } else {

            $log_data = ['type' => LogModel::DELETE_TYPE, 'title' => '删除了一项活动类型'];

            (new LogModel($log_data))->createLog();

            DB::commit();

            return true;
        }
    }

    public function getAllType(){
        return self::where('status',1)->get()->toArray();
    }

   
}
