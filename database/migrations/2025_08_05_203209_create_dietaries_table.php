<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dietaries', function (Blueprint $table) {
            $table->id();
            $table->enum('name', ['Vegan', 'Vegetarian', 'Pescatarian', 'Halal', 'Kosher', 'Gluten-Free', 'Dairy-Free']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dietaries');
    }
};
