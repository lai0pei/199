<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_menu', function (Blueprint $table) {
            $table->id()->comment('编号')->autoIncrement();
            $table->string('name', 200)->comment('名称')->nullable();
            $table->string('title', 200)->comment('操作权限')->nullable();
            $table->unsignedTinyInteger('grand_auth_id')->comment('一级菜单类型');
            $table->unsignedTinyInteger('parent_auth_id')->comment('二级菜单类型');
            $table->unsignedTinyInteger('current_auth_id')->comment('三级菜单类型');
            $table->timestamps();
        });

        $prefix = env('DB_PREFIX') . "permission_menu";
        DB::statement("alter table $prefix comment '授权菜单表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission');
    }
}
