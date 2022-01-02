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

use App\Http\Controllers\Controller;
use App\Models\Index\ApplyModel;
use App\Models\Index\ConfigModel;
use App\Models\Index\EventTypeModel;
use App\Models\Index\FormModel;
use App\Models\Index\SmsApplyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use LogicException;
use Mews\Captcha\Facades\Captcha;

class IndexController extends Controller
{

    /**
     * __construct
     *
     * @param  mixed $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $eventModel = new EventTypeModel();
        $configModel = new ConfigModel();
        $applyModel = new ApplyModel();
        $event = $eventModel->getAllEventList();
        $footer = $configModel->getConfig('linkConfig');
        $announcement = $configModel->getConfig('accouncement');
        $applyList = $applyModel->getApplyList();
        return Inertia::render('index', ['event' => $event, 'footer' => $footer, 'announcement' => $announcement, 'applyList' => $applyList]);
    }

    /**
     * getFormById
     *
     * @return void
     */
    public function getFormById()
    {
        $request = $this->request;
        $form = (new FormModel($request->all()))->getFormById();
        return self::json_success($form);
    }

    /**
     * applyForm
     *
     * @return void
     */
    public function applyForm()
    {
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'captcha' => 'required',
            'username' => 'required',
            'eventId' => 'required',
        ], );
        try {

            if ($validator->fails()) {
                throw new LogicException('请求数据不正确');
            }

            if (!captcha_check($input['captcha'])) {
                throw new LogicException('验证码不正确');
            }
            if (1 == $input['needSms'] && !checkSmsCode($input['mobile'], $input['smsNumber'])) {
                throw new LogicException('短信验证码不正确');
            }

            if(1 == $input['isSms']){
                $smsModel = new SmsApplyModel($input);
                $smsModel->smsForm();
            }else{
                $applyModel = new ApplyModel($input);

                $applyModel->applyForm();
            }

            return self::json_success([], '申请成功!');
        } catch (LogicException $e) {
            return self::json_fail([], $e->getMessage());
        }

    }

    /**
     * captcha
     *
     * @return void
     */
    public function captcha()
    {
        return Captcha::src('index');
    }

}
