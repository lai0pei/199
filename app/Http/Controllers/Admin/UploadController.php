<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    //
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function eventPhotoUpload(){
        $path = config("filesystems.path");
       $url =  Storage::putFile($path, $this->request->file('file')); 
       return self::json_success($url);
       
    }

 
    public function  eventContent(){
        $path = config("filesystems.path");
       $url =  Storage::putFile($path, $this->request->file('file')); 
       return self::json_success($url);
       
    }
}
