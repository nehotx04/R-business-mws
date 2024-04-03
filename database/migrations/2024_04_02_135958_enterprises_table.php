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
        Schema::create('enterprises', function (Blueprint $table) {
            $table->id();
            $table->string('name',255)->nullable(false);
            $table->string('rif',255)->unique()->nullable(false);
            $table->string('owner_name',255)->nullable(false);
            $table->string('owner_lastname',255)->nullable(false);
            $table->string('owner_dni',255)->nullable(false);
            $table->string('owner_phone',255)->nullable(false);
            $table->string('email',255)->unique()->nullable(false);
            $table->string('password',255)->nullable(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enterprises');
    }
};
