<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class TestController extends Controller
{
    public function test(){
        $path = config("filesystems.userApply");
        public_path('storage');
        Carbon::now()->format('Y-m-d');
        Storage::directories($path);
        Storage::makeDirectory($path);
        is_dir(config("filesystems.disks.public.url").'/'.$path);
        return self::json_success(Storage::exists($path));
    }
}
