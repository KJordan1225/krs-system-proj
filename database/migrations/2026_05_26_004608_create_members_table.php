<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();

            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state', 2)->nullable();
            $table->string('zip_code')->nullable();

            $table->enum('membership_status', [
                'active',
                'inactive',
                'pending',
                'suspended',
                'alumni',
            ])->default('active');

            $table->string('officer_position')->nullable();
            $table->string('committee')->nullable();

            $table->string('role_tracking')->nullable();

            $table->date('joined_at')->nullable();
            $table->text('membership_history')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
