<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUserApply extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_apply', function (Blueprint $table) {
            $table->id()->comment('编号')->autoIncrement();
            $table->unsignedMediumInteger('event_id')->comment('活动类型');
            $table->string('username', 200)->comment('申请用户名称')->nullable();
            $table->timestamp('apply_time')->comment('申请时间')->nullable();
            $table->string('description', 200)->comment('回复内容')->nullable();
            $table->unsignedTinyInteger('status')->comment('0 未审核, 1 开启, 2 审核不通过')->default(1);
            $table->unsignedTinyInteger('is_delete')->comment('0 删除, 1 未删除')->default(1);
            $table->string('ip', 200)->comment('用户IP')->nullable();
            $table->dateTime('created_at')->comment('创建时间')->nullable();
            $table->dateTime('updated_at')->comment('更新时间')->nullable();
        });

        $prefix = env('DB_PREFIX') . "user_apply";
        DB::statement("alter table $prefix comment '用户申请表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_apply');
    }
}
