<?php
/*
 * |-----------------------------------------------------------------------------------------------------------
 * | Laravel 8 + PHP 8.0 + LayUI + 基于CMS 开发
 * |-----------------------------------------------------------------------------------------------------------
 * | 开发者: 云飞
 * |-----------------------------------------------------------------------------------------------------------
 * | 文件: AdminController.php
 * |-----------------------------------------------------------------------------------------------------------
 * | 项目: VIP活动申请
 * |-----------------------------------------------------------------------------------------------------------
 * | 创建时间: Sunday, 19th December 2021 6:22:21 pm
 * |-----------------------------------------------------------------------------------------------------------
 * | Copyright 2021 - 2025
 * |-----------------------------------------------------------------------------------------------------------
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AdminModel;
use App\Exceptions\LogicException;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    
    /**
     * __construct
     *
     * @param  mixed $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function person(){
        return view('admin.person.person');
    }

    public function listAdmin(){

        $data = (new AdminModel($this->request->all()))->listAdmin();
        $result['code'] = self::FAIL;
         $result['msg'] = '操作成功';
         $result['data'] = $data['data'];
         $result['count'] = $data['count'];
    
         return response()->json($result);
    }

    public function addPerson(){
        return view('admin.person.addperson');
    }

    public function addNewAdmin(){
        try {
            if ((new AdminModel($this->request->all()))->addAdmin()) {
                return self::json_return([],'添加成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([],$e->getMessage());
        }
      
    }

    public function editPerson(){
      
        $data = (new AdminModel($this->request->all()))->editAdmin();
        return view('admin.person.editperson', ['edit_admin'=>$data[0]]);
    }

    public function saveAdmin(){
        try {
            if ((new AdminModel($this->request->all()))->saveAdmin()) {
                return self::json_return([],'编辑成功');
            }
        } catch (LogicException $e) {
            return self::json_fail([],$e->getMessage());
        }
    }
}
