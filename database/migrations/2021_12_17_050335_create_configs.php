<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateConfigs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->id()->comment('编号')->autoIncrement();
            $table->string('name',100)->comment('菜单英文名称');
            $table->string('title',100)->comment('菜单中文名称');
            $table->unsignedTinyInteger('type')->comment('菜单类型');
            $table->longText('value')->comment('菜单内容');
            $table->longText('description')->comment('菜单描述');
            $table->dateTime('updated_at', $precision = 0)->comment('更新时间');
            $table->dateTime('created_at', $precision = 0)->comment('添加时间');
        });

        $prefix = env('DB_PREFIX')."configs";
        DB::statement("alter table $prefix comment '系统配置表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configs');
    }
}
