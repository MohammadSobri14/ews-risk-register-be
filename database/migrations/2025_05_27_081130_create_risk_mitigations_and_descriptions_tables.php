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
        Schema::create('risk_mitigations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('risk_id')->constrained('risks')->onDelete('cascade');
            $table->enum('mitigation_type', ['regulasi', 'sdm', 'sarana_prasarana']);
            $table->unsignedBigInteger('pic_id');
            $table->foreign('pic_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('deadline');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('mitigation_descriptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('mitigation_id')->constrained('risk_mitigations')->onDelete('cascade');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('mitigation_descriptions');
        Schema::dropIfExists('risk_mitigations');
    }
};