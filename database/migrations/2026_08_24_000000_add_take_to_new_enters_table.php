<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTakeToNewEntersTable extends Migration
{
    public function up()
    {
        Schema::table('new_enters', function (Blueprint $table) {
            if (!Schema::hasColumn('new_enters', 'take')) {
                $table->string('take', 10)->default('0')->after('sign_status');
            }
        });
    }

    public function down()
    {
        Schema::table('new_enters', function (Blueprint $table) {
            if (Schema::hasColumn('new_enters', 'take')) {
                $table->dropColumn('take');
            }
        });
    }
}
