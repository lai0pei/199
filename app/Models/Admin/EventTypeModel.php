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
use Illuminate\Support\Facades\DB;

class EventTypeModel extends CommonModel
{
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

    /**
     * 添加 编辑 活动类型
     *
     * @return bool
     */
    public function maniType(): bool
    {
        $data = $this->data;

        DB::beginTransaction();

        if ((int) $data['id'] === -1) {
            if (self::where('name', $data['name'])->value('id') !== null) {
                throw new LogicException('类型名称已存在');
            }

            $add = [
                'name' => $data['name'],
                'status' => $data['status'],
                'sort' => $data['sort'] ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $status = self::insert($add);

            if (! $status) {
                DB::rollBack();

                throw new LogicException('添加失败');
            }

            $log_data = ['type' => LogModel::ADD_TYPE, 'title' => '添加新活动类型'];

            (new LogModel($log_data))->createLog();
        } else {
            $id = self::where('name', $data['name'])->value('id');

            if ($id !== null && $id !== (int) $data['id']) {
                throw new LogicException('类型名称已存在');
            }

            $save = [
                'name' => $data['name'],
                'status' => $data['status'],
                'sort' => $data['sort'] ?? 0,
                'updated_at' => now(),
            ];

            $status = self::where('id', $data['id'])->update($save);

            if (! $status) {
                DB::rollBack();

                throw new LogicException('编辑失败');
            }

            $log_data = ['type' => LogModel::SAVE_TYPE, 'title' => '编辑允许登录ip地址'];

            (new LogModel($log_data))->createLog();
        }

        DB::commit();

        return true;
    }

    /**
     * 获取活动类型
     */
    public function getType()
    {
        $data = $this->data;

        if (empty($data['id'])) {
            $res = [];
        } else {
            $res = self::find($data['id']);
        }
        return $res;
    }

    /**
     * 活动类型列表
     *
     * @return array
     */
    public function listType(): array
    {
        $data = $this->data;
        $limit = $data['limit'] ?? 15;
        $page = $data['page'] ?? 1;

        $where = [];

        if (! empty($data['searchParams'])) {
            $param = json_decode($data['searchParams'], true);
            if ($param['name'] !== '') {
                $where['name'] = $param['name'];
            }
        }

        $column = ['id', 'name', 'status', 'created_at', 'updated_at', 'sort'];

        $item = self::select($column)->orderBy('id', 'desc')->where($where)->paginate($limit, '*', 'page', $page);

        $result = [];

        foreach ($item->items() as $k => $v) {
            $result[$k]['id'] = $v['id'];
            $result[$k]['name'] = $v['name'];
            $result[$k]['status'] = $this->getStatus($v['status']);
            $result[$k]['sort'] = $v['sort'];
            $result[$k]['created_at'] = $this->toTime($v['created_at']);
            $result[$k]['updated_at'] = $this->toTime($v['updated_at']);
        }

        $res['data'] = $result;
        $res['count'] = self::count();

        return $res;
    }

    /**
     * 删除类型
     *
     * @return bool
     */
    public function typeDelete(): bool
    {
        $data = $this->data;

        DB::beginTransaction();

        $eventModel = new EventModel();

        if (! empty($eventModel::where('type_id', $data['id'])->value('id'))) {
            throw new LogicException('此类型活动下还有其他活动,不可删除');
        }

        $status = self::where('id', $data['id'])->delete();

        if (! $status) {
            DB::rollBack();
            throw new LogicException('删除失败');
        }

        $log_data = ['type' => LogModel::DELETE_TYPE, 'title' => '删除了一项活动类型'];

        (new LogModel($log_data))->createLog();

        DB::commit();

        return true;
    }

    /**
     * 获取所有类型
     *
     * @return array
     */
    public function getAllType(): array
    {
        return self::where('status', 1)->get()->toArray();
    }

    /**
     * 获取状态
     *
     * @param  mixed $status
     *
     * @return string
     */
    private function getStatus($status): string
    {
        if ($status === 1) {
            $name = '正常';
        } else {
            $name = '禁用';
        }

        return $name;
    }
}
