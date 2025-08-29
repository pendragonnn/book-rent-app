<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('book_loan_receipt_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receipt_id')->nullable()->constrained('book_loan_receipts')->nullOnDelete();
            $table->foreignId('loan_id')->nullable()->constrained('book_loans')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('book_loan_receipt_items');
    }
};
