<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tagsJSON = File::get(database_path('data/tags.json'));
        $tags = json_decode($tagsJSON, true);

        foreach ($tags as $tag) {
            // Create the country
            $tag = Tag::create([
                'id' => $tag['id'],
                'tag_id' => $tag['tag_id'],
                'name' => $tag['name'],
                'color' => $tag['color'],
            ]);
        }
    }
}
