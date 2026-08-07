<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_movies_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable(); // sinopsis
            $table->string('cover_image')->nullable();
            $table->string('genre')->nullable(); // contoh: "Action, Crime, Drama"
            $table->year('release_year')->nullable();
            $table->string('duration')->nullable(); // contoh: "2h 5m"
            $table->string('certificate')->nullable(); // contoh: "R", "PG-13"
            $table->string('trailer_url')->nullable(); // link video trailer
            $table->decimal('average_rating', 3, 2)->default(0.00);
            $table->unsignedInteger('checkout_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};