<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id()->comment('管理员编号')->autoIncrement('id');
            $table->string('account',100)->unique()->comment('管理员');
            $table->string('password',200)->comment('密码');
            $table->string('user_name',100)->unique()->comment('昵称');
            $table->string('reg_ip', 100)->nullable()->comment('注册Ip');
            $table->string('number', 100)->nullable()->comment('联系号码');
            $table->string('last_ip', 100)->nullable()->comment('登录Ip');
            $table->tinyInteger('status')->comment('1=正常，0=禁止')->default(1);
            $table->tinyInteger('is_delete')->comment('1=删除，0=正常')->default(0);
            $table->unsignedMediumInteger('role_id')->comment('角色编号');
            $table->rememberToken()->nullable()->comment('登录token储存');
            $table->unsignedBigInteger('login_count')->nullable()->comment('登录次数')->default(0);
            $table->dateTime('last_date')->nullable()->comment('最后登录时间');
            $table->dateTime('created_at')->comment('创建时间')->nullable();
            $table->dateTime('updated_at')->comment('更新时间')->nullable();
        });
        
        $prefix = env('DB_PREFIX')."admin";
        DB::statement("alter table $prefix comment '后台管理员表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin');
    }
}
