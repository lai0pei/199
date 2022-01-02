<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\ConfigModel;
use App\Http\Controllers\Index\util\yunpian;
use App\Http\Controllers\Index\util\juhe;
use LogicException;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Index\util\generateCode;

class TestController extends Controller
{
  
    use juhe;
    use generateCode;
    use yunpian;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function test(){
      session()->put(1,1);
      session()->put(2,2);
      dd(session()->get(2));

    }
  
}
