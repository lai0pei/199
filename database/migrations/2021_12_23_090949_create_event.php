<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event', function (Blueprint $table) {
            $table->id()->comment('编号')->autoIncrement();
            $table->string('name', 200)->comment('活动名称')->nullable();
            $table->unsignedMediumInteger('type_id')->comment('活动分类');
            $table->string('type_pic', 200)->comment('活动图片')->nullable();
            $table->string('external_url', 200)->comment('外链地址')->nullable();
            $table->unsignedMediumInteger('sort')->comment('排序');
            $table->unsignedTinyInteger('status')->comment('0 关闭, 1 开启')->default(1);
            $table->unsignedTinyInteger('display')->comment('0 屏蔽, 1 显示')->default(1);
            $table->unsignedTinyInteger('is_sms')->comment('是否短信活动 0 不是, 1 是')->default(0);
            $table->unsignedTinyInteger('need_sms')->comment('活动是否需要短信申请 0 不是, 1 是')->default(0);
            $table->string('start_time',200)->comment('活动开始时间')->nullable();
            $table->string('end_time',200)->comment('活动结束时间')->nullable();
            $table->string('daily_limit', 200)->comment('每日限制次数')->nullable();
            $table->unsignedTinyInteger('is_daily')->comment('是否限制每日申请')->default(1);
            $table->longText('content')->comment('活动内容')->nullable();
            $table->dateTime('created_at')->comment('创建时间')->nullable();
            $table->dateTime('updated_at')->comment('更新时间')->nullable();
        });

        $prefix = env('DB_PREFIX') . "event";
        DB::statement("alter table $prefix comment '活动表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event');
    }
}
