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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('loading_country');
            $table->string('loading_index');
            $table->string('loading_city');
            $table->date('loading_date');
            $table->decimal('weight_tons', 8, 2);
            $table->decimal('volume_m3', 8, 2);
            $table->boolean('can_co_load')->default(false);
            $table->text('additional_info')->nullable();
            $table->string('unloading_country');
            $table->string('unloading_index');
            $table->string('unloading_city');
            $table->date('unloading_date');
            $table->decimal('price', 10, 2);
            $table->boolean('nds')->default(false);
            $table->boolean('prepayment')->default(false);
            $table->string('loading_type');
            $table->string('body_type');
            $table->string('status')->default('pending');
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};