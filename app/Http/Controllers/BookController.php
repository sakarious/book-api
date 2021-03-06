<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Book;
use Validator;

class BookController extends Controller
{
    // External API
    function index(Request $request){
        //Require name query parameter
        $rules = [
            'name' => "required"
        ];

        //Check validation and use a custom message
        $validator = Validator::make($request->query(), $rules, $messages = [
            'required' =>'The :attribute query parameter field is required'
        ]);

        //If validation fails, Send appropriate json response
        if($validator->fails()){
            $jsonRes = [
                "message" => "Validation Failed",
                "errors" => $validator->errors()
            ];
            return response()->json($jsonRes, 200);
        }
        
        //If validation passes, assign name from query parameter to variable name
        $name = $request->query('name');

        //Set name and use external service
        $response = Http::get("https://www.anapioficeandfire.com/api/books?name={$name}");

        //Check if book was not found and send appropriate json response
        if($response ==  "[]"){
            $jsonRes = [
                "status_code" => 200,
                "status" => "success",
                "data" => []
            ];
            return response()->json($jsonRes, 200);
        }

        //If book was found, Get required fields and send json response
        $jsonRes = array(
            "status_code" => 200,
            "status" => "success",
            "data" => array(
                "name" => $response[0]["name"],
                "isbn" => $response[0]["isbn"],
                "authors" => $response[0]["authors"],
                "number_of_pages" => $response[0]["numberOfPages"],
                "publisher" => $response[0]["publisher"],
                "country" => $response[0]["country"],
                "release_date" => $response[0]["released"]
       
            )
        );

        return response()->json($jsonRes, 200);
    }

    //Create Book
    function create(Request $request){
        //Set Validation Rules
        // name
        // isbn
        // authors 
        // country
        // number_of_pages
        // publisher
        // release_date

        $rules = [
            'name' => "required",
            'isbn' => "required",
            'authors' => "required",
            'country' => "required",
            'number_of_pages' => "required",
            'publisher' => "required",
            'release_date' => "required",
        ];

        //Run validation
        $validator = Validator::make($request->all(), $rules);

        //If validation fails, Send appropriate json response
        if($validator->fails()){
            $jsonRes = [
                "message" => "Validation Failed",
                "errors" => $validator->errors()
            ];
            return response()->json($jsonRes, 200);
        }

        //If validation passes, assign fields from input to variables
        $name = $request->input('name');
        $isbn = $request->input('isbn');
        $authors = $request->input('authors');
        $authorArray = explode(",",$authors);
        $country = $request->input('country');
        $number_of_pages = $request->input('number_of_pages');
        $publisher = $request->input('publisher');
        $release_date = $request->input('release_date');

        //Create new Book in the database
        Book::create([
            'name' => $name,
            'isbn' => $isbn,
            'authors' => $authorArray,
            'country' => $country,
            'number_of_pages' => $number_of_pages,
            'publisher' => $publisher,
            'release_date' => $release_date
        ]);

        //Send appropriate json response and status code
        $jsonRes = array(
            "status_code" => 201,
            "status" => "success",
            "data" => array(
                "book" => array(
                    "name" => $name,
                    "isbn" => $isbn,
                    "authors" => $authorArray,
                    "number_of_pages" => $number_of_pages,
                    "publisher" => $publisher,
                    "country" => $country,
                    "release_date" => $release_date
                )
            )

        );

        return response()->json($jsonRes, 201);

    }

