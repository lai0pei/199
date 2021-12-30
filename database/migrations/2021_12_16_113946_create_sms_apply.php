<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSmsApply extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_apply', function (Blueprint $table) {
            $table->id()->autoIncrement()->comment('编号');
            $table->string('user_name',100)->nullable()->comment('申请用户名称');
            $table->string('message',200)->nullable()->comment('派送信息');
            $table->string('mobile',50)->nullable()->comment('用户电话号码');
            $table->decimal('money', $precision = 12, $scale = 2)->default(0.00)->comment('申请金额');
            $table->string('game',100)->nullable()->comment('游戏类型');
            $table->tinyInteger('is_delete')->comment('1=删除，0=正常')->default(0)->nullable();
            $table->tinyInteger('state')->comment('0 = 未审核, 1=通过，2=失败')->default(0);
            $table->tinyInteger('is_send')->comment('1=已发，0=未发')->default(0);
            $table->tinyInteger('is_audit')->comment('以后标注')->nullable();
            $table->tinyInteger('is_match')->comment('1=匹配，0=不匹配')->nullable();
            $table->string('ip', 100)->nullable()->comment('使用Ip');
            $table->longText('send_remark')->nullable()->comment('派送备注');
            $table->dateTime('send_time', $precision = 0)->nullable()->comment('派送时间');
            $table->dateTime('apply_time', $precision = 0)->nullable()->comment('申请时间');
            $table->dateTime('created_at',$precision = 0)->comment('创建时间')->nullable();
            $table->dateTime('updated_at',$precision = 0)->comment('更新时间')->nullable();
        });

        $prefix = env('DB_PREFIX')."sms_apply";
        DB::statement("alter table $prefix comment '短信申请表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_apply');
    }
}
