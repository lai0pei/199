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

    public function saveConfig($id){
        $data = $this->data;
        $config = json_decode($data, true);
    }

    public function getConfig($id){
        $data = $this->data;
        $config = json_decode($data, true);
    }

    public function saveSms(){
        $data = $this->data;
        dd($data);
        $smsConfig = json_decode($data['data'], true);

        $update = [
            'json_data' =>  serialize($smsConfig),
            'updated_at' => now(),
        ];
        
        return self::where('name','smsConfig')->update($update);
    }

    public function getSms(){
        $sms = self::where('name','smsConfig')->value('json_data');
        $faker = [
            'cloud_key' => '',
            'cloud_sign' => '',
            'cloud_temp' => '',
            'ju_key' => '',
            'ju_sign' => '',
            'ju_id' => '',
            'status' => 0,
        ];
        if(!empty($sms)){
            $data = unserialize($sms);
        }else{
            $data = $faker;
        }
        
        return $data;

    }

 
}
