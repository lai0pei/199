<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'configs';

    public function __construct($data = [])
    {
        $this->data = $data;
    
    }

    public function saveConfig($name,$title){

        $data = $this->data;

        $smsConfig = json_decode($data['data'], true);

        $update = [
            'json_data' =>  serialize($smsConfig),
            'updated_at' => now(),
        ];

        $status = self::where('name',$name)->update($update);

        if($status){

        $log_data = ['type' => LogModel::SAVE_TYPE, 'title' => $title];

        (new LogModel($log_data))->createLog();

        }


        return true;
    }

    public function getConfig($name){
      
        return unserialize(self::where('name',$name)->value('json_data'));

    }

 
}
