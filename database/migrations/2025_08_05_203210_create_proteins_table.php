<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proteins', function (Blueprint $table) {
            $table->id();
            $table->enum('name', ['Chicken', 'Beef', 'Fish', 'Seafood', 'Tofu', 'Vegetables']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proteins');
    }
};
