<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Pergunta;
use App\Models\User;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Question\Question;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Pergunta::factory()->count(10)->create();
    }
}
