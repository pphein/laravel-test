<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book_author', function (Blueprint $table) {
            // $table->id();
            $table->foreignId('book_id')->constrained()->onDelete('cascade'); // Ensures referential integrity
            $table->foreignId('author_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        
            // Add a composite primary key
            $table->primary(['book_id', 'author_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_author');
    }
};
