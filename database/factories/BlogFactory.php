<?php

namespace Database\Factories;

use App\Models\BlogCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'        => fake()->sentence(),      // Judul acak
            'description'  => fake()->paragraph(),     // Deskripsi acak
            'content'      => fake()->text(1500),
        'thumbnail'    => 'https://placehold.co/600x400?text=Thumbnail',
            'blog_category_id'  => BlogCategory::inRandomOrder()->first()?->id ?? BlogCategory::factory(),
        ];
    }
}
