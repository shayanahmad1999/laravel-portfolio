
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Category, Project, Skill};

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $web = Category::firstOrCreate(['name' => 'Web']);
        $ml  = Category::firstOrCreate(['name' => 'ML']);

        Project::create([
          'title' => 'Neat Portfolio',
          'slug' => 'neat-portfolio',
          'thumbnail' => '/images/neat.png',
          'repo_url' => 'https://github.com/example/neat',
          'live_url' => 'https://example.com',
          'category_id' => $web->id,
          'excerpt' => 'Clean personal portfolio built with Laravel.',
          'body' => 'Details about the project...',
          'tags' => ['laravel','tailwind'],
        ]);

        Skill::insert([
          ['name'=>'Laravel','level'=>90],
          ['name'=>'React','level'=>80],
          ['name'=>'Tailwind','level'=>85],
          ['name'=>'MySQL','level'=>75],
        ]);
    }
}
