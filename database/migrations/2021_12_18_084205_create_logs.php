<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id()->comment('编号')->autoIncrement();
            $table->unsignedTinyInteger('type')->comment('日志类型')->nullable();
            $table->string('title', 200)->comment('日志操作')->nullable();
            $table->string('ip', 200)->comment('ip 地址')->nullable();
            $table->longText('content')->comment('日志内容')->nullable();
            $table->unsignedTinyInteger('is_delete')->comment('0 未删除, 1 已删除')->default(0);
            $table->unsignedMediumInteger('admin_id')->comment('管理员编号')->nullable();
            $table->dateTime('created_at')->comment('创建时间')->nullable();
            $table->dateTime('updated_at')->comment('更新时间')->nullable();
        });

        $prefix = env('DB_PREFIX') . "logs";
        DB::statement("alter table $prefix comment '日志表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
