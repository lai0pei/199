<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\IpModel;
use Illuminate\Http\Request;

class IpController extends Controller
{
    //

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function allow_ip(){
        $ip = (new IpModel($this->request->all()))->getIp();
        return view('admin.allow_ip.ip');
    }
}
