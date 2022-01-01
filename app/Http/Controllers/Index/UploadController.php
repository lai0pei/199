<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    //

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function uploadImage()
    {
        $userApply = config("filesystems.userApply");

        $time = Carbon::now()->format("Y-m-d");

        $path = $userApply . '/' . $time;

        if (!Storage::exists($path)) {
            Storage::makeDirectory($path, 7777, true, true);
        }
        $url = Storage::disk('public')->put($path, $this->request->file('applyUser'));
        $result['code'] = self::SUCCESS;
        $result['msg'] = '上传成功';
        $result['data'] = ['src' => asset('storage/' . $url),'form_id' => $this->request->input('form_id')];

        return response()->json($result);

    }
}
