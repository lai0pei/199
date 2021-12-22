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
        if (!empty($auth)) {
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
    
    public function authList(){
      
        $data = $this->data;
        $limit = $data['limit'] ?? 15;
        $page = $data['page'] ?? 1;

        $where = [];
        if (!empty($data['searchParams'])) {
            $param = json_decode($data['searchParams'], true);
            if (!empty($param['name'])) {
                $where['title'] = $param['name'];
            }
        }

        $item = self::where($where)->paginate($limit, "*", "page", $page);
        $auth_menu = new AuthMenuModel();

        $result = [];
        foreach ($item->items() as $k => $v) {
            $result[$k]['id'] = $v['id'];
            $result[$k]['name'] = $v['name'];
            $result[$k]['title'] = $v['title'];
            $result[$k]['menu_title'] = $auth_menu::where('id',$v['current_auth_id'])->value('title');
            $result[$k]['updated_at'] = $v['updated_at'];
            $result[$k]['created_at'] = $v['created_at'];

        }
        $res['data'] = $result;
        $res['count'] = $item->count();

        return $res;
    }

    public function viewPermission(){
        
        $data = $this->data;

        return self::find($data['id']);
    }
}
