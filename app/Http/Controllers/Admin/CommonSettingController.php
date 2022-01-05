<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\CommonSettingModel;
use App\Models\Admin\ConfigModel;
use Illuminate\Http\Request;

class CommonSettingController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function common()
    {
        $data = (new ConfigModel($this->request->all()))->getConfig('logo');
        return view('admin.common_settings.setting', ['logo' => $data]);
    }

    public function confirm()
    {   
        return self::json_success((new CommonSettingModel($this->request->all()))->saveCommonConfig());
    }
}
