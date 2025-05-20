<?php
namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->randomElement([
                'Non-Fiction',
                'Science & Technology',
                'Biography',
                'History',
                'Fantasy',
                'Mystery'
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
