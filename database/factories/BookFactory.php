<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // Fake Data
            'name' => 'Sakarious',
            'isbn' => '123-432-21',
            'authors' => 'Sakarious', 'Da Genius',
            'country' => 'Nigeria',
            'number_of_pages' => 122,
            'publisher' => 'Oluwashegs',
            'release_date' => '2019-01-01'
        ];
    }
}