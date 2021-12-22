<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
            $table->string('name', 100)->comment('菜单英文名称');
            $table->string('title', 100)->comment('菜单中文名称');
            $table->longText('json_data')->comment('菜单内容');
            $table->timestamp('created_at',$precision = 0)->comment('创建时间')->nullable();
            $table->timestamp('updated_at',$precision = 0)->comment('更新时间')->nullable();
        });

        $prefix = env('DB_PREFIX') . "configs";
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
