<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultMenu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $config = [
            1 => ['id' => 2, 'p_id' => 0, 'title' => '活动管理', 'auth_name' => 'event_management', 'icon' => '', 'href' => '/event_management', 'sort' => 1, 'created_at' => now(), 'updated_at' => now()],
            2 => ['id' => 3, 'p_id' => 0, 'title' => '系统管理', 'auth_name' => 'system_management', 'icon' => '', 'href' => '/system_management', 'sort' => 2, 'created_at' => now(), 'updated_at' => now()],

            3 => ['id' => 4, 'p_id' => 2, 'title' => '我的活动', 'auth_name' => 'my_events', 'icon' => 'fa fa-money', 'href' => '', 'sort' => 0, 'created_at' => now(), 'updated_at' => now()],
            4 => ['id' => 5, 'p_id' => 4, 'title' => '创建活动', 'auth_name' => 'add_event', 'icon' => 'fa fa-plus-circle', 'href' => '/add_event', 'sort' => 0, 'created_at' => now(), 'updated_at' => now()],
            5 => ['id' => 6, 'p_id' => 4, 'title' => '活动列表', 'auth_name' => 'event_lists', 'icon' => 'fa fa-list', 'href' => '/event_lists', 'sort' => 1, 'created_at' => now(), 'updated_at' => now()],

            6 => ['id' => 7, 'p_id' => 2, 'title' => 'VIP用户管理', 'auth_name' => 'vip_users', 'icon' => 'fa fa-user-secret', 'href' => '', 'sort' => 1, 'created_at' => now(), 'updated_at' => now()],
            7 => ['id' => 8, 'p_id' => 7, 'title' => '手机号管理', 'auth_name' => 'mobile_management', 'icon' => 'fa fa-mobile', 'href' => '/mobile_management', 'sort' => 0, 'created_at' => now(), 'updated_at' => now()],
            8 => ['id' => 9, 'p_id' => 7, 'title' => '会员申请记录', 'auth_name' => 'user_apply', 'icon' => 'fa fa-reply-all', 'href' => '/user_apply', 'sort' => 1, 'created_at' => now(), 'updated_at' => now()],
            9 => ['id' => 10, 'p_id' => 7, 'title' => '用户短信申请', 'auth_name' => 'sms_apply', 'icon' => 'fa fa-comments-o', 'href' => '/sms_apply', 'sort' => 2, 'created_at' => now(), 'updated_at' => now()],

            10 => ['id' => 11, 'p_id' => 2, 'title' => '基本配置', 'auth_name' => 'basic_settings', 'icon' => 'fa fa-cog', 'href' => '', 'sort' => 2, 'created_at' => now(), 'updated_at' => now()],
            11 => ['id' => 12, 'p_id' => 11, 'title' => '批量拒绝回复', 'auth_name' => 'bulk_refuse', 'icon' => 'fa fa-exclamation-triangle', 'href' => '/bulk_refuse', 'sort' => 0, 'created_at' => now(), 'updated_at' => now()],
            12 => ['id' => 13, 'p_id' => 11, 'title' => '批量通过回复', 'auth_name' => 'bulk_pass', 'icon' => 'fa fa-check', 'href' => '/bulk_pass', 'sort' => 1, 'created_at' => now(), 'updated_at' => now()],
            13 => ['id' => 14, 'p_id' => 11, 'title' => '链接管理', 'auth_name' => 'link_management', 'icon' => 'fa fa-link', 'href' => '/link_management', 'sort' => 2, 'created_at' => now(), 'updated_at' => now()],
            14 => ['id' => 15, 'p_id' => 11, 'title' => '游戏管理', 'auth_name' => 'game_management', 'icon' => 'fa fa-gamepad', 'href' => '/game_management', 'sort' => 3, 'created_at' => now(), 'updated_at' => now()],
            15 => ['id' => 16, 'p_id' => 11, 'title' => '公告通知', 'auth_name' => 'announcement', 'icon' => 'fa fa-bullhorn', 'href' => '/announcement', 'sort' => 3, 'created_at' => now(), 'updated_at' => now()],

            16 => ['id' => 17, 'p_id' => 3, 'title' => '人员管理', 'auth_name' => 'admin_management', 'icon' => 'fa fa-user', 'href' => '', 'sort' => 3, 'created_at' => now(), 'updated_at' => now()],
            17 => ['id' => 18, 'p_id' => 17, 'title' => '管理员', 'auth_name' => 'person', 'icon' => 'fa fa-user-plus', 'href' => '/person', 'sort' => 0, 'created_at' => now(), 'updated_at' => now()],
            18 => ['id' => 19, 'p_id' => 17, 'title' => '管理组', 'auth_name' => 'admin_group', 'icon' => 'fa fa-users', 'href' => '/admin_group', 'sort' => 1, 'created_at' => now(), 'updated_at' => now()],
            19 => ['id' => 20, 'p_id' => 17, 'title' => '修改密码', 'auth_name' => 'change_password', 'icon' => 'fa fa-key', 'href' => '/change_password', 'sort' => 2, 'created_at' => now(), 'updated_at' => now()],

            20 => ['id' => 21, 'p_id' => 3, 'title' => '日志与权限', 'auth_name' => 'log', 'icon' => 'fa fa-crosshairs', 'href' => '', 'sort' => 5, 'created_at' => now(), 'updated_at' => now()],
            21 => ['id' => 22, 'p_id' => 21, 'title' => '系统日志', 'auth_name' => 'log', 'icon' => 'fa fa-history', 'href' => '/log', 'sort' => 5, 'created_at' => now(), 'updated_at' => now()],
            22 => ['id' => 23, 'p_id' => 21, 'title' => '所有权限', 'auth_name' => 'auth_permission', 'icon' => 'fa fa-user-circle', 'href' => '/auth_permission', 'sort' => 4, 'created_at' => now(), 'updated_at' => now()],

            23 => ['id' => 24, 'p_id' => 3, 'title' => '配置', 'auth_name' => 'log', 'icon' => 'fa fa-sliders', 'href' => '', 'sort' => 5, 'created_at' => now(), 'updated_at' => now()],
            24 => ['id' => 25, 'p_id' => 24, 'title' => '公共配置', 'auth_name' => 'common_settings', 'icon' => 'fa fa-wrench', 'href' => '/common_settings', 'sort' => 8, 'created_at' => now(), 'updated_at' => now()],
            25 => ['id' => 26, 'p_id' => 24, 'title' => '短信配置', 'auth_name' => 'sms_config', 'icon' => 'fa fa-commenting', 'href' => '/sms_config', 'sort' => 6, 'created_at' => now(), 'updated_at' => now()],
            26 => ['id' => 27, 'p_id' => 24, 'title' => '允许IP', 'auth_name' => 'allow_ip', 'icon' => 'fa fa-server', 'href' => '/allow_ip', 'sort' => 7, 'created_at' => now(), 'updated_at' => now()],

            27 => ['id' => 28, 'p_id' => 4, 'title' => '活动类型', 'auth_name' => 'event_type', 'icon' => 'fa fa-object-group', 'href' => '/event_type', 'sort' => 1, 'created_at' => now(), 'updated_at' => now()],     
            
        ];

        foreach ($config as $configValue) {
            DB::table('auth_menu')->insert($configValue);
        }
    }
}
