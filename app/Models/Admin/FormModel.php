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
use Illuminate\Support\Facades\DB;

class FormModel extends CommonModel
{
    public const TEXT = '文本框';
    public const NUM = '数字框';
    public const PH = '手机号码';
    public const TIME = '时间框';
    public const PHOTO = '图片框';
    public const DROP = '下拉框';

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

    /**
     * getFormList
     *
     * @return array
     */
    public function getFormList(): array
    {
        $data = $this->data;

        $limit = $data['limit'] ?? 15;
        $page = $data['page'] ?? 1;

        if (! empty($data['searchParams'])) {
            $param = json_decode($data['searchParams'], true);
            if ($param['id'] !== '') {
                $data['id'] = $param['id'];
            }
        }

        if (! isset($data['id'])) {
            throw new LogicException('编号必须');
        }

        $item = self::where('event_id', $data['id'])->paginate($limit, '*', 'page', $page);

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
        $res['count'] = self::count();

        return $res;
    }

    /**
     * 删除
     *
     * @return bool
     */
    public function formDelete(): bool
    {
        $data = $this->data;

        DB::beginTransaction();

        $status = self::where('id', $data['id'])->delete();

        if (! $status) {
            DB::rollBack();

            throw new LogicException('删除失败');
        }

        $log_data = ['type' => LogModel::DELETE_TYPE, 'title' => '删除了活动表单'];

        (new LogModel($log_data))->createLog();

        DB::commit();

        return true;
    }

    /**
     * 获取类型
     *
     * @return array
     */
    public function getFormById(): array
    {
        $data = $this->data;
        $res = [];
        if (isset($data['id'])) {
            $form = self::find($data['id']);
            if ($form === null) {
                return [];
            }
            $res = $form->toArray();
            $res['type_name'] = $this->getOptionName($res['type']);
        }

        return $res;
    }

    /**
     * getFormType
     *
     * @return array
     */
    public function getFormType(): array
    {
        return [
            '0' => self::TEXT,
            '1' => self::NUM,
            '2' => self::PH,
            '3' => self::TIME,
            '4' => self::PHOTO,
            '5' => self::DROP,
        ];
    }

    /**
     * formAdd
     *
     * @return bool
     */
    public function formAdd(): bool
    {
        $data = $this->data;

        $time = now();

        DB::beginTransaction();

        if ((int) $data['type'] === 4) {
            $id = self::where('event_id', $data['event_id'])->where('type', 4)->value('id');

            if ($id !== null && $id !== (int) $data['id']) {
                throw new LogicException('最多一个图片框');
            }
        }

        $formData = [
            'name' => $data['name'],
            'type' => $data['type'],
            'option' => $data['option'] ?? '',
            'event_id' => $data['event_id'],
            'sort' => $data['sort'],
            'updated_at' => $time,
        ];

        if ((int) $data['id'] === -1) {
            $formData['created_at'] = $time;
            $status = self::insert($formData);

            if (! $status) {
                DB::rollBack();

                throw new LogicException('添加失败');
            }

            $log_data = ['type' => LogModel::ADD_TYPE, 'title' => '添加了新活动表单 [' . $data['name'] . ']'];

            (new LogModel($log_data))->createLog();
        } else {
            $status = self::where('id', $data['id'])->update($formData);

            if (! $status) {
                DB::rollBack();

                throw new LogicException('保存失败');
            }

            $log_data = ['type' => LogModel::SAVE_TYPE, 'title' => '编辑了活动[' . $data['name'] . ']'];

            (new LogModel($log_data))->createLog();
        }

        DB::commit();

        return true;
    }

    private function getEventName($id)
    {
        return EventModel::find($id)->value('name');
    }

    // 表单类型 0 文本框, 1数字类型, 2手机号码, 3时间框, 4图片框, 5下拉框
    /**
     * getOptionName
     *
     * @param  mixed $id
     *
     * @return string
     */
    private function getOptionName($id): string
    {
        switch (true) {
            case $id === 1:
                $name = self::NUM;
                break;
            case $id === 2:
                $name = self::PH;
                break;
            case $id === 3:
                $name = self::TIME;
                break;
            case $id === 4:
                $name = self::PHOTO;
                break;
            case $id === 5:
                $name = self::DROP;
                break;
            default:
                $name = self::TEXT;
        }

        return $name;
    }
}
