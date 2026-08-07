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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel users (siapa user yang memberi rating)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Relasi ke tabel movies (film mana yang diberi rating)
            $table->foreignId('movie_id')->constrained('movies')->onDelete('cascade');
            
            $table->integer('rating_value'); // Menyimpan angka rating dari user (skala 1-5)
            $table->timestamps();
            
            // Validasi database: 1 user hanya boleh memberi rating 1 kali untuk 1 film yang sama
            $table->unique(['user_id', 'movie_id']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
