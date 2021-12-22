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
        $user_id = session('user_id');
        $key = 'admin_menu_' . session('user_id');
        // $menus = Cache::get($key);
        // if (!empty($menus)) {
        //     return $menus;
        // }
        $role_id = AdminModel::where('id',$user_id)->value('role_id');
        $permission = AuthGroupModel::where('role_id',$role_id)->value('auth_id');

        if(empty($permission)){
            return [];
        }
        $list = explode(',', $permission);
        $permission_menu = PermissionMenuModel::whereIn('id', $list)->get()->toArray();

        $top_menu_permission = array_unique(array_column($permission_menu,'grand_auth_id'));
        $child_menu_permission = array_unique(array_column($permission_menu,'parent_auth_id'));
        $grand_menu_permission = array_unique(array_column($permission_menu,'current_auth_id'));
      
        $init = [];
        $init['homeInfo'] = ['title' => '活动分析', 'href' => ''];
        $init['logoInfo'] = ['title' => '活动页面', 'image' => asset('image/logo.png'), 'href' => ''];

        $columns = ['id', 'p_id', 'title', 'href', 'icon', 'target'];
        $where = [];
        $where['p_id'] = 0;
        $where['status'] = 1;
        $top_menu = self::where($where)->orderBy('sort')->get($columns)->toArray();

        foreach ($top_menu as &$child_menu) {
            if(!in_array($child_menu['id'],$top_menu_permission)){
                continue;
            }
            
            $where['p_id'] = $child_menu['id'];
            $child_menu['child'] = self::where($where)->orderBy('sort')->get($columns)->toArray();
            foreach ($child_menu['child'] as &$grand_menu) {
                if(!in_array($grand_menu['id'],$child_menu_permission)){
                    continue;
                }
                $where['p_id'] = $grand_menu['id'];
                $grand = self::where($where)->orderBy('sort')->get($columns)->toArray();
                foreach($grand as $vv){
                   
                    if(in_array($vv['id'], $grand_menu_permission)){
                        $grand_menu['child'] = $vv;
                    }

                }
            }
        }
        unset($child_menu);
        unset($grand_menu);
       
        $init['menuInfo'] = $top_menu;
        Cache::put($key, $init, now()->addMinute(30));
        return $init;
    }

}
