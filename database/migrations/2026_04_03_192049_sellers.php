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
        Schema::create('sellers', function (Blueprint $table) {
            $table->string('id', 36)->unique()->primary();
            $table->string('name', 150)->unique()->index();
            $table->string('slug', 160)->unique()->index();
            $table->string('email', 150)->unique()->index();
            $table->string('password');
            $table->string('document', 20)->unique()->index();
            $table->string('legal_name', 150)->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_verified')->default(false);
            $table->text('logo_url')->nullable();
            $table->text('banner_url')->nullable();
            $table->text('description')->nullable();
            $table->string('currency', 10)->default('BRL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
