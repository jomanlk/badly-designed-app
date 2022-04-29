<?php

namespace Database\Seeders;

use App\Models\Heart;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(
        UserSeeder $userSeeder,
        MessageSeeder $messageSeeder,
        HeartSeeder $heartSeeder,
        )
    {
       $userSeeder->run();
       $messageSeeder->run();
       $heartSeeder->run();
    }
}
