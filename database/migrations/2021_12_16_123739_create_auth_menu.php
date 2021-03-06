<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAuthMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_menu', function (Blueprint $table) {
            $table->id()->comment('编号')->autoIncrement();
            $table->unsignedMediumInteger('p_id')->comment('父级编号');
            $table->string('title', 100)->comment('权限名称');
            $table->string('icon', 100)->comment('菜单左边图标');
            $table->string('target', 100)->comment('跳转页面')->default('_self');
            $table->string('auth_name', 100)->comment('权限名称');
            $table->string('href', 100)->comment('路由地址');
            $table->unsignedTinyInteger('status')->comment('0 关闭, 1 开启')->default(1);
            $table->unsignedTinyInteger('is_shortcut')->comment('0 不是, 1 是首页快捷')->default(0);
            $table->unsignedMediumInteger('sort')->comment('排序')->default(0);
            $table->dateTime('created_at')->comment('创建时间')->nullable();
            $table->dateTime('updated_at')->comment('更新时间')->nullable();
        });

        
        $prefix = env('DB_PREFIX')."auth_menu";
        DB::statement("alter table $prefix comment '权限菜单表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_menu');
    }
}
