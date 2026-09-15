<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewUserTaskWorkflowFields extends Migration
{
    public function up()
    {
        Schema::table('new_enters', function (Blueprint $table) {
            if (!Schema::hasColumn('new_enters', 'feed_back_msg')) {
                $table->text('feed_back_msg')->nullable()->after('cancel_log');
            }
        });

        if (!Schema::hasTable('new_enter_road_details')) {
            Schema::create('new_enter_road_details', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('new_enter_id');
                $table->unsignedBigInteger('road_id');
                $table->timestamps();

                $table->index(['new_enter_id', 'road_id']);
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('new_enter_road_details');

        Schema::table('new_enters', function (Blueprint $table) {
            if (Schema::hasColumn('new_enters', 'feed_back_msg')) {
                $table->dropColumn('feed_back_msg');
            }
        });
    }
}
