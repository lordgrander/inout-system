<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Remember extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('remembers', function (Blueprint $table) {
            $table->id(); 
            $table->integer('link_id')->nullable();
            $table->foreignId('user_id')->nullable()->index(); 
            $table->string('type');      //? In, out
            $table->string('object');   //? Delete, Update, Edit
            $table->string('subject'); //? Do what?  
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
        //
    }
}
