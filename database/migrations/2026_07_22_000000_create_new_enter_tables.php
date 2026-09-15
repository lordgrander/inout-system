<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewEnterTables extends Migration
{
    public function up()
    {
        Schema::create('new_enters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('com_id')->nullable();
            $table->string('enter_number')->default('0');
            $table->string('sign_status')->default('0');
            $table->string('take', 10)->default('0');
            $table->dateTime('date_make')->nullable();
            $table->dateTime('date_in')->nullable();
            $table->dateTime('date_out')->nullable();
            $table->string('status', 30)->default('WAITING');
            $table->decimal('price', 12, 2)->default(0);
            $table->text('lasttails')->nullable();
            $table->string('slug', 80)->unique();
            $table->string('address')->nullable();
            $table->string('district')->nullable();
            $table->string('province')->nullable();
            $table->unsignedBigInteger('main_road_id')->nullable();
            $table->text('cancel_log')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['com_id', 'date_make']);
        });

        Schema::create('new_enter_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('new_enter_id');
            $table->unsignedBigInteger('user_id');
            $table->string('plate_number');
            $table->string('driver_name');
            $table->unsignedBigInteger('vehicle_type_id');
            $table->unsignedTinyInteger('rounds')->default(1);
            $table->string('import_product');
            $table->string('import_document_no');
            $table->decimal('weight_kg', 12, 2)->default(0);
            $table->string('watchlist_status', 10)->default('NO');
            $table->string('status', 30)->default('0');
            $table->timestamps();

            $table->index(['new_enter_id', 'user_id']);
            $table->index('vehicle_type_id');
            $table->index('watchlist_status');
        });

        Schema::create('new_enter_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('new_enter_id');
            $table->unsignedBigInteger('user_id');
            $table->date('date')->nullable();
            $table->string('file_url');
            $table->string('original_name')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->string('mime_type')->nullable();
            $table->timestamps();

            $table->index(['new_enter_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('new_enter_files');
        Schema::dropIfExists('new_enter_details');
        Schema::dropIfExists('new_enters');
    }
}
