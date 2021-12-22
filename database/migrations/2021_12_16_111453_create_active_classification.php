<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateActiveClassification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_classification', function (Blueprint $table) {
            $table->id()->comment('编号')->autoIncrement();
            $table->string('name',200)->nullable()->comment('活动类型');
            $table->tinyInteger('status')->nullable()->comment('1=正常，0=禁止')->default(1);
            $table->unsignedSmallInteger('sort')->nullable()->comment('排序')->default(0);
            $table->timestamp('created_at',$precision = 0)->comment('创建时间')->nullable();
            $table->timestamp('updated_at',$precision = 0)->comment('更新时间')->nullable();
        });

        $prefix = env('DB_PREFIX')."active_classification";
        DB::statement("alter table $prefix comment '活动类型表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('active_classification');
    }
}
