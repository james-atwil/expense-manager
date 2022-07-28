<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(SystemRolesTableSeeder::class);
        $this->call(SystemUsersTableSeeder::class);
        $this->call(SystemSettingsTableSeeder::class);
        $this->call(ExpensesCategoriesTableSeeder::class);
        $this->call(ExpensesExpensesTableSeeder::class);
    }
}
