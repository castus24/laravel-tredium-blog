<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence();
        $content = $this->faker->text(rand(200, 300));
        $slug = Str::slug($title);
        $mainImageUrl = 'https://picsum.photos/800/600';
        $thumbnailImageUrl = 'https://picsum.photos/400/300';
        $published_at = $this->faker->dateTimeBetween('-1 year');

        return [
            'title' => $title,
            'content' => $content,
            'slug' => $slug,
            'main_image' => $mainImageUrl,
            'thumbnail_image' => $thumbnailImageUrl,
            'published_at' => $published_at,
        ];
    }
}
