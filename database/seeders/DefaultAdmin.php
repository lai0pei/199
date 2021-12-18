<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        DB::table('admin')->insert([
            'account' => 'admin',
            'password' => '$2y$10$nEzpUIAng7BIu1lPQv5HfenD149pNFDOEPDM9U0Yd3JDWW7JBbdJ2',
            'user_name' => 'admin',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
