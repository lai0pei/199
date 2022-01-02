<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultEventType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = [['id' => 1, 'name' => '综合优惠', 'status' => 1, 'sort' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => '棋牌优惠', 'status' => 1, 'sort' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => '捕鱼优惠', 'status' => 1, 'sort' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => '电子优惠', 'status' => 1, 'sort' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => '真人优惠', 'status' => 1, 'sort' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => '体育优惠', 'status' => 1, 'sort' => 5, 'created_at' => now(), 'updated_at' => now()]];

            foreach ($type as $configValue) {
                DB::table('type')->insert($configValue);
            }
    }
}
