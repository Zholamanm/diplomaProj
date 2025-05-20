<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenreFactory extends Factory
{
    protected $model = Genre::class;

    private static $usedGenreNames = [];

    public function definition()
    {
        $category = Category::inRandomOrder()->first() ?? Category::factory()->create();

        $genreName = $this->generateUniqueGenreName($category->id, $category->name);

        return [
            'name' => $genreName,
            'category_id' => $category->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    private function generateUniqueGenreName(int $categoryId, string $categoryName): string
    {
        $genreNames = $this->getGenreNamesForCategory($categoryName);

        $key = $categoryId.'-'.$categoryName;

        if (!isset(self::$usedGenreNames[$key])) {
            self::$usedGenreNames[$key] = [];
        }

        // Get a name that hasn't been used yet for this category
        $availableNames = array_diff($genreNames, self::$usedGenreNames[$key]);

        if (empty($availableNames)) {
            // Fallback if we've used all predefined names
            $name = $this->faker->unique()->word;
        } else {
            $name = $this->faker->randomElement($availableNames);
        }

        self::$usedGenreNames[$key][] = $name;

        return $name;
    }

    private function getGenreNamesForCategory(string $categoryName): array
    {
        return match (strtolower($categoryName)) {
            'non-fiction' => [
                'Biography', 'History', 'Self-Help',
                'Science', 'Travel', 'True Crime',
                'Business', 'Health', 'Psychology'
            ],
            'science & technology' => [
                'Artificial Intelligence', 'Physics', 'Biology',
                'Space Exploration', 'Programming', 'Mathematics',
                'Engineering', 'Chemistry', 'Neuroscience'
            ],
            'biography' => [
                'Autobiography', 'Memoir', 'Celebrity Biography',
                'Political Biography', 'Sports Biography', 'Literary Biography'
            ],
            'history' => [
                'Ancient History', 'Medieval History',
                'World War II', 'Cultural History',
                'Military History', 'Economic History'
            ],
            default => [
                $this->faker->unique()->word,
                $this->faker->unique()->word,
                $this->faker->unique()->word
            ],
        };
    }
}
