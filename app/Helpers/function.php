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
        Cache::put($key, $permission, now()->addMinutes(60));
    }

    if (in_array($name, $permission)) {
        return 1;
    }
    return 0;
}

function checkSmsCode($mobile, $code)
{  
    return (int) Cache::get($mobile) === (int) $code;
}

function stripUrl($data){
    if($data === ''){
        return '';
    }
    $url = url("/");  
    return str_replace($url,'',$data);
}

