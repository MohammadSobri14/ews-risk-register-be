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
        Schema::create('causes', function (Blueprint $table) {
            $table->id();
            $table->uuid('risk_id');
            $table->enum('category', ['man', 'machine', 'material', 'method', 'environment']); 
            $table->text('main_cause'); 
            $table->timestamps();
            $table->foreign('risk_id')->references('id')->on('risks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('causes');
    }
};