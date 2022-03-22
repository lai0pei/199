<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: UploadController.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Thursday, 23rd December 2021 4:13:18 pm
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Http\Controllers\Admin;

use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Models\Admin\MobileImModel;
use App\Models\Admin\SmsEventModel;
use App\Models\Admin\SmsImportModel;
use App\Models\Admin\UserApplyModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class UploadController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function importExcel()
    {
        try {
            Excel::import(new MobileImModel(), $this->request->file('file'));
            return self::json_success([], '导入成功');
        } catch (LogicException $e) {
            return self::json_fail([], $e);
        }
    }

    public function applyExport()
    {
        try {
            return Excel::download(new UserApplyModel(), '会员申请.csv');
        } catch (LogicException $e) {
            return self::json_fail([], $e);
        }
    }

    public function smsExport()
    {   
        $input = $this->request->all();
        $validator = Validator::make($input, [
            'id' => 'required|numeric|min:0',
        ], );
        try {
            if ($validator->fails()) {
                throw new LogicException('ID必须');
            }
            return Excel::download(new SmsEventModel(), '会员短信申请.csv');
        } catch (LogicException $logicException) {
            return self::json_fail([], $logicException);
        }
    }

    public function smsImportMani()
    {   
     
        try {
            $format = $this->request->file->extension();           
            Excel::import(new SmsImportModel($this->request->all()), $this->request->file('file'), $format);
            return self::json_success([], '导入成功');
        } catch (LogicException $e) {
            return self::json_fail([], $e);
        }
    }

    public function ueditor()
    {
        $config = File::get(public_path(config('admin.ueditor_json')));
        if (!empty($config)) {
            $schemeAndHttpHost = request()->getSchemeAndHttpHost();
            $replaced = str_replace('#url#', $schemeAndHttpHost, $config);
            $replaced = str_replace('#imgPath#', 'storage', $replaced);
            return self::json(json_decode($replaced, true, 512, JSON_THROW_ON_ERROR));
        }
    }
    public function ueditorUpload()
    {
        $result = [];
        $common = config('filesystems.common');
        $request = $this->request;
        try {
            $file = $request->file('upfile');
            if ($file == null){
                return self::json_fail([],'图片错误');
            }     
            $name = $file->getClientOriginalName();
            $time = Carbon::now()->format('Y-m-d');
            $path = $common . '/' . $time;
            if (!Storage::exists($path)) {
                Storage::makeDirectory($path);
            }
            $url = Storage::disk('public')->put($path, $file);
            optimizeImg($url);
            $result['state'] = 'SUCCESS';
            $result['url'] = '/storage/' . $url;
            $result['title'] = $name;
            $result['original'] = $name;
        } catch (LogicException $logicException) {
            Log::channel('upload')->error($logicException->getMessage());
            return self::json_fail([]);
        }
        return self::json($result);
    }
}
