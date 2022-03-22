<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultConfig extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $config = [
            ['name' => 'smsConfig', 'title' => '短信配置', 'json_data' => "", 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'bulkDeny', 'title' => '拒绝回复', 'json_data' => "", 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'bulkPass', 'title' => '拒绝通过', 'json_data' => "", 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'linkConfig', 'title' => '链接管理', 'json_data' => "", 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'gameConfig', 'title' => '游戏链接', 'json_data' => "", 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'announcement', 'title' => '公告', 'json_data' => "", 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'site', 'title' => '网站管理', 'json_data' => "", 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'logo', 'title' => '前台图片', 'json_data' => "", 'created_at' => now(), 'updated_at' => now()],

        ];
        foreach ($config as $configValue) {
            DB::table('configs')->insert($configValue);
        }
    }
}
