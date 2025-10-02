<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $genres = [
            'Fiction',
            'Non-Fiction',
            'Mystery',
            'Science Fiction',
            'Biography',
            'Fantasy',
        ];

        return [
            'title'            => $this->faker->sentence(3),      // 3-word title
            'isbn'             => $this->faker->unique()->isbn13(), // unique ISBN
            'description'      => $this->faker->paragraph(4),     // 4-sentence description
            'author_id'        => $this->faker->numberBetween(15, 30),
            'genre'            => $this->faker->randomElement($genres), // pick from 6 genres
            'publish_at'       => $this->faker->date(),
            'total_copies'     => $this->faker->numberBetween(1, 20),
            'available_copies' => $this->faker->numberBetween(0, 20),
            'price'            => $this->faker->randomFloat(2, 5, 200),
            'cover_image'      => null, // per your instruction
            'status'           => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
