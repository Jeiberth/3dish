<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dish_dish_groups', function (Blueprint $table) {
            $table->foreignId('dish_id')->constrained()->onDelete('cascade');
            $table->foreignId('dish_group_id')->constrained()->onDelete('cascade');
            $table->primary(['dish_id', 'dish_group_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dish_dish_groups');
    }
};
