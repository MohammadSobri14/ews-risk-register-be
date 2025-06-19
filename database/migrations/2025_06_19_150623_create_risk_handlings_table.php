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
        Schema::create('risk_handlings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('risk_id');
            $table->unsignedBigInteger('handled_by');
            $table->enum('effectiveness', ['TE', 'KE', 'E']);
            
            $table->boolean('is_approved')->nullable(); 
            $table->text('review_notes')->nullable();  
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->string('approval_signature')->nullable();

            $table->timestamps();

            $table->foreign('risk_id')->references('id')->on('risks')->onDelete('cascade');
            $table->foreign('handled_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_handlings');
    }
};
