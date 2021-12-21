<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $config = [
            //管理员 操作
            0 => ['id' => 1, 'name' => 'admin_add', 'title' => '添加', 'grand_auth_id' => '3', 'parent_auth_id' => '17', 'current_auth_id' => '18', 'created_at' => now(), 'updated_at' => now()],
            1 => ['id' => 2, 'name' => 'admin_edit', 'title' => '编辑', 'grand_auth_id' => '3', 'parent_auth_id' => '17', 'current_auth_id' => '18', 'created_at' => now(), 'updated_at' => now()],
            2 => ['id' => 3, 'name' => 'admin_delete', 'title' => '删除', 'grand_auth_id' => '3', 'parent_auth_id' => '17', 'current_auth_id' => '18', 'created_at' => now(), 'updated_at' => now()],

            //管理组 操作
            3 => ['id' => 4, 'name' => 'group_add', 'title' => '添加', 'grand_auth_id' => '3', 'parent_auth_id' => '17', 'current_auth_id' => '19', 'created_at' => now(), 'updated_at' => now()],
            4 => ['id' => 5, 'name' => 'group_edit', 'title' => '编辑', 'grand_auth_id' => '3', 'parent_auth_id' => '17', 'current_auth_id' => '19', 'created_at' => now(), 'updated_at' => now()],
            5 => ['id' => 6, 'name' => 'group_delete', 'title' => '删除', 'grand_auth_id' => '3', 'parent_auth_id' => '17', 'current_auth_id' => '19', 'created_at' => now(), 'updated_at' => now()],
            6 => ['id' => 7, 'name' => 'group_auth', 'title' => '权限', 'grand_auth_id' => '3', 'parent_auth_id' => '17', 'current_auth_id' => '19', 'created_at' => now(), 'updated_at' => now()],

            //修改自己的密码 操作
            7 => ['id' => 8, 'name' => 'password_change', 'title' => '修改', 'grand_auth_id' => '3', 'parent_auth_id' => '17', 'current_auth_id' => '20', 'created_at' => now(), 'updated_at' => now()],

            //所有权限
            8 => ['id' => 9, 'name' => 'auth_list', 'title' => '查看', 'grand_auth_id' => '0', 'parent_auth_id' => '3', 'current_auth_id' => '25', 'created_at' => now(), 'updated_at' => now()],

            //系统日志
            9 => ['id' => 10, 'name' => 'log', 'title' => '查看', 'grand_auth_id' => '0', 'parent_auth_id' => '3', 'current_auth_id' => '21', 'created_at' => now(), 'updated_at' => now()],

            //短信配置
            10 => ['id' => 11, 'name' => 'sms_config', 'title' => '查看', 'grand_auth_id' => '0', 'parent_auth_id' => '3', 'current_auth_id' => '22', 'created_at' => now(), 'updated_at' => now()],
            11 => ['id' => 12, 'name' => 'sms_config_edit', 'title' => '编辑', 'grand_auth_id' => '0', 'parent_auth_id' => '3', 'current_auth_id' => '22', 'created_at' => now(), 'updated_at' => now()],

            //允许ip
            11 => ['id' => 12, 'name' => 'ip', 'title' => '修改', 'grand_auth_id' => '0', 'parent_auth_id' => '3', 'current_auth_id' => '23', 'created_at' => now(), 'updated_at' => now()],
            12 => ['id' => 13, 'name' => 'ip_edit', 'title' => '查看', 'grand_auth_id' => '0', 'parent_auth_id' => '3', 'current_auth_id' => '23', 'created_at' => now(), 'updated_at' => now()],

            //公共配置
            13 => ['id' => 14, 'name' => 'common', 'title' => '查看', 'grand_auth_id' => '0', 'parent_auth_id' => '3', 'current_auth_id' => '24', 'created_at' => now(), 'updated_at' => now()],
            14 => ['id' => 15, 'name' => 'common_edit', 'title' => '修改', 'grand_auth_id' => '0', 'parent_auth_id' => '3', 'current_auth_id' => '24', 'created_at' => now(), 'updated_at' => now()],

            //创建活动
            15 => ['id' => 16, 'name' => 'event_add', 'title' => '添加', 'grand_auth_id' => '2', 'parent_auth_id' => '4', 'current_auth_id' => '5', 'created_at' => now(), 'updated_at' => now()],

            //活动列表
            16 => ['id' => 17, 'name' => 'event_list', 'title' => '查看', 'grand_auth_id' => '2', 'parent_auth_id' => '4', 'current_auth_id' => '6', 'created_at' => now(), 'updated_at' => now()],
            17 => ['id' => 18, 'name' => 'event_edit', 'title' => '编辑', 'grand_auth_id' => '2', 'parent_auth_id' => '4', 'current_auth_id' => '6', 'created_at' => now(), 'updated_at' => now()],
            18 => ['id' => 19, 'name' => 'event_delete', 'title' => '删除', 'grand_auth_id' => '2', 'parent_auth_id' => '4', 'current_auth_id' => '6', 'created_at' => now(), 'updated_at' => now()],
            19 => ['id' => 20, 'name' => 'event_config', 'title' => '表单配置', 'grand_auth_id' => '2', 'parent_auth_id' => '4', 'current_auth_id' => '6', 'created_at' => now(), 'updated_at' => now()],

            //手机号管理
            20 => ['id' => 21, 'name' => 'mobile', 'title' => '查看', 'grand_auth_id' => '2', 'parent_auth_id' => '7', 'current_auth_id' => '8', 'created_at' => now(), 'updated_at' => now()],
            21 => ['id' => 22, 'name' => 'mobile_import', 'title' => '导入', 'grand_auth_id' => '2', 'parent_auth_id' => '7', 'current_auth_id' => '8', 'created_at' => now(), 'updated_at' => now()],
            22 => ['id' => 23, 'name' => 'mobile_delete', 'title' => '删除', 'grand_auth_id' => '2', 'parent_auth_id' => '7', 'current_auth_id' => '8', 'created_at' => now(), 'updated_at' => now()],

            //用户申请记录
            23 => ['id' => 24, 'name' => 'apply', 'title' => '查看', 'grand_auth_id' => '2', 'parent_auth_id' => '7', 'current_auth_id' => '9', 'created_at' => now(), 'updated_at' => now()],
            24 => ['id' => 25, 'name' => 'apply_edit', 'title' => '审核', 'grand_auth_id' => '2', 'parent_auth_id' => '7', 'current_auth_id' => '9', 'created_at' => now(), 'updated_at' => now()],

            //短信申请记录
            25 => ['id' => 26, 'name' => 'sms', 'title' => '查看', 'grand_auth_id' => '2', 'parent_auth_id' => '7', 'current_auth_id' => '10', 'created_at' => now(), 'updated_at' => now()],
            26 => ['id' => 27, 'name' => 'sms_edit', 'title' => '审核', 'grand_auth_id' => '2', 'parent_auth_id' => '7', 'current_auth_id' => '10', 'created_at' => now(), 'updated_at' => now()],

            //批量拒绝回复
            27 => ['id' => 28, 'name' => 'refuse', 'title' => '查看', 'grand_auth_id' => '2', 'parent_auth_id' => '11', 'current_auth_id' => '12', 'created_at' => now(), 'updated_at' => now()],
            28 => ['id' => 29, 'name' => 'refuse_edit', 'title' => '编辑', 'grand_auth_id' => '2', 'parent_auth_id' => '11', 'current_auth_id' => '12', 'created_at' => now(), 'updated_at' => now()],

            //批量通过回复
            29 => ['id' => 30, 'name' => 'pass', 'title' => '查看', 'grand_auth_id' => '2', 'parent_auth_id' => '11', 'current_auth_id' => '13', 'created_at' => now(), 'updated_at' => now()],
            30 => ['id' => 31, 'name' => 'pass_edit', 'title' => '编辑', 'grand_auth_id' => '2', 'parent_auth_id' => '11', 'current_auth_id' => '13', 'created_at' => now(), 'updated_at' => now()],

            //批量通过回复
            31 => ['id' => 32, 'name' => 'link', 'title' => '查看', 'grand_auth_id' => '2', 'parent_auth_id' => '11', 'current_auth_id' => '14', 'created_at' => now(), 'updated_at' => now()],
            32 => ['id' => 33, 'name' => 'link_edit', 'title' => '编辑', 'grand_auth_id' => '2', 'parent_auth_id' => '11', 'current_auth_id' => '14', 'created_at' => now(), 'updated_at' => now()],

            //链接管理
            31 => ['id' => 32, 'name' => 'link', 'title' => '查看', 'grand_auth_id' => '2', 'parent_auth_id' => '11', 'current_auth_id' => '14', 'created_at' => now(), 'updated_at' => now()],
            32 => ['id' => 33, 'name' => 'link_edit', 'title' => '编辑', 'grand_auth_id' => '2', 'parent_auth_id' => '11', 'current_auth_id' => '14', 'created_at' => now(), 'updated_at' => now()],

            //游戏管理
            33 => ['id' => 34, 'name' => 'game', 'title' => '查看', 'grand_auth_id' => '2', 'parent_auth_id' => '11', 'current_auth_id' => '15', 'created_at' => now(), 'updated_at' => now()],
            34 => ['id' => 35, 'name' => 'game_edit', 'title' => '编辑', 'grand_auth_id' => '2', 'parent_auth_id' => '11', 'current_auth_id' => '15', 'created_at' => now(), 'updated_at' => now()],

            //公告通知
            35 => ['id' => 36, 'name' => 'accouncement', 'title' => '查看', 'grand_auth_id' => '2', 'parent_auth_id' => '11', 'current_auth_id' => '16', 'created_at' => now(), 'updated_at' => now()],
            36 => ['id' => 37, 'name' => 'accouncement_edit', 'title' => '编辑', 'grand_auth_id' => '2', 'parent_auth_id' => '11', 'current_auth_id' => '16', 'created_at' => now(), 'updated_at' => now()],

        ];

        foreach ($config as $configValue) {
            DB::table('permission_menu')->insert($configValue);
        }
    }
}
