<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Tag;
use App\Models\Thread;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tags')->insert([
            ['name' => 'Diagnosis', 'slug' => 'diagnosis'],
            ['name' => 'Therapies', 'slug' => 'therapies'],
            ['name' => 'Sensory', 'slug' => 'sensory'],
            ['name' => 'Communication', 'slug' => 'communication'],
            ['name' => 'Advocacy', 'slug' => 'advocacy'],
            ['name' => 'Self-Care', 'slug' => 'self-care'],
            ['name' => 'Mental Health', 'slug' => 'mental-health'],
            ['name' => 'Family Support', 'slug' => 'family-support'],
            ['name' => 'Education', 'slug' => 'education'],
            ['name' => 'Employment', 'slug' => 'employment'],
            ['name' => 'Meltdowns', 'slug' => 'meltdowns'],
            ['name' => 'Stimming', 'slug' => 'stimming'],
            ['name' => 'Executive Functioning', 'slug' => 'executive-functioning'],
            ['name' => 'Social Skills', 'slug' => 'social-skills'],
            ['name' => 'Routine', 'slug' => 'routine'],
            ['name' => 'Anxiety', 'slug' => 'anxiety'],
            ['name' => 'Depression', 'slug' => 'depression'],
            ['name' => 'Special Interests', 'slug' => 'special-interests'],
            ['name' => 'Inclusivity', 'slug' => 'inclusivity'],
            ['name' => 'Neurodiversity', 'slug' => 'neurodiversity'],
            ['name' => 'Empowerment', 'slug' => 'empowerment'],
            ['name' => 'Community Events', 'slug' => 'community-events'],
            ['name' => 'Resources', 'slug' => 'resources'],
            ['name' => 'Sensory Overload', 'slug' => 'sensory-overload'],
            ['name' => 'Melatonin', 'slug' => 'melatonin'],
            ['name' => 'Visual Supports', 'slug' => 'visual-supports'],
            ['name' => 'Fidget Tools', 'slug' => 'fidget-tools'],
            ['name' => 'Sensory Diet', 'slug' => 'sensory-diet'],
            ['name' => 'Autism Acceptance', 'slug' => 'autism-acceptance'],
            ['name' => 'Social Anxiety', 'slug' => 'social-anxiety'],
            ['name' => 'Emotional Regulation', 'slug' => 'emotional-regulation'],
        ]);


        $tagIds = array_flip(Tag::all()->pluck('id')->toArray());
        $articles = Article::all();
        $threads = Thread::all();
        $taggables = [];

        foreach ($articles as $article) {
            foreach (array_rand($tagIds, 3) as $tagId) {
                $taggables[] = [
                    'taggable_id' => $article->id,
                    'taggable_type' => 'articles',
                    'tag_id' => $tagId,
                ];
            }
        }

        foreach ($threads as $thread) {
            foreach (array_rand($tagIds, 3) as $tagId) {
                $taggables[] = [
                    'taggable_id' => $thread->id,
                    'taggable_type' => 'threads',
                    'tag_id' => $tagId,
                ];
            }
        }

        DB::table('taggables')->insert($taggables);
    }
}
