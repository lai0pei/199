<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthGroupModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'auth_group';

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function submitList(){
        $data = $this->data;
        $menus = json_decode($data['checked'], true);
       
        if(empty($data)){
            return true;
        }
       
        $ids = [];
        $i = 0;
        foreach($menus as $v ){
            foreach($v['children'] as $k => $vv){
                $ids[$i] = $vv['id'];
                $i ++;
            }
        }
        $auth_id = implode(",",$ids);
       
        $update = [
            'updated_at' => now(),
            'auth_id' => $auth_id,
        ];

        self::where('role_id',$data['id'])->update($update);

        $log_data = ['type' => LogModel::DELETE_TYPE, 'title' => '更改管理员权限'];

        (new LogModel($log_data))->createLog();

        return true;
    }
}
