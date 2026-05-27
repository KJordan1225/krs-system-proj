<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('category')->nullable();
            $table->string('event_type')->nullable();

            $table->text('description')->nullable();
            $table->text('agenda')->nullable();

            $table->string('location')->nullable();
            $table->string('virtual_link')->nullable();

            $table->dateTime('starts_at');
            $table->dateTime('ends_at')->nullable();
            $table->boolean('is_multi_day')->default(false);
            $table->boolean('is_recurring')->default(false);

            $table->enum('visibility', ['public', 'private'])->default('private');

            $table->enum('status', [
                'draft',
                'scheduled',
                'active',
                'completed',
                'cancelled',
            ])->default('draft');

            $table->string('host_committee')->nullable();
            $table->string('assigned_officer')->nullable();

            $table->integer('capacity')->nullable();
            $table->decimal('registration_fee', 10, 2)->default(0);
            $table->decimal('budget', 10, 2)->default(0);
            $table->decimal('expenses', 10, 2)->default(0);
            $table->decimal('revenue', 10, 2)->default(0);
            $table->decimal('donations', 10, 2)->default(0);

            $table->string('speaker')->nullable();
            $table->string('sponsor')->nullable();
            $table->string('vendor')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
