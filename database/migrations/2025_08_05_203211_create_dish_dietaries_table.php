<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dish_dietaries', function (Blueprint $table) {
            $table->foreignId('dish_id')->constrained()->onDelete('cascade');
            $table->foreignId('dietary_id')->constrained()->onDelete('cascade');
            $table->primary(['dish_id', 'dietary_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dish_dietaries');
    }
};
