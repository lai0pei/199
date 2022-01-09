<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form', function (Blueprint $table) {
            $table->id()->comment('编号')->autoIncrement();
            $table->unsignedMediumInteger('event_id')->comment('活动编号');
            $table->unsignedMediumInteger('sort')->comment('排序');
            $table->string('name', 200)->comment('表单名称')->nullable();
            $table->unsignedSmallInteger('type')->comment('表单类型 0 文本框, 1数字类型, 2手机号码, 3时间框, 4图片框, 5下拉框');
            $table->string('option', 200)->comment('对应类型 值')->nullable();            
            $table->dateTime('created_at')->comment('创建时间')->nullable();
            $table->dateTime('updated_at')->comment('更新时间')->nullable();
        });

        $prefix = env('DB_PREFIX') . "form";
        DB::statement("alter table $prefix comment '活动表单表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form');
    }
}
