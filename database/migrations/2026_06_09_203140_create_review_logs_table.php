<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('review_logs', function (
            Blueprint $table
        ) {

            $table->id();

            $table->foreignId('book_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('reviewer_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('action');

            $table->text('remarks')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'review_logs'
        );
    }
};