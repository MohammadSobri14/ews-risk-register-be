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
        Schema::create('risks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('cluster');
            $table->string('unit');
            $table->string('name');
            $table->string('category');
            $table->text('description');
            $table->unsignedTinyInteger('impact');
            $table->boolean('uc_c')->default(false);
            $table->enum('status', [
                'draft', 
                'pending', 
                'validated', 
                'rejected',
                'validated_approved',
                'validated_rejected'
            ])->default('draft');            
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk');
    }
};