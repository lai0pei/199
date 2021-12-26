<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateVipMobile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vip_mobile', function (Blueprint $table) {
            $table->id()->comment('编号')->autoIncrement();
            $table->string('mobile',50)->comment('手机号')->default(0);
            $table->dateTime('created_at')->comment('创建时间')->nullable();
            $table->dateTime('updated_at')->comment('更新时间')->nullable();
        });

        
        $prefix = env('DB_PREFIX')."vip_mobile";
        DB::statement("alter table $prefix comment 'vip用户手机号表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vip_mobile');
    }
}
