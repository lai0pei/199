<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MobileController extends Controller
{
    //

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function mobile(){
        return view('admin.mobile.mobile');
    }
}
