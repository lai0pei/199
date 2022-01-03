<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: ControlController.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Monday, 3rd January 2022 8:01:16 am
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2022 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ControlModel;
use App\Models\Admin\EventModel;
use App\Models\Admin\MobileModel;
use App\Models\Admin\SmsEventModel;
use App\Models\Admin\UserApplyModel;

class ControlController extends Controller
{
    public function control()
    {
        $smsModel = new SmsEventModel();
        $eventModel = new EventModel();
        $userModel = new UserApplyModel();
        $mobileModel = new MobileModel();
        $totalMember = $smsModel->getNewMember();
        $totalEventMember = $eventModel->getTotalNumber();
        $today = $smsModel->getTodayMember();
        $totalEvent = $eventModel->getTodayEvent();
        $userAppr = $userModel->userAppr();
        $smsAppr = $smsModel->smsAppr();
        $vip = $mobileModel->getCount();
        return view('admin.control.control', ['total' => $totalMember, 'today' => $today, 'event' => $totalEventMember, 'todayEvent' => $totalEvent, 'userAppr' => $userAppr, 'smsAppr' => $smsAppr, 'vip' => $vip]);
    }

    public function getChart()
    {
        return self::json_success((new ControlModel())->getChart());
    }
}
