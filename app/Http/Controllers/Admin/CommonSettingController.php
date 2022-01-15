<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $request['data'] = stripUrl($this->request->input('data'));
        return self::json_success((new ConfigModel($request))->saveConfig('logo', '更新了 前台 图片'));
    }
}
