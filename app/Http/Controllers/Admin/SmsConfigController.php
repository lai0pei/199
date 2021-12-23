<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ConfigModel;
use Illuminate\Http\Request;

class SmsConfigController extends Controller
{
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function sms_config(){
        $sms = (new ConfigModel($this->request->all()))->getConfig('smsConfig');
        return view('admin.sms_config.sms_config',['sms'=>$sms]);
    }

    public function saveSms(){
        return self::json_success((new ConfigModel($this->request->all()))->saveConfig('smsConfig','更新了后台短信配置'));
    }
}
