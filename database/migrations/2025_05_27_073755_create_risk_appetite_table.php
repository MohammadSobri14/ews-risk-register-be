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
        Schema::create('risk_appetite', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('risk_id' )->constrained('risks')->onDelete('cascade');
            $table->unsignedTinyInteger('controllability');
            $table->enum('decision', ['accepted', 'mitigated'])->nullable();
            $table->unsignedInteger('scoring')->nullable(); // P � S � C
            $table->unsignedInteger('ranking')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_appetite');
    }
};
