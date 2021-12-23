<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommonSettingController extends Controller
{
    //

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function common(){
        return view('admin.common_settings.setting');
    }
}
