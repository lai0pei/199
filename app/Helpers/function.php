<?php
use Illuminate\Support\Facades\Cache;
 function checkAuth($name = ""){

    $key = 'permission_' . session('user_id');
    $permission = Cache::get($key);
    if(empty($permission)){
        $data = session('permission');
        $permission = array_column($data,'name');
        Cache::put($key, $permission, now()->addMinute(60));
    }      
  
    if(in_array($name,$permission)){
        return 1;
    }else{
        return 0;
    }
}
?>