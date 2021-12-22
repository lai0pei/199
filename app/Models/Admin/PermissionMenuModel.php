<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionMenuModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permission_menu';

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
        if (!empty($auth)) {
            //todo permissi related
            $auth_list = explode(",", $auth); 
        }

        $auth_menu = new AuthMenuModel();
        $current_id = array_unique(array_column($permission, 'current_auth_id'));
        $menu = [];
        $sub_menu = [];

        foreach ($current_id as $i => $v) {
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
        }

        return $menu;

    }

}
