<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dues_periods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('starts_on');
            $table->date('ends_on');
            $table->decimal('standard_amount', 10, 2)->default(0);
            $table->decimal('late_fee_amount', 10, 2)->default(0);
            $table->date('late_fee_after')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('dues_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dues_period_id')->constrained('dues_periods')->cascadeOnDelete();

            $table->string('member_name');
            $table->string('member_email')->nullable();

            $table->decimal('amount_due', 10, 2)->default(0);
            $table->decimal('late_fee', 10, 2)->default(0);
            $table->decimal('amount_paid', 10, 2)->default(0);
            $table->date('paid_on')->nullable();

            $table->string('payment_method')->nullable();
            $table->string('reference_number')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique(
                ['dues_period_id', 'member_email', 'reference_number'],
                'unique_dues_payment_reference'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dues_payments');
        Schema::dropIfExists('dues_periods');
    }
};
