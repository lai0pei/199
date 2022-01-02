<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultEvent extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event')->insert([
            'id' => 1,
            'name' => '新人短信申请',
            'type_id' => 1,
            'status' => 1,
            'display' => 1,
            'is_daily' => 0,
            'is_sms' => 1,
            'need_sms' => 1,
            'sort' => 0,
            'daily_limit' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
