<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clothing_items', function (Blueprint $table) {
            $table->id();
            $table->string('item_code', 50)->unique();
            $table->string('name', 150);
            $table->string('category', 50);
            $table->string('size', 10);
            $table->decimal('rental_price_per_day', 10, 2);
            $table->decimal('security_deposit', 10, 2);
            $table->enum('status', ['Available', 'Rented', 'Maintenance'])->default('Available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clothing_items');
    }
};