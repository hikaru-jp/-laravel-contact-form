<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // CategorySeeder 実行
        $this->call(CategorySeeder::class);

        // ContactFactory 35 件作成
        \App\Models\Contact::factory(35)->create();
    }
}

