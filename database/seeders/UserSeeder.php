<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->createQuietly([
            'name' => 'Jonathan van Rij',
            'email' => 'jonathan@blijnder.nl',
            'username' => 'jivanrij',
            'github_username' => 'jivanrij',
            'password' => bcrypt('secret'),
            'type' => User::ADMIN,
        ]);

        User::factory()->createQuietly([
            'name' => 'Antonia Borneo',
            'email' => 'antonia@gmeel.com',
            'username' => 'antonia',
            'github_username' => 'antonia',
            'password' => bcrypt('secret'),
            'type' => User::DEFAULT,
        ]);

        $admin = User::factory()->createQuietly([
            'name' => 'Anne-Jo van Rij',
            'email' => 'jejvanrij@gmail.com',
            'username' => 'jejvanrij',
            'github_username' => 'jejvanrij',
            'password' => bcrypt('secret'),
            'type' => User::ADMIN,
        ]);

        DB::beginTransaction();

        User::factory()
            ->count(100)
            ->has(Thread::factory()->count(2), 'threadsRelation')
            ->has(
                Article::factory()
                    ->count(2)
                    ->state(
                        new Sequence(
                            [
                                'submitted_at' => now(),
                                'approved_at' => now(),
                                'hero_image' => 'sxiSod0tyYQ',
                            ],
                            ['submitted_at' => now(), 'approved_at' => now()],
                            ['submitted_at' => now()],
                        ),
                    ),
            )
            ->createQuietly();

        Article::factory()->count(10)->createQuietly(['author_id' => $admin->id]);

        DB::commit();

        Article::published()
            ->inRandomOrder()
            ->take(4)
            ->update(['is_pinned' => true]);

        // Block some users...
        $admin->blockedUsers()->sync(range(20, 24));
    }
}
