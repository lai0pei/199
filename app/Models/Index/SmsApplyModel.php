<?php

namespace App\Models\Index;

use App\Models\Admin\MobileModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use LogicException;

class SmsApplyModel extends Model
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
    protected $table = 'sms_apply';

    public function smsForm(){
        {
            $data = $this->data;
            $username = $data['username'];
            $pic_url = $data['imageUrl'];
            $game = $data['gameName'];
            $mobile = $data['mobile'];
            $form = [];

       
            $form = (new ApplyModel())->removeNull($data['form']);
            
            if (!empty($pic_url)) {
                foreach ($pic_url as &$v) {
                    $v['name'] = $this->formModel::where('id', $v['id'])->value('name');
                    unset($v['id']);
                }
                unset($v);
                $form = array_merge($form, $pic_url);
            }

            try {
    
                DB::beginTransaction();
                $mobileModel = new MobileModel();
                $isMatch = $mobileModel::where('mobile',$mobile)->value('id');
    
                $insert = [
                    'user_name' => $username,
                     'game' =>  $game,
                    'value' => serialize($form),
                    'mobile'=> $mobile,
                    'apply_time' => now(),
                    'state' => 0,
                    'is_match' => (empty($isMatch))?0:1,
                    'is_delete' => 0,
                    'ip' => request()->ip(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
    
                $status = self::insert($insert);
            } catch (LogicException $e) {
                throw new LogicException("申请失败");
            }
            if (!$status) {
                DB::rollBack();
                throw new LogicException('申请失败，请联系客服');
            }
    
            DB::commit();
    
            return true;
    
        }
    }
}
