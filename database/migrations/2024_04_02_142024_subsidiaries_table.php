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
        Schema::create('subsidiaries', function (Blueprint $table) {
            $table->id();
            $table->string('name',255)->nullable(false);
            $table->string('rif',255)->nullable(false);
            $table->string('ubication',255)->nullable(false);
            $table->foreignId('enterprise_id')->references('id')->on('enterprises')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subsidiaries');
    }
};
