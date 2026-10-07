<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_id')->constrained('rentals')->cascadeOnDelete();
            $table->foreignId('staff_id')->constrained('users')->restrictOnDelete();
            
            $table->decimal('amount_paid', 10, 2);
            $table->enum('payment_method', ['Cash', 'Bank Transfer']);
            $table->enum('payment_type', ['Advance', 'Full Payment', 'Deposit', 'Late/Damage Penalty'])->default('Advance');
            $table->dateTime('transaction_date')->useCurrent();
            $table->string('reference_number')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};