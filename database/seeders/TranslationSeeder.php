<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Translation;
use Illuminate\Database\Seeder;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 tags
        $tags = Tag::factory(10)->create();

        Translation::factory(100000)->create()->chunk(500)->each(function ($chunk) use ($tags) {
            foreach ($chunk as $translation) {
                $translation->tags()->attach(
                    $tags->random(2)->pluck('id')->toArray()
                );
            }
        });
    }
}
