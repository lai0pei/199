<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: MobileController.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Tuesday, 4th January 2022 8:04:00 am
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2022 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Http\Controllers\Admin;

use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Models\Admin\MobileModel;
use Illuminate\Http\Request;

class MobileController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * 默认页面
     *
     * @return view
     */
    public function mobile()
    {
        return view('admin.mobile.mobile');
    }

    /**
     * 手机号列表
     *
     * @return json
     */
    public function getMobile()
    {
        $data = (new MobileModel($this->request->all()))->getMobile();

        $result['code'] = self::FAIL;
        $result['msg'] = '操作成功';
        $result['data'] = $data['data'];
        $result['count'] = $data['count'];

        return response()->json($result);
    }

    /**
     * 删除号码
     *
     * @return json
     */
    public function deleteMobile()
    {
        try {
            if ((new MobileModel($this->request->all()))->deleteMobile()) {
                return self::json_success([], '操作成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }
    }

    /**
     * 添加页面
     *
     * @return view
     */
    public function addMobile()
    {
        return view('admin.mobile.addmobile');
    }

    /**
     * 添加功能
     *
     * @return void
     */
    public function maniMobile()
    {
        return self::json_success((new MobileModel($this->request->all()))->maniMobile(), '添加、成功');
    }

    /**
     * 一键清空
     *
     * @return void
     */
    public function oneClick()
    {
        (new MobileModel($this->request->all()))->oneClick();
        return self::json_success([], '操作成功');
    }
}
