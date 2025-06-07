<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id(); // Primary Key: id (auto-incrementing integer)

            // Kolom Dasar Karakter
            $table->string('name'); // Nama karakter (wajib diisi)
            $table->string('slug')->unique(); // Slug untuk URL (unik, wajib diisi)

            // Detail Karakter (bisa kosong / nullable)
            $table->string('profession')->nullable(); // Profesi atau pekerjaan
            $table->string('key_trait')->nullable(); // Sifat kunci atau karakteristik dominan
            $table->text('quote')->nullable(); // Kutipan khas karakter

            // Daftar Likes dan Dislikes (disimpan sebagai JSON)
            // Ini bakal nyimpen array of string, contoh: ['Kopi Hitam', 'Buku Langka']
            $table->json('likes')->nullable();
            $table->json('dislikes')->nullable();

            // Biografi Lengkap
            $table->text('full_bio')->nullable(); // Biografi lengkap karakter (bisa sangat panjang)

            // Path Gambar Karakter
            $table->string('visual_homepage')->nullable(); // Path gambar untuk tampilan di homepage (teaser)
            $table->string('visual_detail')->nullable();   // Path gambar untuk tampilan di halaman detail

            // Flag untuk Karakter Utama (default: false)
            $table->boolean('is_main_character')->default(false); // Tandai apakah ini karakter utama

            $table->timestamps(); // Kolom created_at dan updated_at (otomatis oleh Laravel)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
