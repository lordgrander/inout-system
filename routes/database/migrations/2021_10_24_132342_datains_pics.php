<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DatainsPics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datains_pics', function (Blueprint $table) {
            $table->id(); 
            $table->integer('in_id')->nullable();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('main_file_path',2048);  
            $table->string('pic_name');   
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
