<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('inn')->unique(); 
            $table->string('country'); 
            $table->string('registration_address'); 
            $table->string('postal_address'); 
            $table->string('city'); 
            $table->string('rate');
            $table->string('email')->nullable(); 
            $table->string('name'); 
            $table->string('phone')->nullable(); 
            $table->text('activity')->nullable();
            $table->integer('cargos_statistics_month')->default(0); 
            $table->integer('cargos_statistics_year')->default(0);
            $table->integer('cargos_statistics_all_time')->default(0);
            $table->timestamp('registered_at'); 
            $table->timestamp('last_login'); 
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