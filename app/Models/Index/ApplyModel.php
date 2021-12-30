<?php

namespace App\Models\Index;

use Illuminate\Database\Eloquent\Model;

class ApplyModel extends Model
{
  public function __construct($data = [])
  {
      $this->data = $data;
  }
  
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_apply';
 
  public function getApplyList(){
       $where = [];
       $where['status'] = 1;
       $where['is_delete'] = 0;
       $column = ['id','username','event_id'];
       $applyList = self::where($where)->select($column)->limit(20)->get()->toArray();

       $eventModel = new EventModel();
       foreach($applyList as &$v){
            $v['username'] = substr($v['username'],0,3).'****';
           $v['event'] = $eventModel::where('id',$v['event_id'])->value('name');
       }
       unset($v);
       return $applyList;
  }
}
