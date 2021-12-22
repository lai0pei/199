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
        return view('admin.sms_config.sms_config');
    }

    public function saveSms(){
       
        return self::json_success((new ConfigModel($this->request->all()))->saveSms());
    }
}
