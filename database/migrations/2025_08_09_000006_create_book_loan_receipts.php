<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('book_loan_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('payment_method', ['bank_transfer','ewallet','cash']);
            $table->decimal('total_price', 10, 2);
            $table->string('payment_proof')->nullable();
            $table->enum('status', ['pending','paid','verified','rejected','cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('book_loan_receipts');
    }
};
