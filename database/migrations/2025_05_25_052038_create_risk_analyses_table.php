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
        Schema::create('risk_analyses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('risk_id');
            $table->unsignedTinyInteger('severity');
            $table->unsignedTinyInteger('probability');
            $table->unsignedSmallInteger('score');
            $table->string('grading');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();

            $table->foreign('risk_id')->references('id')->on('risks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_analyses');
    }
};