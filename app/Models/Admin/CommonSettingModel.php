<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class CommonSettingModel extends Model
{
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function saveCommonConfig(){
        $data = $this->data;
        $configModel = new ConfigModel();
        dd($data);
    }
}
