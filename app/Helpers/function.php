<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: function.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Tuesday, 4th January 2022 8:04:00 am
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2022 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

use App\Models\Admin\AuthMenuModel;
use Illuminate\Support\Facades\Cache;
use Spatie\ImageOptimizer\OptimizerChain;
use Spatie\ImageOptimizer\Optimizers\Jpegoptim;
use Spatie\ImageOptimizer\Optimizers\Pngquant;

function checkAuth($name = '')
{
    $key = 'permission_' . session('user_id');
    $permission = Cache::get($key);

    if (empty($permission)) {
        $data = session('permission');
        if (empty($data)) {
            (new AuthMenuModel())->setPermission();
            $data = session('permission');
        }
        $permission = array_column($data, 'name');
        Cache::put($key, $permission, now()->addMinutes(60));
    }

    if (in_array($name, $permission)) {
        return 1;
    }
    return 0;
}

function idAsKey($array, $key): array
{
    $res = [];
    if (! isset($array)) {
        return $res;
    }
    foreach ($array as $v) {
        $res[$v[$key]] = $v;
    }

    return $res;
}

function checkSmsCode($mobile, $code)
{   
    return (int) Cache::get($mobile) === (int) $code;
}

function stripUrl($data)
{
    if ($data === '') {
        return '';
    }
    $url = url('/');
    return str_replace($url, '', $data);
}

function optimizeImg($path)
{
    $optimize = (new OptimizerChain())
        ->addOptimizer(new Jpegoptim([
            '--strip-all',
            '--all-progressive',
        ]))

        ->addOptimizer(new Pngquant([
            '--force',
        ]));
    $optimize->optimize(public_path('storage/' . $path));
}
