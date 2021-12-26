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
        $config = array(
            //管理员 操作

            ['name' => 'admin_add', 'title' => '添加', 'grand_auth_id' => '3', 'content'=>'添加此权限, 管理员仅可浏览 和 添加新管理员','parent_auth_id' => '17', 'current_auth_id' => '18', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'admin_edit', 'title' => '编辑', 'grand_auth_id' => '3', 'content'=>'添加此权限, 管理员仅可浏览 和 编辑已有管理员','parent_auth_id' => '17', 'current_auth_id' => '18', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'admin_delete', 'title' => '删除', 'grand_auth_id' => '3', 'content'=>'添加此权限, 管理员仅可浏览 和 删除已有管理员','parent_auth_id' => '17', 'current_auth_id' => '18', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'admin_view', 'title' => '查看身份', 'grand_auth_id' => '3', 'content'=>'添加此权限, 管理员仅可管理员管理员','parent_auth_id' => '17', 'current_auth_id' => '18', 'created_at' => now(), 'updated_at' => now()],


            //管理组 操作
            ['name' => 'group_add', 'title' => '添加', 'grand_auth_id' => '3', 'content'=>'添加此权限, 管理员仅可浏览 和 添加新管理组','parent_auth_id' => '17', 'current_auth_id' => '19', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'group_edit', 'title' => '编辑', 'grand_auth_id' => '3', 'content'=>'添加此权限, 管理员仅可浏览 和 编辑已有管理组','parent_auth_id' => '17', 'current_auth_id' => '19', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'group_delete', 'title' => '删除', 'grand_auth_id' => '3', 'content'=>'添加此权限, 管理员仅可浏览 和 删除已有管理组','parent_auth_id' => '17', 'current_auth_id' => '19', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'group_auth', 'title' => '权限', 'grand_auth_id' => '3', 'content'=>'添加此权限, 管理员仅可浏览 和 编辑已有管理组权限','parent_auth_id' => '17', 'current_auth_id' => '19', 'created_at' => now(), 'updated_at' => now()],

            //修改自己的密码 操作
            ['name' => 'password_change', 'title' => '修改', 'grand_auth_id' => '3', 'content'=>'添加此权限, 管理员仅可浏览 和 修改自己的 登录密码','parent_auth_id' => '17', 'current_auth_id' => '20', 'created_at' => now(), 'updated_at' => now()],

            //所有权限
            ['name' => 'auth_list', 'title' => '预览', 'grand_auth_id' => '3', 'content'=>'添加此权限, 管理员可浏览 和 查看权限列表','parent_auth_id' => '21', 'current_auth_id' => '23', 'created_at' => now(), 'updated_at' => now()],

            //系统日志
            ['name' => 'log', 'title' => '预览', 'grand_auth_id' => '3','content'=>'添加此权限, 管理员可浏览 和 查看系统日志列表', 'parent_auth_id' => '21', 'current_auth_id' => '22', 'created_at' => now(), 'updated_at' => now()],

            //短信配置
            ['name' => 'sms_config', 'title' => '预览', 'grand_auth_id' => '3', 'content'=>'添加此权限, 管理员可浏览 后台短信配置','parent_auth_id' => '24', 'current_auth_id' => '26', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'sms_config_edit', 'title' => '编辑', 'grand_auth_id' => '3', 'content'=>'添加此权限, 管理员可浏览 和 编辑后台短信配置','parent_auth_id' => '24', 'current_auth_id' => '26', 'created_at' => now(), 'updated_at' => now()],
            
            //允许ip
            ['name' => 'ip', 'title' => '预览', 'grand_auth_id' => '3', 'parent_auth_id' => '24', 'content'=>'添加此权限, 管理员可浏览 允许登录IP地址','current_auth_id' => '27', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ip_edit', 'title' => '修改', 'grand_auth_id' => '3', 'parent_auth_id' => '24', 'content'=>'添加此权限, 管理员可浏览 和 编辑后台 允许登录IP地址','current_auth_id' => '27', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ip_add', 'title' => '添加', 'grand_auth_id' => '3', 'parent_auth_id' => '24', 'content'=>'添加此权限, 管理员可浏览 和 添加后台 允许登录IP地址','current_auth_id' => '27', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ip_delete', 'title' => '删除', 'grand_auth_id' => '3', 'parent_auth_id' => '24', 'content'=>'添加此权限, 管理员可浏览 和 删除后台 允许登录IP地址','current_auth_id' => '27', 'created_at' => now(), 'updated_at' => now()],

            //公共配置
            ['name' => 'common', 'title' => '预览', 'grand_auth_id' => '3', 'parent_auth_id' => '24', 'content'=>'添加此权限, 管理员可浏览 后台公共配置','current_auth_id' => '25', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'common_edit', 'title' => '修改', 'grand_auth_id' => '3', 'parent_auth_id' => '24','content'=>'添加此权限, 管理员可浏览 和 编辑后台 公共配置', 'current_auth_id' => '25', 'created_at' => now(), 'updated_at' => now()],

            //创建活动
            ['name' => 'event_add', 'title' => '添加', 'grand_auth_id' => '2', 'parent_auth_id' => '4', 'content'=>'添加此权限, 管理员可 添加新活动','current_auth_id' => '5', 'created_at' => now(), 'updated_at' => now()],

            //创建类型
            ['name' => 'type_add', 'title' => '添加', 'grand_auth_id' => '2', 'parent_auth_id' => '4', 'content'=>'添加此权限, 管理员可 添加新活动分类','current_auth_id' => '28', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'type_edit', 'title' => '编辑', 'grand_auth_id' => '2', 'parent_auth_id' => '4', 'content'=>'添加此权限, 管理员可 编辑新活动分类','current_auth_id' => '28', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'type_delete', 'title' => '删除', 'grand_auth_id' => '2', 'parent_auth_id' => '4', 'content'=>'添加此权限, 管理员可 删除新活动分类','current_auth_id' => '28', 'created_at' => now(), 'updated_at' => now()],

            //活动列表
            ['name' => 'event_list', 'title' => '预览', 'grand_auth_id' => '2', 'parent_auth_id' => '4','content'=>'添加此权限, 管理员仅可 预览活动列表', 'current_auth_id' => '6', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'event_edit', 'title' => '编辑', 'grand_auth_id' => '2', 'parent_auth_id' => '4', 'content'=>'添加此权限, 管理员仅可 预览 和 编辑活动列表','current_auth_id' => '6', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'event_delete', 'title' => '删除', 'grand_auth_id' => '2', 'parent_auth_id' => '4', 'content'=>'添加此权限, 管理员仅可 预览 和 删除活动列表','current_auth_id' => '6', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'event_config', 'title' => '表单配置', 'grand_auth_id' => '2', 'parent_auth_id' => '4', 'content'=>'添加此权限, 管理员仅可 预览 和 编辑活动列表表单','current_auth_id' => '6', 'created_at' => now(), 'updated_at' => now()],

            //手机号管理
            ['name' => 'mobile', 'title' => '预览', 'grand_auth_id' => '2', 'parent_auth_id' => '7', 'content'=>'添加此权限, 管理员仅可 预览 vip用户手机号码列表','current_auth_id' => '8', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'mobile_import', 'title' => '导入', 'grand_auth_id' => '2', 'parent_auth_id' => '7','content'=>'添加此权限, 管理员可 预览 和 导入vip用户手机号码列表', 'current_auth_id' => '8', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'mobile_delete', 'title' => '删除', 'grand_auth_id' => '2', 'parent_auth_id' => '7', 'content'=>'添加此权限, 管理员可 预览 和 删除vip用户手机号码列表','current_auth_id' => '8', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'mobile_onclick', 'title' => '一键清除数据', 'grand_auth_id' => '2', 'parent_auth_id' => '7','content'=>'添加此权限, 管理员仅可 预览 和 导入vip用户手机号码列表', 'current_auth_id' => '8', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'mobile_bulk', 'title' => '批量删除', 'grand_auth_id' => '2', 'parent_auth_id' => '7', 'content'=>'添加此权限, 管理员可 预览 和 删除vip用户手机号码列表','current_auth_id' => '8', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'mobile_add', 'title' => '添加', 'grand_auth_id' => '2', 'parent_auth_id' => '7', 'content'=>'添加此权限, 管理员可 预览 和 添加 vip用户手机号码列表','current_auth_id' => '8', 'created_at' => now(), 'updated_at' => now()],

            //用户申请记录
            ['name' => 'apply', 'title' => '预览', 'grand_auth_id' => '2', 'parent_auth_id' => '7', 'content'=>'添加此权限, 管理员仅可 预览 用户申请记录','current_auth_id' => '9', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'apply_edit', 'title' => '审核操作', 'grand_auth_id' => '2', 'parent_auth_id' => '7', 'content'=>'添加此权限, 管理员可 预览 和 审核用户申请记录','current_auth_id' => '9', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'apply_bulk_pass', 'title' => '批量通过', 'grand_auth_id' => '2', 'parent_auth_id' => '7', 'content'=>'添加此权限, 管理员可 预览 和 批量通过用户申请记录','current_auth_id' => '9', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'apply_bulk_refuse', 'title' => '批量拒绝', 'grand_auth_id' => '2', 'parent_auth_id' => '7', 'content'=>'添加此权限, 管理员可 预览 和 批量拒绝用户申请记录','current_auth_id' => '9', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'apply_bulk_delete', 'title' => '批量删除', 'grand_auth_id' => '2', 'parent_auth_id' => '7', 'content'=>'添加此权限, 管理员可 预览 和 批量删除用户申请记录','current_auth_id' => '9', 'created_at' => now(), 'updated_at' => now()],

            //短信申请记录
            ['name' => 'sms', 'title' => '预览', 'grand_auth_id' => '2', 'parent_auth_id' => '7','content'=>'添加此权限, 管理员可 预览 短信号码申请记录', 'current_auth_id' => '10', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'sms_edit', 'title' => '审核操作', 'grand_auth_id' => '2', 'parent_auth_id' => '7', 'content'=>'添加此权限, 管理员可 预览 和 审核 短信号码申请记录','current_auth_id' => '10', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'sms_bulk_pass', 'title' => '批量通过', 'grand_auth_id' => '2', 'parent_auth_id' => '7','content'=>'添加此权限, 管理员可 预览 和 批量通过短信号码申请记录', 'current_auth_id' => '10', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'sms_bulk_refuse', 'title' => '批量拒绝', 'grand_auth_id' => '2', 'parent_auth_id' => '7','content'=>'添加此权限, 管理员可 预览 和 批量拒绝短信号码申请记录', 'current_auth_id' => '10', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'sms_bulk_delete', 'title' => '批量删除', 'grand_auth_id' => '2', 'parent_auth_id' => '7','content'=>'添加此权限, 管理员可 预览 和 批量删除短信号码申请记录', 'current_auth_id' => '10', 'created_at' => now(), 'updated_at' => now()],

            //批量拒绝回复
            ['name' => 'refuse', 'title' => '预览', 'grand_auth_id' => '2', 'parent_auth_id' => '11','content'=>'添加此权限, 管理员仅可预览 批量拒绝回复内容', 'current_auth_id' => '12', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'refuse_edit', 'title' => '编辑', 'grand_auth_id' => '2', 'parent_auth_id' => '11', 'content'=>'添加此权限, 管理员可 预览 和 编辑批量拒绝回复内容','current_auth_id' => '12', 'created_at' => now(), 'updated_at' => now()],

            //批量通过回复
            ['name' => 'pass', 'title' => '预览', 'grand_auth_id' => '2', 'parent_auth_id' => '11', 'content'=>'添加此权限, 管理员仅可预览 批量通过回复内容','current_auth_id' => '13', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'pass_edit', 'title' => '编辑', 'grand_auth_id' => '2', 'parent_auth_id' => '11', 'content'=>'添加此权限, 管理员可 预览 和 编辑批量通过回复内容','current_auth_id' => '13', 'created_at' => now(), 'updated_at' => now()],

            //链接管理
            ['name' => 'link', 'title' => '预览', 'grand_auth_id' => '2', 'parent_auth_id' => '11','content'=>'添加此权限, 管理员仅可预览 前台链接', 'current_auth_id' => '14', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'link_edit', 'title' => '编辑', 'grand_auth_id' => '2', 'parent_auth_id' => '11','content'=>'添加此权限, 管理员可 预览 和 编辑前台链接', 'current_auth_id' => '14', 'created_at' => now(), 'updated_at' => now()],

            //游戏管理
            ['name' => 'game', 'title' => '预览', 'grand_auth_id' => '2', 'parent_auth_id' => '11','content'=>'添加此权限, 管理员仅可预览 游戏链接', 'current_auth_id' => '15', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'game_edit', 'title' => '编辑', 'grand_auth_id' => '2', 'parent_auth_id' => '11', 'content'=>'添加此权限, 管理员可 预览 和 编辑游戏链接','current_auth_id' => '15', 'created_at' => now(), 'updated_at' => now()],

            //公告通知
            ['name' => 'accouncement', 'title' => '预览', 'grand_auth_id' => '2', 'parent_auth_id' => '11', 'content'=>'添加此权限, 管理员可 预览 前台公告通知','current_auth_id' => '16', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'accouncement_edit', 'title' => '编辑', 'grand_auth_id' => '2', 'parent_auth_id' => '11','content'=>'添加此权限, 管理员可 预览 和 编辑前台公告通知', 'current_auth_id' => '16', 'created_at' => now(), 'updated_at' => now()],

        );

        //设置 auth_menu 最大之后的 编号 不然 layui tree 插件出现 问题
        $index = 29;

        foreach ($config as &$configValue) {
            $configValue['id'] = $index;
            DB::table('permission')->insert($configValue);
            $index++;
        }
    }
}
