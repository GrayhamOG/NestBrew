<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\MenuItemSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    $this->call([
        AdminUserSeeder::class,
        MenuItemSeeder::class,
    ]);
}
}