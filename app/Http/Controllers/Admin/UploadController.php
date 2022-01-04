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

use App\Http\Controllers\Controller;
use App\Models\Admin\MobileImExModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use LogicException;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;

class UploadController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * eventPhotoUpload
     *
     * @return void
     */
    public function eventPhotoUpload()
    {
        $event = config('filesystems.event');

        $time = Carbon::now()->format('Y-m-d');

        $path = $event . '/' . $time;

        if (! Storage::exists($path)) {
            Storage::makeDirectory($path, 7777, true, true);
        }

        $url = Storage::disk('public')->put($path, $this->request->file('file'));
        $result['code'] = self::FAIL;
        $result['msg'] = '上传成功';
        $result['data'] = ['src' => asset('storage/' . $url)];

        return response()->json($result);
    }

    public function importExcel()
    {
        try {
            Excel::import(new MobileImExModel(), $this->request->file('file'));

            return self::json_success([], '导入成功');
        } catch (LogicException $e) {
            return self::json_fail([], $e);
        }
    }

    public function ueditor()
    
    {  
        $config = File::get(public_path('static/ueditor/config.json'));
        if(!empty($config)){
            $myDomain =  request()->getSchemeAndHttpHost();
            $replaced = str_replace('#url#',$myDomain,$config);
            return self::json($replaced);
        }
        return self::json_success([]);
    }
}
