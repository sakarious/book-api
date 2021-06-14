<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // name
        // isbn
        // authors 
        // country
        // number_of_pages
        // publisher
        // release_date

        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("isbn");
            $table->string("authors");
            $table->string("country");
            $table->integer("number_of_pages");
            $table->string("publisher");
            $table->string("release_date");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}