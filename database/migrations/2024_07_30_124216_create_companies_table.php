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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->text('company_description');
            $table->text('phone_numbers');
            $table->text('email_addresses');
            $table->text('address');
            $table->text('whyus');
            $table->text('vision');
            $table->text('mission');
            $table->integer('owner');
            $table->string('long')->nullable();
            $table->string('lat')->nullable();
            $table->string('apiKey')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
