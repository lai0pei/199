<?php

use App\Models\Admin\AuthMenuModel;
use Illuminate\Support\Facades\Cache;

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
        Cache::put($key, $permission, now()->addMinute(60));
    }

    if (in_array($name, $permission)) {
        return 1;
    }
    return 0;
}

function checkSmsCode($mobile, $code)
{
    return session()->get($mobile) === $code;
}
