<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: AuthMenuController.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Friday, 17th December 2021 6:11:21 pm
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Http\Controllers\Admin;

use app\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Models\Admin\AdminModel;
use App\Models\Admin\AuthMenuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class AuthMenuController extends Controller
{
    /**
     * __construct
     *
     * @param  mixed $request
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * 登录成功后 首页入口
     *
     * @return void
     */
    public function index()
    {
        return view('admin.authmenu.index', ['admin_name' => (new AdminModel())->getName() ?? '昵称' ]);
    }

    /**
     * 添加菜单
     *
     * @return void
     */
    public function addAuthMenu()
    {
        $request = $this->request->all();
        $validator = Validator::make($request, [
            'p_id' => 'required',
            'title' => 'required',
            'auth_name' => 'required',
            'icon' => 'required',
            'href' => 'required',
        ], );
        if ($validator->fails()) {
            return self::json_fail();
        }
        try {
            if ((new AuthMenuModel($request))->createAuthMenu()) {
                return self::json_return([], '添加成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    /**
     * 清除系统缓存
     *
     * @return void
     */
    public function clear()
    {
        Cache::flush();
        return self::json_success([], '缓存已清除');
    }

    /**
     * 系统菜单首页
     *
     * @return void
     */
    public function init()
    {
        return self::json((new AuthMenuModel())->menuInit());
    }
}
