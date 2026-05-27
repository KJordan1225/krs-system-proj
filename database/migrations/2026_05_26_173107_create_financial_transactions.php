<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();

            $table->enum('type', ['income', 'expense'])->default('income');
            $table->string('category');
            $table->string('title');
            $table->text('description')->nullable();

            $table->decimal('amount', 12, 2);
            $table->date('transaction_date');

            $table->string('payment_method')->nullable();
            $table->string('reference_number')->nullable();

            $table->enum('status', ['draft', 'finalized'])->default('draft');

            $table->string('recorded_by')->nullable();
            $table->timestamp('finalized_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_transactions');
    }
};
