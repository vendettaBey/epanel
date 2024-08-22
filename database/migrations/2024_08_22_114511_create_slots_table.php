<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            $table->string('day_of_week'); // Pazartesi, Salı vb.
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('interval')->default(20); // Dakika cinsinden slot aralığı
            $table->time('break_start')->nullable(); // Mola başlangıç saati
            $table->time('break_end')->nullable();   // Mola bitiş saati
            $table->boolean('status')->default(true); // Slot aktif mi pasif mi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slots');
    }
};
