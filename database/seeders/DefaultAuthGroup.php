<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultAuthGroup extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $auth = DB::table('permission')->select('id')->get()->toArray();
        $id =  implode(",",array_column($auth, 'id'));
        DB::table('auth_group')->insert([
            'id' => 1,
            'role_id' => 1,
            'auth_id' => "$id",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
