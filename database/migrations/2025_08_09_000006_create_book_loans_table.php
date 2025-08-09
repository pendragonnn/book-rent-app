<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('book_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_item_id')->constrained()->onDelete('cascade');
            $table->date('loan_date');
            $table->date('due_date');
            $table->enum('status', ['payment_pending', 'admin_validation', 'cancelled', 'borrowed', 'returned'])
                  ->default('payment_pending');
            $table->decimal('total_price', 10, 2)->nullable();
            $table->string('payment_proof')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('book_loans');
    }
};

