<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Table::factory()->createMany([
            ['name' => 'A1'],
            ['name' => 'A2'],
            ['name' => 'A3'],
            ['name' => 'B1'],
            ['name' => 'B2'],
            ['name' => 'C1'],
        ]);
    }
}
