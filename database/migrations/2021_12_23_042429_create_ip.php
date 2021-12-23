<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateIp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ip', function (Blueprint $table) {
            $table->id()->comment('编号')->autoIncrement();
            $table->string('ip', 200)->comment('ip地址')->nullable();
            $table->string('admin_id', 200)->comment('管理员编号')->nullable();
            $table->string('description', 200)->comment('内容')->nullable();
            $table->timestamp('created_at')->comment('创建时间')->nullable();
            $table->timestamp('updated_at')->comment('更新时间')->nullable();
        });

        $prefix = env('DB_PREFIX') . "ip";
        DB::statement("alter table $prefix comment 'ip表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ip');
    }
}
