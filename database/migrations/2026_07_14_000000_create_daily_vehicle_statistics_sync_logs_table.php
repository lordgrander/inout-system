<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyVehicleStatisticsSyncLogsTable extends Migration
{
    public function up()
    {
        Schema::create('daily_vehicle_statistics_sync_logs', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('original_total')->default(0);
            $table->integer('available_total')->default(0);
            $table->integer('balanced_total')->default(0);
            $table->integer('missing_total')->default(0);
            $table->integer('updated_days')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->json('missing_statistics')->nullable();
            $table->longText('rows_json')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('daily_vehicle_statistics_sync_logs');
    }
}
