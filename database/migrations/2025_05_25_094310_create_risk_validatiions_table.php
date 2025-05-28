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
        Schema::create('risk_validations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('risk_id');
            $table->foreign('risk_id')->references('id')->on('risks')->onDelete('cascade');
            
            $table->foreignId('validated_by')->constrained('users')->onDelete('cascade'); 
            
            $table->boolean('is_approved');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_validatiions');
    }
};