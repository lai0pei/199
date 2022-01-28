<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class BAdminAddEventTest extends TestCase
{   
    public function __construct()
    {
        $this->prefix = config('admin.url_prefix');
        $this->add = '/'.$this->prefix.'/add_event';
        $this->mani = '/'.$this->prefix.'/mani_event';
        $this->delete = '/'.$this->prefix.'/delete_event';
        $this->upload = '/'.$this->prefix.'/uploadPhoto';
        $this->editor = '/ueditor';
    
    }
    
  
    public function test_admin_add_event_index()
    {
        $this->jsonGet( $this->add . '/-1', 0);
    }

    public function test_admin_add_event_index_with_negativeId()
    {
        $data = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];
        $this->jsonGet( $this->add . '/-100', 1, $data);
    }

    public function test_admin_save_event_index()
    {
        $this->jsonGet( $this->add . '/1', 0);
    }

    public function test_admin_save_event_index_with_emptyData()
    {
        $this->jsonGet( $this->add . '/1000', 0);
    }

    public function test_admin_add_event_mani()
    {
        $data['data'] = [
            'id' => -1,
            'name' => 'new event',
            'type_id' => '1',
            'type_pic' => 'pic_url',
            'start' => '2022-01-16 05:46:56',
            'end' => '2022-01-16 05:46:56',
            'is_daily' => 1,
            'daily_limit' => 1,
        ];
        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];

        $this->jsonPost( $this->mani, $data, $res);
    }

    public function test_admin_add_event_mani_with_invalidInput()
    {
        $data['data'] = [
            'name' => 'new event',
            'type_id' => '1',
            'type_pic' => 'pic_url',
            'start' => '2022-01-16 05:46:56',
            'end' => '2022-01-16 05:46:56',
        ];
        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost( $this->mani, $data, $res);
    }

    public function test_admin_save_event_mani()
    {
        $data['data'] = [
            'id' => 2,
            'name' => 'new event 2',
            'type_id' => '1',
            'type_pic' => 'pic_url',
            'start' => '2022-01-16 05:46:56',
            'end' => '2022-01-16 05:46:56',
        ];
        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];

        $this->jsonPost( $this->mani, $data, $res);
    }

    public function test_admin_save_event_mani_with_emptyData()
    {
        $data['data'] = [
            'id' => 200,
            'name' => 'new event 5',
            'type_id' => '1',
            'type_pic' => 'pic_url',
            'start' => '2022-01-16 05:46:56',
            'end' => '2022-01-16 05:46:56',
        ];

        $res = [
            'code' => 0,
            'msg' => '保存失败',
            'data' => [],
        ];

        $this->jsonPost( $this->mani, $data, $res);
    }

    public function test_admin_save_event_mani_with_sms_on()
    {
        $data['data'] = [
            'id' => 2,
            'name' => 'new event 3',
            'type_id' => '1',
            'type_pic' => 'pic_url',
            'start' => '2022-01-16 05:46:56',
            'end' => '2022-01-16 05:46:56',
            'is_sms' => 'on',
            'start' => '2022-01-16 05:46:56',
            'end' => '2022-01-16 05:46:56',
            'is_daily' => 'on',
            'daily_limit' => 1,
        ];

        $res = [
            'code' => 1,
            'msg' => '操作成功',
            'data' => [],
        ];

        $this->jsonPost( $this->mani, $data, $res);
    }

    public function test_event_delete(){
        $data = [
            'id' => 1,
        ];
        $res = [
            'code' => 0,
            'msg' => '固定活动不能删除!',
            'data' => [],
        ];
        $this->jsonPost($this->delete, $data, $res);
    }

    public function test_event_delete_with_invalidInput(){
        $data = [
 
        ];
        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];
        $this->jsonPost($this->delete, $data, $res);
    }
    public function test_event_delete_with_negative_input(){
        $data = [
            'id' => -1,
        ];
        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];
        $this->jsonPost($this->delete, $data, $res);
    }

    public function test_event_delete_with_empty_data(){
        $data = [
            'id' => 100,
        ];
        $res = [
            'code' => 0,
            'msg' => '删除失败',
            'data' => [],
        ];
        $this->jsonPost($this->delete, $data, $res);
    }

    public function test_admin_event_pic_upload_pass()
    {

        $file = UploadedFile::fake()->image('test.jpg', '1690', '430');

        $data = [
            'file' => $file,
        ];

        $res = [
            'code' => 0,
            'msg' => '上传成功',
        ];

        $this->jsonPost($this->upload, $data, $res);

    }

    public function test_admin_event_pic_upload_fail()
    {

        $file = UploadedFile::fake()->image('test.jpg', '100', '50');

        $data = [
            'file' => $file,
        ];

        $config = config('admin.event_size');
        $res = [
            'code' => 0,
            'msg' => '需图片宽度等于 ' . $config['width'] . 'px, 高度等于' . $config['height'] . 'px',
            'data' => [],
        ];

        $this->jsonPost($this->upload, $data, $res);

    }

    public function test_admin_event_ueditor_pic_upload()
    {

        $file = UploadedFile::fake()->image('test.jpg', '100', '50');

        $data = [
            'upfile' => $file,
        ];

        $res = [
            'state' => 'SUCCESS',
            'title' => 'test.jpg',
            'original' => 'test.jpg',
        ];

        $this->jsonPost($this->editor, $data, $res);

    }

}
