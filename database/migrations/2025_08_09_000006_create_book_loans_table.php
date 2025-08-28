<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('book_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_item_id')->constrained()->onDelete('cascade');
            $table->foreignId('receipt_id')->constrained()->onDelete('cascade');
            $table->date('loan_date');
            $table->date('due_date');
            $table->decimal('loan_price', 10, 2)->nullable();
            $table->enum('status', ['admin_validation', 'cancelled', 'borrowed', 'returned'])->default('admin_validation');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('book_loans');
    }
};

