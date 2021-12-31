<?php

namespace App\Http\Controllers\Index;

use Illuminate\Routing\Controller as IndexController;
use Illuminate\Http\Request;

class CommonController extends IndexController
{
    
    const SUCCESS = 1;

    const FAIL = 0;

    /**
     * success
     *
     * @param  mixed $msg
     * @param  mixed $data
     * @return void
     */
    protected static function json_success($data=[],$msg='操作成功'){

        $result['code'] = self::SUCCESS;
        $result['msg'] = $msg;
        $result['data'] = $data;
        
        return response()->json($result);
   }

     /**
     * fail
     *
     * @param  mixed $msg
     * @param  mixed $data
     * @return void
     */
    protected static function json_fail($data=[],$msg='操作失败'){
        $result['code'] = self::FAIL;
        $result['msg'] = $msg;
        $result['data'] = $data;
    
        return response()->json($result);
    }
}
