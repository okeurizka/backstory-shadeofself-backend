<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Characters extends Model
{
    protected $fillable = [
        'name', // Nama karakter (wajib diisi)
        'slug',// Slug untuk URL (unik, wajib diisi)

        // Detail Karakter (bisa kosong / nullable)
        'profession',// Profesi atau pekerjaan
        'key_trait',// Sifat kunci atau karakteristik dominan
        'quote', // Kutipan khas karakter

        // Daftar Likes dan Dislikes (disimpan sebagai JSON)
        // Ini bakal nyimpen array of string, contoh: ['Kopi Hitam', 'Buku Langka']
        'likes',
        'dislikes',

        // Biografi Lengkap
        'full_bio', // Biografi lengkap karakter (bisa sangat panjang)

        // Path Gambar Karakter
        'visual_homepage', // Path gambar untuk tampilan di homepage (teaser)
        'visual_detail',  // Path gambar untuk tampilan di halaman detail

        // Flag untuk Karakter Utama (default: false)
        'is_main_character', // Tandai apakah ini karakter utama
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];


    use HasFactory;
}
