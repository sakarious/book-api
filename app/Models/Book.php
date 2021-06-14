<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $casts = [
        "authors" => "array"
    ];

    //For Update 
    // name
    // isbn
    // authors 
    // country
    // number_of_pages
    // publisher
    // release_date

    protected $fillable = ["name", "isbn", "authors", "country", "number_of_pages", "publisher", "release_date"];
}