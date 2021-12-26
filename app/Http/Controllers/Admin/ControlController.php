<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ControlController extends Controller
{
    //

    public function control(){
        return view('admin.control.control');
    }
}
