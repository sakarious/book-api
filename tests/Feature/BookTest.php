<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * External API call will show an error if query parameter isnt present.
     *
     * 
     */
    public function test_cannot_call_external_api_if_query_name_isnt_present()
    {
        $response = $this->json('GET', 'api/external-books');

        $response->assertStatus(200);
        $response->assertJson([
            "message" => "Validation Failed",
            "errors" => [
                "name" => ["The name query parameter field is required"],
            ]
            ]);
    }

    /**
     * External API Test
     *
     * 
     */
    public function test_will_return_a_book_if_query_parameter_name_is_present_and_book_is_found()
    {
        $response = $this->json('GET', 'api/external-books?name=a game of thrones');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "status_code",
            "status",
            "data" => [
                "name",
                "isbn",
                "authors",
                "number_of_pages",
                "publisher",
                "country",
                "release_date"
            ]
            ]);
    }

     /**
     * External API Test
     *
     * 
     */
    public function test_will_return_a_sucess_and_empty_data_array_if_validation_passes_but_no_book_is_found()
    {
        $response = $this->json('GET', 'api/external-books?name=a game of thrones by Sakarious');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "status_code",
            "status",
            "data"
            ]);
    }
    
    /**
     * Create Book Test
     *
     * 
     */
    public function test_cannot_create_book_without_required_fields()
    {
        $response = $this->json('POST', '/api/v1/books');

        $response->assertStatus(200);
        $response->assertJson([
            "message" => "Validation Failed",
            "errors" => [
                "name" => ["The name field is required."],
                "isbn" => ["The isbn field is required."],
                "authors" => ["The authors field is required."],
                "country" => ["The country field is required."],
                "number_of_pages" => ["The number of pages field is required."],
                "publisher" => ["The publisher field is required."],
                "release_date" => ["The release date field is required."]
            ]

            ]);
    }

    /**
     * Create Book Test.
     *
     * 
     */
    public function test_will_create_book()
    {
        $book = [
            'name' => 'Sakarious',
            'isbn' => '123-432-21',
            'authors' => 'Sakarious', 'Da Genius',
            'country' => 'Nigeria',
            'number_of_pages' => 122,
            'publisher' => 'Oluwashegs',
            'release_date' => '2019-01-01'
        ];
        
        $response = $this->json('POST', '/api/v1/books', $book, ['Accept' => 'application/json']);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            "status_code",
            "status",
            "data" => [
                "book" => [
                    "name",
                    "isbn",
                    "authors",
                    "number_of_pages",
                    "publisher",
                    "country",
                    "release_date"
                ]
            ]
            ]);
    }

    /**
     * Read Book Test
     *
     * 
     */
    public function test_returns_an_empty_data_array_if_database_is_empty()
    {
        $response = $this->json('GET', '/api/v1/books');

        $response->assertStatus(200);
        $response->assertJson([
            "status_code" => 200,
            "status" => "success",
            "data" => []
            ]);
    }

    /**
     * Read Book Test.
     *
     * 
     */
    public function test_will_send_all_books_present_in_the_application()
    {
        $book = new Book();
        $book->name = "New Book";
        $book->isbn = "123-3231";
        $book->authors = ["Da Genius"];
        $book->country = "Nigeria";
        $book->number_of_pages = "102";
        $book->publisher = "Da Genius";
        $book->release_date = "2019-01-01";

        $savedBook = $book->save();
        
        $response = $this->json('GET', '/api/v1/books');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "status_code",
            "status",
            "data"
            ]);
    }

    /**
     * Read Book Test.
     *
     * 
     */
    public function test_can_search_for_books_by_name_in_the_application()
    {
        $book = new Book();
        $book->name = "New Book";
        $book->isbn = "123-3231";
        $book->authors = ["Da Genius"];
        $book->country = "Nigeria";
        $book->number_of_pages = "102";
        $book->publisher = "Da Genius";
        $book->release_date = "2019-01-01";
        $book->save();

        $book1 = new Book();
        $book1->name = "Sakarious";
        $book1->isbn = "123-3231";
        $book1->authors = "Da Genius";
        $book1->country = "Nigeria";
        $book1->number_of_pages = "102";
        $book1->publisher = "Da Genius";
        $book1->release_date = "2019-01-01";
        $book1->save();
        
        $response = $this->json('GET', '/api/v1/books?name=Sakarious');

        $response->assertStatus(200);
        $response->assertJson([
            "status_code" => 200,
            "status" => "success",
            "data" => [
                [
                "id" => 2,
                "name" => "Sakarious",
                "isbn" => "123-3231",
                "authors" => "Da Genius",
                "country" => "Nigeria",
                "number_of_pages" => "102",
                "publisher" => "Da Genius",
                "release_date" => "2019-01-01"
                ]
            ]
            ]);
    }

    /**
     * Read Book Test.
     *
     * 
     */
    public function test_can_search_for_books_by_country_in_the_application()
    {
        $book = new Book();
        $book->name = "New Book";
        $book->isbn = "123-3231";
        $book->authors = ["Da Genius"];
        $book->country = "New York";
        $book->number_of_pages = "102";
        $book->publisher = "Da Genius";
        $book->release_date = "2019-01-01";
        $book->save();

        $book1 = new Book();
        $book1->name = "Sakarious";
        $book1->isbn = "123-3231";
        $book1->authors = "Da Genius";
        $book1->country = "Nigeria";
        $book1->number_of_pages = "102";
        $book1->publisher = "Da Genius";
        $book1->release_date = "2019-01-01";
        $book1->save();
        
        $response = $this->json('GET', '/api/v1/books?country=Nigeria');

        $response->assertStatus(200);
        $response->assertJson([
            "status_code" => 200,
            "status" => "success",
            "data" => [
                [
                "id" => 2,
                "name" => "Sakarious",
                "isbn" => "123-3231",
                "authors" => "Da Genius",
                "country" => "Nigeria",
                "number_of_pages" => "102",
                "publisher" => "Da Genius",
                "release_date" => "2019-01-01"
                ]
            ]
            ]);
    }
}