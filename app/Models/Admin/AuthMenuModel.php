<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: AuthMenuModel.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Friday, 17th December 2021 6:09:56 pm
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Models\Admin;

use Illuminate\Support\Facades\Cache;
use LogicException;

class AuthMenuModel extends CommonModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'auth_menu';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['p_id', 'title', 'auth_name', 'icon', 'href', 'target', 'status', 'is_shortcut', 'sort'];
    /**
     * __construct
     *
     * @param  mixed $data
     *
     * @return void
     */
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * 新添加 菜单
     *
     * @return void
     */
    public function createAuthMenu()
    {
        $data = $this->data;
        $menus = [
            'title' => $data['title'],
            'p_id' => $data['p_id'],
            'auth_menu' => $data['auth_name'],
            'icon' => $data['icon'],
            'target' => '_self',
            'href' => $data['href'],
            'sort' => $data['sort'] ?? 0,
            'is_shortcut' => $data['is_shortcut'] ?? 0,
            'status' => 1,
        ];

        if (self::create($menus)) {
            throw new LogicException('菜单添加失败');
        }

        $log_data = ['type' => LogModel::ADD_TYPE, 'title' => '添加菜单'];

        (new LogModel($log_data))->createLog();

        return true;
    }

    /**
     * 菜单
     *
     * @return void
     */
    public function menuInit()
    {
        $user_id = session('user_id');
        $key = 'admin_menu_' . session('user_id');
        $menus = Cache::get($key);
        if (! empty($menus)) {
            return $menus;
        }
        $permissions = $this->getPermission($user_id);

        if ($permissions === []) {
            return [];
        }
        $this->setPermission();
        $init = [];
        $init['homeInfo'] = ['title' => '活动报告', 'href' => route('admin_control')];
        $init['logoInfo'] = ['title' => '后台管理', 'image' => asset('image/logo.png'), 'href' => ''];

        $main_menu = $this->topChild($permissions['top_permission'], $permissions['child_permission'], $permissions['grand_permission']);

        $init['menuInfo'] = array_values($main_menu);
        Cache::put($key, $init, now()->addMinute(60));
        return $init;
    }

    public function setPermission()
    {
        $user_id = session('user_id');
        $role_id = AdminModel::where('id', $user_id)->value('role_id');
        $permission = AuthGroupModel::where('role_id', $role_id)->value('auth_id');
        if (empty($permission)) {
            return [];
        }
        $list = explode(',', $permission);
        $column = ['id', 'name'];
        $permission_menu = PermissionMenuModel::whereIn('id', $list)->get($column)->toArray();
        session(['permission' => $permission_menu]);
    }

    /**
     * getMenu
     *
     * @param  mixed $pid
     */
    private function getMenu($pid)
    {
        $columns = ['id', 'p_id', 'title', 'href', 'icon', 'target', 'is_shortcut'];
        $where = [];
        $where['p_id'] = $pid;
        $where['status'] = 1;
        return self::where($where)->orderBy('sort')->get($columns)->toArray();
    }
    /**
     * getPermission
     *
     * @param  mixed $user_id
     *
     * @return void
     */
    private function getPermission($user_id)
    {
        $role_id = AdminModel::where('id', $user_id)->value('role_id');
        $permission = AuthGroupModel::where('role_id', $role_id)->value('auth_id');

        if (empty($permission)) {
            return [];
        }
        $list = explode(',', $permission);
        $permission_menu = PermissionMenuModel::whereIn('id', $list)->get()->toArray();

        $res['top_permission'] = array_unique(array_column($permission_menu, 'grand_auth_id'));
        $res['child_permission'] = array_unique(array_column($permission_menu, 'parent_auth_id'));
        $res['grand_permission'] = array_unique(array_column($permission_menu, 'current_auth_id'));

        return $res;
    }

    /**
     * topChild
     *
     * @param  mixed $top_permission
     * @param  mixed $child_permission
     * @param  mixed $grand_permission
     */
    private function topChild($top_permission, $child_permission, $grand_permission)
    {
        $top_menu = [];
        $child_menu = [];
        $grand_menu = [];
        foreach ($this->getMenu(0) as $topK => $topV) {
            if (in_array($topV['id'], $top_permission)) {
                $top_menu[$topK] = $this->groupData($topV);

                foreach ($this->getMenu($topV['id']) as $childK => $childV) {
                    if (in_array($childV['id'], $child_permission)) {
                        $child_menu[$childK] = $this->groupData($childV);

                        foreach ($this->getMenu($childV['id']) as $grandK => $grandV) {
                            if (in_array($grandV['id'], $grand_permission)) {
                                $grand_menu[$grandK] = $this->groupData($grandV);
                            }
                        }

                        $child_menu[$childK]['child'] = array_values($grand_menu);
                        unset($grand_menu);
                    }
                }

                $top_menu[$topK]['child'] = array_values($child_menu);
                unset($child_menu);
            }
        }

        return $top_menu;
    }

    private function groupData($data)
    {
        return [
            'id' => $data['id'],
            'p_id' => $data['p_id'],
            'title' => $data['title'],
            'icon' => $data['icon'],
            'target' => $data['target'],
            'href' => $data['href'],
            'is_shorcut' => $data['is_shortcut'],
        ];
    }
}
