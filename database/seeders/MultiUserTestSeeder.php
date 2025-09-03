<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Category, Project, Skill, About, SiteSettings};

class MultiUserTestSeeder extends Seeder
{
    /**
     * Seed the application's database with multiple users and their data.
     * This seeder is used to test data isolation between users.
     */
    public function run(): void
    {
        // Create two test users
        $user1 = User::create([
            'name' => 'Test User 1',
            'email' => 'user1@example.com',
            'password' => Hash::make('password')
        ]);

        $user2 = User::create([
            'name' => 'Test User 2',
            'email' => 'user2@example.com',
            'password' => Hash::make('password')
        ]);

        // Create data for User 1
        $this->createUserData($user1, 'User 1');
        
        // Create data for User 2
        $this->createUserData($user2, 'User 2');
    }

    /**
     * Create test data for a specific user
     */
    private function createUserData(User $user, string $prefix): void
    {
        // Create categories for the user
        $webCategory = Category::create([
            'name' => $prefix . ' Web Development',
            'user_id' => $user->id
        ]);

        $mobileCategory = Category::create([
            'name' => $prefix . ' Mobile Development',
            'user_id' => $user->id
        ]);

        // Create projects for the user
        Project::create([
            'title' => $prefix . ' Portfolio Website',
            'slug' => strtolower(str_replace(' ', '-', $prefix)) . '-portfolio-website',
            'thumbnail' => '/images/neat.png',
            'repo_url' => 'https://github.com/example/portfolio',
            'live_url' => 'https://example.com/portfolio',
            'category_id' => $webCategory->id,
            'excerpt' => 'A personal portfolio website built with Laravel.',
            'body' => 'This is a detailed description of the portfolio website project.',
            'tags' => ['laravel', 'tailwind', 'portfolio'],
            'user_id' => $user->id
        ]);

        Project::create([
            'title' => $prefix . ' Mobile App',
            'slug' => strtolower(str_replace(' ', '-', $prefix)) . '-mobile-app',
            'thumbnail' => '/images/neat.png',
            'repo_url' => 'https://github.com/example/mobile-app',
            'live_url' => 'https://example.com/mobile-app',
            'category_id' => $mobileCategory->id,
            'excerpt' => 'A mobile application built with React Native.',
            'body' => 'This is a detailed description of the mobile app project.',
            'tags' => ['react-native', 'mobile', 'app'],
            'user_id' => $user->id
        ]);

        // Create skills for the user
        Skill::create([
            'name' => 'Laravel',
            'level' => 90,
            'user_id' => $user->id
        ]);

        Skill::create([
            'name' => 'React',
            'level' => 85,
            'user_id' => $user->id
        ]);

        Skill::create([
            'name' => 'Tailwind CSS',
            'level' => 80,
            'user_id' => $user->id
        ]);

        // Create about information for the user
        About::create([
            'title' => 'About ' . $prefix,
            'content' => 'I am a web developer with experience in Laravel, React, and Tailwind CSS.',
            'image' => 'about/profile.jpg',
            'resume_link' => 'https://example.com/resume',
            'years_experience' => 5,
            'completed_projects' => 20,
            'companies_worked' => 3,
            'user_id' => $user->id
        ]);

        // Create site settings for the user
        SiteSettings::create([
            'site_title' => $prefix . '\'s Portfolio',
            'site_description' => 'Welcome to ' . $prefix . '\'s portfolio website.',
            'primary_color' => '#4f46e5',
            'secondary_color' => '#7c3aed',
            'accent_color' => '#ec4899',
            'button_color' => '#4f46e5',
            'button_hover_color' => '#4338ca',
            'text_color' => '#111827',
            'navbar_color' => '#ffffff',
            'navbar_text_color' => '#111827',
            'footer_color' => '#1f2937',
            'footer_text_color' => '#f9fafb',
            'contact_email' => $prefix . '@example.com',
            'contact_phone' => '+1234567890',
            'contact_address' => '123 Main St, City, Country',
            'github_url' => 'https://github.com/' . strtolower(str_replace(' ', '', $prefix)),
            'linkedin_url' => 'https://linkedin.com/in/' . strtolower(str_replace(' ', '', $prefix)),
            'twitter_url' => 'https://twitter.com/' . strtolower(str_replace(' ', '', $prefix)),
            'instagram_url' => 'https://instagram.com/' . strtolower(str_replace(' ', '', $prefix)),
            'facebook_url' => 'https://facebook.com/' . strtolower(str_replace(' ', '', $prefix)),
            'user_id' => $user->id
        ]);
    }
}