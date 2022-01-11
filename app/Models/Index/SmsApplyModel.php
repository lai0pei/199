<?php

namespace App\Models\Index;

use App\Models\Admin\MobileModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use LogicException;

class SmsApplyModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sms_apply';
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function smsForm()
    {
        {
            $data = $this->data;
            $eventId = $data['eventId'];
            $username = $data['username'];
            $pic_url = $data['imageUrl'];
            $game = $data['gameName'];
            $mobile = $data['mobile'];
            $form = [];
            
            $event = new EventModel();
            $isMonthly= $event::where('id',$eventId)->value('is_monthly');

            if((int)$isMonthly === 1){
                $startOfmonth = Carbon::now()->startOfMonth();
                $endOfmonth = Carbon::now()->endOfMonth();
     
                $isAllow = self::where('event_id',$data['eventId'])
                ->where('mobile',$mobile)
                ->whereBetween('apply_time',[$startOfmonth, $endOfmonth])
                ->count();
            
                if((int)$isAllow > 1){
                    throw new LogicException('本月申请次数 已超过2次');
                }
            }
         

            $form = (new ApplyModel())->removeNull($data['form']);

            if (! empty($pic_url)) {
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
                $isMatch = $mobileModel::where('mobile', $mobile)->value('id');

                $insert = [
                    'user_name' => $username,
                    'event_id' =>$data['eventId'],
                    'game' => $game,
                    'value' => serialize($form),
                    'mobile' => $mobile,
                    'apply_time' => now(),
                    'state' => 0,
                    'is_match' => empty($isMatch) ? 0 : 1,
                    'is_delete' => 0,
                    'ip' => request()->ip(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $status = self::insert($insert);
            } catch (LogicException $e) {
                throw new LogicException('申请失败');
            }
            if (! $status) {
                DB::rollBack();
                throw new LogicException('申请失败，请联系客服');
            }

            DB::commit();

            return true;

        }
    }
}
