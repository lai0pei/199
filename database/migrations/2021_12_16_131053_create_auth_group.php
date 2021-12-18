<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAuthGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_group', function (Blueprint $table) {
            $table->id()->comment('编号')->autoIncrement();
            $table->unsignedSmallInteger('role_id')->nullable()->comment('角色编号');
            $table->string('auth_id',200)->nullable()->comment('权限');
            $table->timestamps();
        });

        $prefix = env('DB_PREFIX')."auth_group";
        DB::statement("alter table $prefix comment '角色权限表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_group');
    }
}
