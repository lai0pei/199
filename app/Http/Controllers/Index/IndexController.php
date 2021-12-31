<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: IndexController.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Monday, 27th December 2021 11:22:42 am
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Index\CommonController;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Index\ConfigModel;
use App\Models\Index\EventTypeModel;
use App\Models\Index\ApplyModel;
use App\Models\Index\FormModel;
use LogicException;

class IndexController extends CommonController
{
    //
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index() {
        $eventModel = new EventTypeModel();
        $configModel = new ConfigModel();
        $applyModel = new ApplyModel();
        $event = $eventModel->getAllEventList();
        $footer = $configModel->getConfig('linkConfig');
        $announcement = $configModel->getConfig('accouncement');
        $applyList = $applyModel->getApplyList();
        return Inertia::render('index',['event'=>$event, 'footer'=>$footer, 'announcement' => $announcement, 'applyList' => $applyList]);
    }


    public function getFormById(){
        $request = $this->request;
        $form = (new FormModel($request->all()))->getFormById();
        return self::json_success($form);
    }

    public function applyForm(){
        try{
        $request = $this->request;
        $applyModel = new ApplyModel($request->all());
        $applyModel->applyForm();
        return self::json_success([],$applyModel->getMessage());
        }catch (LogicException $e){
            return self::json_fail([],$applyModel->getMessage());
        }
        
    }
}
