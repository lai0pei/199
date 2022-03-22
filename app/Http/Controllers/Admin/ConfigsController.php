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

use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Models\Admin\ConfigModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConfigsController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->validator = 'required|JSON';
    }

    public function refuse()
    {
        $data = (new ConfigModel())->getConfig('bulkDeny');
        return view('admin.bulk_refuse.refuse', ['refuse' => $data]);
    }

    public function refuseSave()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'data' => $this->validator,
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            return self::json_success((new ConfigModel($input))->saveConfig('bulkDeny', '更新了 后台 批量拒绝回复内容'));
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function pass()
    {
        $data = (new ConfigModel())->getConfig('bulkPass');
        return view('admin.bulk_pass.pass', ['pass' => $data]);
    }

    public function passSave()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'data' => $this->validator,
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            return self::json_success((new ConfigModel($input))->saveConfig('bulkPass', '更新了 后台 批量通过回复内容'));
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function link()
    {
        $data = (new ConfigModel())->getConfig('linkConfig');
        return view('admin.link.link', ['link' => $data]);
    }

    public function linkSave()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'data' => $this->validator,
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            return self::json_success((new ConfigModel($input))->saveConfig('linkConfig', '更新了 前台底部4个链接'));
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function game()
    {
        $data = (new ConfigModel())->getConfig('gameConfig');
        return view('admin.game.game', ['game' => $data]);
    }

    public function gameSave()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'data' => $this->validator,
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            return self::json_success((new ConfigModel($input))->saveConfig('gameConfig', '更新了游戏列表链接'));
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    public function announcement()
    {
        $data = (new ConfigModel())->getConfig('announcement');
        return view('admin.announcement.announcement', ['config' => $data]);
    }

    public function announcementSave()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'data' => $this->validator,
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException(self::MSG);
            }
            
            return self::json_success((new ConfigModel($input))->saveConfig('announcement', '更新了前台公告'));
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }
}
