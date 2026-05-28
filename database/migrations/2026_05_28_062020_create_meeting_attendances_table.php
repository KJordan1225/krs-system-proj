<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meeting_attendances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('meeting_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('member_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('status')->default('Present');
            $table->dateTime('checked_in_at')->nullable();
            $table->boolean('is_excused')->default(false);
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique(['meeting_id', 'member_id']);
            $table->index(['member_id', 'status']);
            $table->index(['meeting_id', 'status']);
            $table->index('checked_in_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meeting_attendances');
    }
};
