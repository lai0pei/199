<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\MobileModel;
use Maatwebsite\Excel\Facades\Excel;

class UploadController extends Controller
{
    //
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
        $path = config("filesystems.path");
        $url = Storage::disk('public')->put($path, $this->request->file('file'));
        $result['code'] = self::FAIL;
        $result['msg'] = '上传成功';
        $result['data'] = ['src' => asset('storage/' . $url)];

        return response()->json($result);

    }

    public function importExcel(){
           $res = Excel::import(new MobileModel(), $this->request->file('file'));
         die;
            return back();
    }

 
    public function exportExcel() 
    {
        return Excel::download(new UsersExport, 'users-collection.xlsx');
    }
}
