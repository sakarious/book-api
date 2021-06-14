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

        $validator = Validator::make($request->query(), $rules, $messages = [
            'required' =>'The :attribute query parameter field is required'
        ]);

        if($validator->fails()){
            return $validator->errors();
        }
        
        $name = $request->query('name');

        $response = Http::get("https://www.anapioficeandfire.com/api/books?name={$name}");

        if($response ==  "[]"){
            $jsonRes = [
                "status_code" => 200,
                "status" => "success",
                "data" => []
            ];
            return response()->json($jsonRes, 200);
        }

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

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return $validator->errors();
        }

        $name = $request->input('name');
        $isbn = $request->input('isbn');
        $authors = $request->input('authors');
        $authorArray = explode(",",$authors);
        $country = $request->input('country');
        $number_of_pages = $request->input('number_of_pages');
        $publisher = $request->input('publisher');
        $release_date = $request->input('release_date');

        Book::create([
            'name' => $name,
            'isbn' => $isbn,
            'authors' => $authorArray,
            'country' => $country,
            'number_of_pages' => $number_of_pages,
            'publisher' => $publisher,
            'release_date' => $release_date
        ]);

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

    function read(Request $request){
        //SEARCH BY NAME
        if($request->query('name')){
            $name = $request->query('name');
            $books = Book::where("name", $name)->get();
            if ($books == '[]'){
                $jsonRes = array(
                    "status_code" => 200,
                    "status" => "success",
                    "data" => []
                );
                return response()->json($jsonRes, 200);
            }
    
            $jsonRes = array(
                "status_code" => 200,
                "status" => "success",
                "data" => $books
            );
            return response()->json($jsonRes, 200);
        }


        //SEARCH BY COUNTRY
        if($request->query('country')){
            $country = $request->query('country');
            $books = Book::where("country", $country)->get();
            if ($books == '[]'){
                $jsonRes = array(
                    "status_code" => 200,
                    "status" => "success",
                    "data" => []
                );
                return response()->json($jsonRes, 200);
            }
    
            $jsonRes = array(
                "status_code" => 200,
                "status" => "success",
                "data" => $books
            );
            return response()->json($jsonRes, 200);
        }

         //SEARCH BY PUBLISHER
         if($request->query('publisher')){
            $publisher = $request->query('publisher');
            $books = Book::where("publisher", $publisher)->get();
            if ($books == '[]'){
                $jsonRes = array(
                    "status_code" => 200,
                    "status" => "success",
                    "data" => []
                );
                return response()->json($jsonRes, 200);
            }
    
            $jsonRes = array(
                "status_code" => 200,
                "status" => "success",
                "data" => $books
            );
            return response()->json($jsonRes, 200);
        }

        //SEARCH BY RELEASE YEAR
        if($request->query('release_year')){
            $releaseYear = $request->query('release_year');
            //Cast $releaseYear to integer
            $intYear = (int)$releaseYear;
            $books = Book::whereYear('release_date', '=', $intYear)->get();
            if ($books == '[]'){
                $jsonRes = array(
                    "status_code" => 200,
                    "status" => "success",
                    "data" => []
                );
                return response()->json($jsonRes, 200);
            }
    
            $jsonRes = array(
                "status_code" => 200,
                "status" => "success",
                "data" => $books
            );
            return response()->json($jsonRes, 200);
        }

        $books = Book::all();
        if ($books == '[]'){
            $jsonRes = array(
                "status_code" => 200,
                "status" => "success",
                "data" => []
            );
            return response()->json($jsonRes, 200);
        }

        $jsonRes = array(
            "status_code" => 200,
            "status" => "success",
            "data" => $books
        );
        return response()->json($jsonRes, 200);
    }
}