    //READ BOOK
    function read(Request $request){
        //SEARCH BY NAME
        
        //if name is present in query parameter
        if($request->query('name')){
            //Assign name from query parameter to variable
            $name = $request->query('name');
            //Search for book in database  where name is the name given
            $books = Book::where("name", $name)->get();
            //if book was not found and send appropriate json response
            if ($books == '[]'){
                $jsonRes = array(
                    "status_code" => 200,
                    "status" => "success",
                    "data" => []
                );
                return response()->json($jsonRes, 200);
            }
            //if book was found, send json response
            $jsonRes = array(
                "status_code" => 200,
                "status" => "success",
                "data" => $books
            );
            return response()->json($jsonRes, 200);
        }


        //SEARCH BY COUNTRY

        //if country is present in query parameter
        if($request->query('country')){
            //Assign country from query parameter to variable
            $country = $request->query('country');
            //Search for book in database  where country is the country given
            $books = Book::where("country", $country)->get();
            //if book was not found and send appropriate json response
            if ($books == '[]'){
                $jsonRes = array(
                    "status_code" => 200,
                    "status" => "success",
                    "data" => []
                );
                return response()->json($jsonRes, 200);
            }
    
            //if book was found, send json response
            $jsonRes = array(
                "status_code" => 200,
                "status" => "success",
                "data" => $books
            );
            return response()->json($jsonRes, 200);
        }

         //SEARCH BY PUBLISHER

         //if publisher is present in query parameter
         if($request->query('publisher')){
             //Assign publisher from query parameter to variable
            $publisher = $request->query('publisher');
            //Search for book in database  where publisher is the publisher given
            $books = Book::where("publisher", $publisher)->get();
            //if book was not found and send appropriate json response
            if ($books == '[]'){
                $jsonRes = array(
                    "status_code" => 200,
                    "status" => "success",
                    "data" => []
                );
                return response()->json($jsonRes, 200);
            }
    
            //if book was found, send json response
            $jsonRes = array(
                "status_code" => 200,
                "status" => "success",
                "data" => $books
            );
            return response()->json($jsonRes, 200);
        }

        //SEARCH BY RELEASE YEAR

        //if year is present in query parameter
        if($request->query('release_year')){
            //Assign year from query parameter to variable
            $releaseYear = $request->query('release_year');
            //Cast $releaseYear to integer
            $intYear = (int)$releaseYear;
            //Search for book in database  where year is the year given
            $books = Book::whereYear('release_date', '=', $intYear)->get();
            //if book was not found and send appropriate json response
            if ($books == '[]'){
                $jsonRes = array(
                    "status_code" => 200,
                    "status" => "success",
                    "data" => []
                );
                return response()->json($jsonRes, 200);
            }
    
            //if book was found, send json response
            $jsonRes = array(
                "status_code" => 200,
                "status" => "success",
                "data" => $books
            );
            return response()->json($jsonRes, 200);
        }

        //If none of the query parameters to be searched by are found, Return all books in database
        $books = Book::all();
        //if no book present, send appropriate json response
        if ($books == '[]'){
            $jsonRes = array(
                "status_code" => 200,
                "status" => "success",
                "data" => []
            );
            return response()->json($jsonRes, 200);
        }
        //if book found, send json response
        $jsonRes = array(
            "status_code" => 200,
            "status" => "success",
            "data" => $books
        );
        return response()->json($jsonRes, 200);
    }

    //UPDATE BOOK
    function update(Request $request, $id){
        // name
        // isbn
        // authors 
        // country
        // number_of_pages
        // publisher
        // release_date

        //Set Validation rules
        $rules = [
            'name' => "required",
            'isbn' => "required",
            'authors' => "required",
            'country' => "required",
            'number_of_pages' => "required",
            'publisher' => "required",
            'release_date' => "required",
        ];

        //Run validation
        $validator = Validator::make($request->all(), $rules);

        //if validation fails, send appropriate json response
        if($validator->fails()){
            $jsonRes = [
                "message" => "Validation Failed",
                "errors" => $validator->errors()
            ];
            return response()->json($jsonRes, 200);
        }

        //If validation passes, assign input fields to variables
        $name = $request->input('name');
        $isbn = $request->input('isbn');
        $authors = $request->input('authors');
        $authorArray = explode(",",$authors);
        $country = $request->input('country');
        $number_of_pages = $request->input('number_of_pages');
        $publisher = $request->input('publisher');
        $release_date = $request->input('release_date');

        //Find book by id in the db
        $checkBook = Book::find($id);
        
        //if book is found update book and send json response
        if ($checkBook){
                $checkBook->name = $name;
                $checkBook->isbn = $isbn;
                $checkBook->authors = $authorArray;
                $checkBook->country = $country;
                $checkBook->number_of_pages = $number_of_pages;
                $checkBook->publisher = $publisher;
                $checkBook->release_date = $release_date;
                $saved = $checkBook->save();
                
                if($saved) {
                    $book = Book::find($id);

                    $jsonRes = array(
                        "status_code" => 200,
                        "status" => "success",
                        "message" => "The book $book->name was updated successfully",
                        "data" => $book
                    );

                    return response()->json($jsonRes, 200);
                }
        }

        //if book is not found, send appropriate response
        $jsonRes = array(
            "status_code" => 200,
            "status" => "success",
            "message" => "Book not Found",
            "data" => []
        );
        return response()->json($jsonRes, 200);
    }

    //DELETE BOOK
    function delete($id){
        //Find book by id given
        $checkBook = Book::find($id);

        //if book is found, delete book and send appropriate json response
        if ($checkBook){
            $deleted = $checkBook->delete();

            if($deleted){
                $jsonRes = array(
                    "status_code" => 204,
                    "status" => "success",
                    "message" => "The book ???My first book??? was deleted successfully",
                    "data" => []
                );

                return response()->json($jsonRes, 200);
            }
        }

        //if book is not found, send appropriate response
        $jsonRes = array(
            "status_code" => 200,
            "status" => "success",
            "message" => "Book not Found",
            "data" => []
        );
        return response()->json($jsonRes, 200);
    }

    //SHOW BOOK
    function show($id){
        //Find book by id given
        $book = Book::find($id);

        //if book is found, send appropriate json response
        if($book){
            $jsonRes = array(
                "status_code" => 200,
                "status" => "success",
                "data" => $book
            );
            return response()->json($jsonRes, 200);
        }

        //If book is not found, send appropriate json response
        $jsonRes = array(
            "status_code" => 200,
            "status" => "success",
            "message" => "Book not Found",
            "data" => []
        );

        return response()->json($jsonRes, 200);
    }
}