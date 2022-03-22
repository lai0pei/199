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
        //admin 循序必须在 Permission 后
        $this->call([  
            DefaultMenu::class,
            DefaultPermission::class,
            DefaultAdmin::class,
            DefaultRole::class,
            DefaultAuthGroup::class,
            DefaultConfig::class,
            DefaultEvent::class,  
            DefaultEventType::class,            
        ]);
    }
}
