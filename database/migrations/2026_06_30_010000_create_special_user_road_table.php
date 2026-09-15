<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSpecialUserRoadTable extends Migration
{
    public function up()
    {
        Schema::create('special_user_road', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('special_user_id');
            $table->unsignedInteger('main_road_id');
            $table->timestamps();

            $table->unique(['special_user_id', 'main_road_id']);
            $table->index('main_road_id');
        });

        $users = DB::table('special_user')
            ->whereIn('username', ['tnl001', 'tnl002'])
            ->pluck('id', 'username');

        $now = now();
        $rows = [];

        if (isset($users['tnl001'])) {
            $rows[] = [
                'special_user_id' => $users['tnl001'],
                'main_road_id' => 42,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (isset($users['tnl002'])) {
            $rows[] = [
                'special_user_id' => $users['tnl002'],
                'main_road_id' => 43,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if ($rows) {
            DB::table('special_user_road')->insert($rows);
        }
    }

    public function down()
    {
        Schema::dropIfExists('special_user_road');
    }
}
