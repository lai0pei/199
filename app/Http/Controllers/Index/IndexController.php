<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Index\CommonController;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Index\ConfigModel;
use App\Models\Index\EventTypeModel;
use App\Models\Index\ApplyModel;

class IndexController extends CommonController
{
    //
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index(){
        $eventModel = new EventTypeModel();
        $configModel = new ConfigModel();
        $applyModel = new ApplyModel();
        $event = $eventModel->getAllEventList();
        $footer = $configModel->getConfig('linkConfig');
        $announcement = $configModel->getConfig('accouncement');
        $applyList = $applyModel->getApplyList();
        return Inertia::render('index',['event'=>$event, 'footer'=>$footer, 'announcement' => $announcement, 'applyList' => $applyList]);
    }
}
