<?php

namespace Database\Seeders;

use App\Models\Heart;
use Illuminate\Database\Seeder;

class HeartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * The factory constructs all the objects before persisting them.
         * This sometimes creates duplicate rows as the Heart factry uses 
         * a random sort to get random rows. 
         * Given that the Heart entity has a unique key constraint, duplicate keys aren't allowed.
         * So we just have the factory create the objects one by one
         */
        for ($i = 0; $i < 10000; $i++) {
            Heart::factory()->create();
        }
    } 
}
