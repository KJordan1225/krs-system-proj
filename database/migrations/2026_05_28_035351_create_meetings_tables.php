<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('meeting_type')->default('General');
            $table->dateTime('scheduled_at');
            $table->string('location')->nullable();
            $table->text('agenda')->nullable();
            $table->longText('minutes')->nullable();
            $table->text('motions')->nullable();
            $table->string('voting_outcome')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->string('recurrence_pattern')->nullable();
            $table->string('status')->default('Scheduled');
            $table->timestamps();
        });

        Schema::create('meeting_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained()->cascadeOnDelete();
            $table->string('task_title');
            $table->string('assigned_to')->nullable();
            $table->date('due_date')->nullable();
            $table->string('status')->default('Open');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meeting_tasks');
        Schema::dropIfExists('meetings');
    }
};
