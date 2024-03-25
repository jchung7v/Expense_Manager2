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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('vendor')->nullable();
            $table->decimal('withdraw', 8, 2)->nullable();
            $table->decimal('deposit', 8, 2)->nullable();
            $table->decimal('balance', 10, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('buckets', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable();
            $table->string('vendor')->nullable();
            $table->unique(['category', 'vendor']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('buckets');
    }
};
