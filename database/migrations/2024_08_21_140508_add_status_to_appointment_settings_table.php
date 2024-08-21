<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToAppointmentSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointment_settings', function (Blueprint $table) {
            $table->boolean('status')->default(true); // Gün aktif mi pasif mi?
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointment_settings', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}

