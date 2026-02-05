<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Technology',
                'description' => 'Latest tech news, gadgets, and software updates from around the world.',
                'color' => '#6366f1',
                'is_featured' => true,
            ],
            [
                'name' => 'Web Development',
                'description' => 'Tutorials and insights into modern web technologies like Vue, Laravel, and React.',
                'color' => '#f59e0b',
                'is_featured' => true,
            ],
            [
                'name' => 'Artificial Intelligence',
                'description' => 'Exploring the future of AI, machine learning, and automation.',
                'color' => '#10b981',
                'is_featured' => true,
            ],
            [
                'name' => 'Digital Marketing',
                'description' => 'Strategies for SEO, social media, and online growth for businesses.',
                'color' => '#ec4899',
                'is_featured' => false,
            ],
            [
                'name' => 'Cyber Security',
                'description' => 'Tips and news about online safety, hacking, and data protection.',
                'color' => '#ef4444',
                'is_featured' => false,
            ],
            [
                'name' => 'Cloud Computing',
                'description' => 'Everything about AWS, Azure, and modern cloud infrastructure.',
                'color' => '#06b6d4',
                'is_featured' => false,
            ],
            [
                'name' => 'Mobile Apps',
                'description' => 'Development and reviews of iOS and Android applications.',
                'color' => '#8b5cf6',
                'is_featured' => false,
            ],
            [
                'name' => 'Data Science',
                'description' => 'Analyzing big data and extracting meaningful insights.',
                'color' => '#f43f5e',
                'is_featured' => false,
            ],
            [
                'name' => 'Business',
                'description' => 'Insights into the corporate world and entrepreneurship.',
                'color' => '#3b82f6',
                'is_featured' => false,
            ],
            [
                'name' => 'Lifestyle',
                'description' => 'Balancing work and life in the fast-paced tech industry.',
                'color' => '#14b8a6',
                'is_featured' => false,
            ],
            [
                'name' => 'Design',
                'description' => 'UI/UX design principles and creative inspiration.',
                'color' => '#fb923c',
                'is_featured' => true,
            ],
            [
                'name' => 'Hardware',
                'description' => 'Reviews of PC components, laptops, and smart home devices.',
                'color' => '#4b5563',
                'is_featured' => false,
            ],
            [
                'name' => 'E-commerce',
                'description' => 'Trends and technologies in online shopping industry.',
                'color' => '#334155',
                'is_featured' => false,
            ],
            [
                'name' => 'Game Development',
                'description' => 'Tools and techniques for creating modern video games.',
                'color' => '#7c3aed',
                'is_featured' => false,
            ],
            [
                'name' => 'React JS',
                'description' => 'Advanced tips and tricks for React framework practitioners.',
                'color' => '#0ea5e9',
                'is_featured' => false,
            ]
        ];

        foreach ($categories as $category) {
            BlogCategory::create($category);
        }
    }
}
