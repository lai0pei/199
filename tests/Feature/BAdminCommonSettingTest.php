<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class BAdminCommonSettingTest extends TestCase
{
    const LOGO = '/6ucwfN@Bt/logo_upload';

    public function test_admin_upload()
    {

        $file = UploadedFile::fake()->image('test.jpg', '256', '71');

        $data = [
            'file' => $file,
        ];

        $this->uploadPost(self::LOGO, $data);

    }

    public function test_admin_upload_with_invalidFileName()
    {

        $file = UploadedFile::fake()->image('test.jpg', '256', '71');

        $data = [
            'invalid' => $file,
        ];

        $res = [
            'code' => 0,
            'msg' => self::MSG,
            'data' => [],
        ];

        $this->jsonPost(self::LOGO, $data, $res);

    }

    public function test_admin_upload_with_invalidSize()
    {

        $file = UploadedFile::fake()->image('test.jpg', '100', '50');

        $data = [
            'file' => $file,
        ];

        $config = config('admin.logo_size');
        $res = [
            'code' => 0,
            'msg' => '需图片宽度等于 ' . $config['width'] . 'px, 高度等于' . $config['height'] . 'px',
            'data' => [],
        ];

        $this->jsonPost(self::LOGO, $data, $res);

    }
}
