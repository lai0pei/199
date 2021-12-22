<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultRole extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->insert([
            'role_name' => '超级管理员',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
