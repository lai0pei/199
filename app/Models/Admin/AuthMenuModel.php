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

use App\Models\Admin\LogModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use LogicException;

class AuthMenuModel extends Model
{

    /**
     * __construct
     *
     * @param  mixed $data
     * @return void
     */
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'auth_menu';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['p_id', 'title', 'auth_name', 'icon', 'href', 'target', 'status', 'is_shortcut', 'sort'];

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
        $key = 'admin_menu_' . session('user_id');
        $menus = Cache::get($key);
        if (!empty($menus)) {
            return $menus;
        }
        $init = [];
        $init['homeInfo'] = ['title' => '活动分析', 'href' => ''];
        $init['logoInfo'] = ['title' => '活动页面', 'image' => asset('image/logo.png'), 'href' => ''];

        $columns = ['id', 'p_id', 'title', 'href', 'icon', 'target'];
        $where = [];
        $where['p_id'] = 0;
        $where['status'] = 1;
        $top_menu = self::where($where)->orderBy('sort')->get($columns)->toArray();

        foreach ($top_menu as &$child_menu) {
            $where['p_id'] = $child_menu['id'];
            $child_menu['child'] = self::where($where)->orderBy('sort')->get($columns)->toArray();
            foreach ($child_menu['child'] as &$grand_menu) {
                $where['p_id'] = $grand_menu['id'];
                $grand_menu['child'] = self::where($where)->orderBy('sort')->get($columns)->toArray();
            }
        }
        unset($child_menu);
        unset($grand_menu);
        $init['menuInfo'] = $top_menu;
        Cache::put($key, $init, now()->addMinute(30));
        return $init;
    }

}
