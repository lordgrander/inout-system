<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTakeVisibleToSpecialUserTable extends Migration
{
    public function up()
    {
        Schema::table('special_user', function (Blueprint $table) {
            if (!Schema::hasColumn('special_user', 'take_visible')) {
                $table->enum('take_visible', ['0', '1', 'all'])->default('1')->after('status');
            }
        });
    }

    public function down()
    {
        Schema::table('special_user', function (Blueprint $table) {
            if (Schema::hasColumn('special_user', 'take_visible')) {
                $table->dropColumn('take_visible');
            }
        });
    }
}
