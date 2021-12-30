<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: FormModel.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Friday, 24th December 2021 3:16:37 pm
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Models\Admin;

use App\Exceptions\LogicException;
use App\Models\Admin\CommonModel;
use Illuminate\Support\Facades\DB;

class FormModel extends CommonModel
{
    const TEXT = '输入框';
    const NUM = '数字框';
    const PH = '手机号码';
    const TIME = '时间框';
    const PHOTO = '图片框';
    const DROP = '下拉框';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'form';

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function getFormList()
    {
        $data = $this->data;

        $limit = $data['limit'] ?? 15;
        $page = $data['page'] ?? 1;

       
        if (!empty($data['searchParams'])) {
            $param = json_decode($data['searchParams'], true);
            if($param['id'] !== ''){
                $data['id'] = $param['id'];
            }
        }

        $item = self::where('event_id', $data['id'])->paginate($limit, "*", "page", $page);

        $result = [];

        foreach ($item->items() as $k => $v) {

            $result[$k]['id'] = $v['id'];
            $result[$k]['name'] = $v['name'];
            $result[$k]['event'] = $this->getEventName($v['event_id']);
            $result[$k]['sort'] = $v['sort'];
            $result[$k]['option'] = $this->getOptionName($v['type']);
            $result[$k]['created_at'] = $this->toTime($v['created_at']);

        }
        $res['data'] = $result;
        $res['count'] = $item->count();

        return $res;
    }

    private function getEventName($id)
    {
        return EventModel::find($id)->value('name');
    }

    // 表单类型 0 输入框, 1数字类型, 2手机号码, 3时间框, 4图片框, 5下拉框
    private function getOptionName($id)
    {

        switch (true) {
            case $id == 1:$name = self::NUM;
                break;
            case $id == 2:$name = self::PH;
                break;
            case $id == 3:$name = self::TIME;
                break;
            case $id == 4:$name = self::PHOTO;
                break;
            case $id == 5:$name = self::DROP;
                break;
            default:$name = self::TEXT;
        }

        return $name;
    }

    public function formDelete()
    {

        $data = $this->data;

        DB::beginTransaction();

        $status = self::where('id', $data['id'])->delete();

        if (false === $status) {

            DB::rollBack();

            throw new LogicException('删除失败');

        } else {

            $log_data = ['type' => LogModel::DELETE_TYPE, 'title' => '删除了活动表单'];

            (new LogModel($log_data))->createLog();

            DB::commit();

            return true;
        }
    }

    public function getFormById()
    {

        $data = $this->data;

        if (empty($data['id'])) {
            $res = [];
        } else {
            $res = self::find($data['id'])->toArray();
            $res['type_name'] = $this->getOptionName($res['type']);
        }

        return $res;
    }

    public function getFormType()
    {
        return [
            "0" => self::TEXT,
            "1" => self::NUM,
            "2" => self::PH,
            "3" => self::TIME,
            "4" => self::PHOTO,
            "5" => self::DROP,
        ];

    }

    public function formAdd()
    {

        $data = $this->data;

        DB::beginTransaction();
   
        if (-1 == $data['id']) {
            $add = [
                'name' => $data['name'],
                'type' => $data['type'],
                'option' => $data['option'],
                'event_id' => $data['event_id'],
                'sort' => $data['sort'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $status = self::insert($add);

            if (false === $status) {

                DB::rollBack();

                throw new LogicException('添加失败');

            } else {

                $log_data = ['type' => LogModel::ADD_TYPE, 'title' => '添加了新活动表单 [' . $data['name'] . ']'];

                (new LogModel($log_data))->createLog();

                DB::commit();

                return true;
            }

        } else {
            $save = [
                'name' => $data['name'],
                'type' => $data['type'],
                'option' => $data['option'],
                'sort' => $data['sort'],
                'event_id' => $data['event_id'],
                'updated_at' => now(),
            ];

            $status = self::where('id', $data['id'])->update($save);

            if (false === $status) {

                DB::rollBack();

                throw new LogicException('添加失败');

            } else {

                $log_data = ['type' => LogModel::SAVE_TYPE, 'title' => '编辑了活动[' . $data['name'] . ']'];

                (new LogModel($log_data))->createLog();

                DB::commit();

                return true;
            }
        }
    }
}
