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

        // return "https://www.anapioficeandfire.com/api/books?name={$name}";
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
}