<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Index\CommonController;
use Inertia\Inertia;
use Illuminate\Http\Request;

class IndexController extends CommonController
{
    //
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index(){
        return Inertia::render('index');
    }

    public function navLink(){
     return response()->json('hi');
    }
}
