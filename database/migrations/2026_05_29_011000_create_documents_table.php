<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('category')->nullable();
            $table->string('document_type')->nullable();
            $table->string('tags')->nullable();

            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_mime')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();

            $table->string('version')->default('1.0');
            $table->date('effective_date')->nullable();
            $table->date('expiration_date')->nullable();

            $table->string('approval_status')->default('Draft');
            $table->string('uploaded_by')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();

            $table->index('category');
            $table->index('document_type');
            $table->index('approval_status');
            $table->index('expiration_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
