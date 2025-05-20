<?php
namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition()
    {
        $category = Category::inRandomOrder()->first() ?? Category::factory()->create();

        return [
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name,
            'description' => $this->faker->paragraph(3),
            'category_id' => $category->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    // Attach genres and tags to books
    public function configure()
    {
        return $this->afterCreating(function (Book $book) {
            // Attach 1-3 random genres from the book's category
            $genres = $book->category->genres()->inRandomOrder()->take(rand(1, 3))->pluck('id');
            $book->genres()->attach($genres);

            // Attach 2-5 random tags
            $tags = \App\Models\Tag::inRandomOrder()->take(rand(2, 5))->pluck('id');
            $book->tags()->attach($tags);
        });
    }
}
