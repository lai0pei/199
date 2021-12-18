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
            $table->unsignedTinyInteger('type')->comment('菜单类型');
            $table->longText('value')->comment('菜单内容');
            $table->longText('description')->comment('菜单描述');
            $table->timestamps();
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
