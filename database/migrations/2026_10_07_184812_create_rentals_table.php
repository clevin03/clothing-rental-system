<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->restrictOnDelete();
            $table->foreignId('clothing_item_id')->constrained('clothing_items')->restrictOnDelete();
            $table->foreignId('staff_id')->constrained('users')->restrictOnDelete();
            
            // Workflow & Dates (AC 3)
            $table->date('start_date');
            $table->date('end_date');
            $table->dateTime('actual_return_date')->nullable();
            
            // Financials & Status
            $table->decimal('total_amount', 10, 2);
            $table->decimal('deposit_amount', 10, 2);
            $table->decimal('late_fee', 10, 2)->default(0.00);
            $table->decimal('damage_penalty_fee', 10, 2)->default(0.00);
            
            $table->enum('status', ['Pending', 'Active', 'Completed', 'Overdue'])->default('Pending');
            $table->text('condition_notes')->nullable();
            
            $table->timestamps();

            // Indexing for rapid double-booking checks & overdue querying
            $table->index(['clothing_item_id', 'start_date', 'end_date', 'status']);
            $table->index(['status', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};