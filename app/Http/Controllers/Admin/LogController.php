<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\LogModel;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function log()
    {
        $data = (new LogModel($this->request->all()))->logType();
        return view('admin.log.log', ['data' => $data]);
    }

    public function getLog()
    {
        $data = (new LogModel($this->request->all()))->log();

        $result['code'] = self::FAIL;
        $result['msg'] = '操作成功';
        $result['data'] = $data['data'];
        $result['count'] = $data['count'];

        return response()->json($result);
    }

    public function detailLog()
    {
        $log = (new LogModel($this->request->route()->parameters()))->detailLog();
        return view('admin.log.logcheck', ['log' => $log]);
    }
}
