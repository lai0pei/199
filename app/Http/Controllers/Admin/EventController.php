<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\EventModel;
use App\Models\Admin\EventTypeModel;
use Illuminate\Http\Request;

class EventController extends Controller
{
    //

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function event(){
        $data = (new EventModel($this->request->all()))->getEventBy();
        $types = (new EventTypeModel())->getAllType();
        return view('admin.event.add_event',['type'=>$data, 'event'=>$types]);
    }
}
