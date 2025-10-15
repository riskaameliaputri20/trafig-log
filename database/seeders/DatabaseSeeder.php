<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->call('log:parse');
        // Buat kategori jika belum ada
        if (BlogCategory::count() == 0) {
            $this->command->info('Membuat 20 kategori blog...');
            BlogCategory::factory()->count(20)->create();
        }

        // Tanya jumlah blog
        $count = (int) $this->command->ask('Jumlah Blog yang ingin dibuat?', 10);

        $this->command->info("Membuat {$count} Blog...");

        // Progress Bar
        $this->command->withProgressBar(range(1, $count), function () {
            Blog::factory()->create();
        });

        $this->command->newLine();
        $this->command->info("✅ Selesai membuat {$count} blog!");
    }
}
