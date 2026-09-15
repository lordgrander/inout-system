<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateSpecialUserTable extends Migration
{
    public function up()
    {
        Schema::create('special_user', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('name')->nullable();
            $table->string('password');
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
        });

        DB::table('special_user')->insert([
            [
                'username' => 'tnl001',
                'name' => 'TNL 001',
                'password' => Hash::make('@tnl2026.1'),
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'tnl002',
                'name' => 'TNL 002',
                'password' => Hash::make('@tnl2026.2'),
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('special_user');
    }
}
