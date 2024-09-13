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
            $table->foreignId('employee_id')->constrained()->onDelete('cascade'); // Link to employee
            $table->json('work_days'); // Store selected work days as a JSON array
            $table->time('start_time'); // Workday start time
            $table->time('end_time'); // Workday end time
            $table->integer('time_slot'); // Slot interval in minutes
            $table->time('break_start_time')->nullable(); // Optional break start time
            $table->time('break_end_time')->nullable(); // Optional break end time
            $table->date('end_date'); // Apply slot setup until this date
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
