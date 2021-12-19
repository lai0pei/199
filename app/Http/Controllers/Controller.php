<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: Controller.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Thursday, 16th December 2021 1:58:15 pm
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */



namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    const SUCCESS = 1;

    const FAIL = 0;

    /**
     * ajax_return
     * 
     * @param  mixed $status
     * @param  mixed $msg
     * @param  mixed $data
     * @return void
     */
    protected static function json_return($status = self::SUCCESS, $msg = '', $data = []){
         $result['code'] = $status;
         $result['message'] = $msg;
         $reuslt['data'] = $data;
         
         return response()->json($result);
    }
    
    /**
     * success
     *
     * @param  mixed $msg
     * @param  mixed $data
     * @return void
     */
    protected static function json_success($msg='操作成功',$data=[]){
         $result['code'] = self::SUCCESS;
         $result['message'] = $msg;
         $reuslt['data'] = $data;
         
         return response()->json($result);
    }
    
    /**
     * fail
     *
     * @param  mixed $msg
     * @param  mixed $data
     * @return void
     */
    protected static function json_fail($msg='操作失败',$data=[]){
        $result['code'] = self::FAIL;
        $result['message'] = $msg;
        $reuslt['data'] = $data;
    
        return response()->json($result);
    }
    
    /**
     * json
     *
     * @param  mixed $data
     * @return void
     */
    protected static function json($data = []){
        return response()->json($data);
    }
}
