<?php
// database/factories/TagFactory.php
namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    // Common book tags
    public function common()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => $this->faker->randomElement([
                    'New Release',
                ]),
            ];
        });
    }
}
