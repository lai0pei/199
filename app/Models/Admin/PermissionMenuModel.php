<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: PermissionMenuModel.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Tuesday, 4th January 2022 8:04:00 am
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2022 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Models\Admin;

class PermissionMenuModel extends CommonModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permission';

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function permissionList()
    {
        $data = $this->data;

        $permission = self::get()->toArray();

        if (empty($permission)) {
            return [];
        }

        $auth = AuthGroupModel::where('role_id', $data['id'])->value('auth_id');

        $auth_list = [];
        if (! empty($auth)) {
            $auth_list = explode(',', $auth);
        }

        $auth_menu = new AuthMenuModel();
        $current_id = array_unique(array_column($permission, 'current_auth_id'));
        $menu = [];
        $sub_menu = [];
        $i = 0;
        foreach ($current_id as $v) {
            $menu[$i]['id'] = $i;
            $menu[$i]['title'] = $auth_menu::where('id', $v)->where('status', 1)->value('title');
            $menu[$i]['checked'] = false;
            $menu[$i]['spread'] = true;
            $menu[$i]['field'] = 'node';
            $menu[$i]['type'] = 1;
            $current_menus = self::where('current_auth_id', $v)->select('id', 'name', 'title')->get()->toArray();

            foreach ($current_menus as $menu_key => $menu_value) {
                $sub_menu[$menu_key]['checked'] = false;
                if (in_array($menu_value['id'], $auth_list)) {
                    $sub_menu[$menu_key]['checked'] = true;
                }
                $sub_menu[$menu_key]['id'] = $menu_value['id'];
                $sub_menu[$menu_key]['title'] = $menu_value['title'];
                $sub_menu[$menu_key]['field'] = 'node';
                $sub_menu[$menu_key]['type'] = 1;
            }

            $menu[$i]['children'] = $sub_menu;
            unset($sub_menu);
            $i++;
        }

        return $menu;
    }

    public function authList()
    {
        $data = $this->data;
        $limit = $data['limit'] ?? 15;
        $page = $data['page'] ?? 1;

        $where = [];
        if (! empty($data['searchParams'])) {
            $param = json_decode($data['searchParams'], true, 512, JSON_THROW_ON_ERROR);
            if (! empty($param['name'])) {
                $where['title'] = trim($param['name']);
            }
        }

        $item = self::where($where)->paginate($limit, '*', 'page', $page);
        $auth_menu = new AuthMenuModel();

        $result = [];
        foreach ($item->items() as $k => $v) {
            $result[$k]['id'] = $v['id'];
            $result[$k]['name'] = $v['name'];
            $result[$k]['title'] = $v['title'];
            $result[$k]['menu_title'] = $auth_menu::where('id', $v['current_auth_id'])->value('title');
            $result[$k]['updated_at'] = $this->toTime($v['updated_at']);
            $result[$k]['created_at'] = $this->toTime($v['created_at']);
        }
        $res['data'] = $result;
        $res['count'] = self::where($where)->count();

        return $res;
    }

    public function viewPermission()
    {
        $data = $this->data;

        return self::find($data['id']);
    }

    public function menuType()
    {
        return [
            '添加',
            '编辑',
            '删除',
            '查看身份',
            '预览',
            '表单配置',
            '导入',
            '导出',
            '一键清除数据',
            '审核操作',
            '批量通过',
            '批量拒绝',
            '批量删除',
        ];
    }
}
