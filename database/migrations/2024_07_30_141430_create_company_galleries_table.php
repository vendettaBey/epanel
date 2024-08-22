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
        Schema::create('company_galleries', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id')->unsigned();
            $table->string('type');
            $table->string('image');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_cover')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_galleries');
    }
};
