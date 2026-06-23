<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Datain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('datains', function (Blueprint $table) {
            $table->id();
            $table->string('header'); 
            $table->string('doc_number')->nullable(); 
            $table->string('color'); 
            $table->foreignId('user_id')->nullable()->index();
            $table->integer('doc_type_id')->nullable();
            $table->text('info')->nullable(); 
            $table->string('main_file_path',2048);  
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
