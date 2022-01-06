<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use LogicException;

class UploadLogoController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function logoUpload()
    {
        $request = $this->request;
        $logo = config('filesystems.logo');
        $size = config('admin.logo_size');
        $file = $request->file('file');
        try {
            $this->checkSize($file, $size);

            $time = Carbon::now()->format('Y-m-d');

            $path = $logo . '/' . $time;

            if (! Storage::exists($path)) {
                Storage::makeDirectory($path, 7777, true, true);
            }

            $url = Storage::disk('public')->put($path, $this->request->file('file'));
            $result['code'] = self::FAIL;
            $result['msg'] = '上传成功';
            $result['data'] = ['src' => asset('storage/' . $url)];
        } catch (LogicException $e) {
            $result['code'] = self::FAIL;
            $result['msg'] = $e->getMessage();
            $result['data'] = [];
            return self::json($result);
        }

        return response()->json($result);
    }

    public function cruoselConfirm()
    {
        $request = $this->request;
        $crousel = config('filesystems.crousel');
        $size = config('admin.crousel_size');
        $file = $request->file('file');
        try {
            $this->checkSize($file, $size);

            $result = $this->storePic($file, $crousel);
        } catch (LogicException $e) {
            $result['code'] = self::FAIL;
            $result['msg'] = $e->getMessage();
            $result['data'] = [];
            return self::json($result);
        }

        return response()->json($result);
    }

    public function btnConfirm()
    {
        $request = $this->request;
        $logo = config('filesystems.logo');
        $size = config('admin.button_size');
        $file = $request->file('file');
        try {
            $this->checkSize($file, $size);

            $result = $this->storePic($file, $logo);
        } catch (LogicException $e) {
            $result['code'] = self::FAIL;
            $result['msg'] = $e->getMessage();
            $result['data'] = [];
            return self::json($result);
        }

        return self::json($result);
    }

    private function checkSize($file, $config)
    {
        [$width, $height] = getimagesize($file);

        if ($width !== (int) $config['width']) {
            throw new LogicException('需图片宽度等于 ' . $config['width'] . 'px, 高度等于' . $config['height'] . 'px');
        }
        if ($height !== (int) $config['height']) {
            throw new LogicException('需图片宽度等于 ' . $config['width'] . 'px, 高度等于' . $config['height'] . 'px');
        }
    }

    private function storePic($file, $config)
    {
        $time = Carbon::now()->format('Y-m-d');

        $path = $config . '/' . $time;

        if (! Storage::exists($path)) {
            Storage::makeDirectory($path, 7777, true, true);
        }

        $url = Storage::disk('public')->put($path, $file);
        $result['code'] = self::FAIL;
        $result['msg'] = '上传成功';
        $result['data'] = ['src' => asset('storage/' . $url)];
        return $result;
    }
}
