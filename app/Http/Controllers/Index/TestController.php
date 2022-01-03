<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Index\util\generateCode;
use App\Http\Controllers\Index\util\juhe;
use App\Http\Controllers\Index\util\yunpian;
use Illuminate\Http\Request;
use App\Models\Admin\ControlModel;

class TestController extends Controller
{

    use juhe;
    use generateCode;
    use yunpian;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function test()
    {
    
       dd($this->request->cookie());
    }

}
