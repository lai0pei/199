<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: ConfigsController.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Sunday, 19th December 2021 6:22:52 pm
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ConfigModel;
use Illuminate\Http\Request;

class ConfigsController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function refuse()
    {
        $data = (new ConfigModel($this->request->all()))->getConfig('bulkDeny');
        return view('admin.bulk_refuse.refuse', ['refuse' => $data]);
    }

    public function refuseSave()
    {
        return self::json_success((new ConfigModel($this->request->all()))->saveConfig('bulkDeny', '更新了 后台 批量拒绝回复内容'));
    }

    public function pass()
    {
        $data = (new ConfigModel($this->request->all()))->getConfig('bulkPass');
        return view('admin.bulk_pass.pass', ['pass' => $data]);
    }

    public function passSave()
    {
        return self::json_success((new ConfigModel($this->request->all()))->saveConfig('bulkPass', '更新了 后台 批量通过回复内容'));
    }

    public function link()
    {
        $data = (new ConfigModel($this->request->all()))->getConfig('linkConfig');
        return view('admin.link.link', ['link' => $data]);
    }

    public function linkSave()
    {
        return self::json_success((new ConfigModel($this->request->all()))->saveConfig('linkConfig', '更新了 前台底部4个链接'));
    }

    public function game()
    {
        $data = (new ConfigModel($this->request->all()))->getConfig('gameConfig');
        return view('admin.game.game', ['game' => $data]);
    }

    public function gameSave()
    {
        return self::json_success((new ConfigModel($this->request->all()))->saveConfig('gameConfig', '更新了游戏列表链接'));
    }

    public function announcement()
    {
        $data = (new ConfigModel($this->request->all()))->getConfig('accouncement');
        return view('admin.announcement.announcement', ['config' => $data]);
    }

    public function announcementSave()
    {
        return self::json_success((new ConfigModel($this->request->all()))->saveConfig('accouncement', '更新了前台公告'));
    }
}
