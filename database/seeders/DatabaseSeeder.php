<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DefaultAdmin::class,
            DefaultMenu::class,
            DefaultPermission::class,
            DefaultRole::class,
            DefaultAuthGroup::class,
            DefaultConfig::class,
            DefaultEvent::class,  
            DefaultEventType::class,            
        ]);
    }
}
