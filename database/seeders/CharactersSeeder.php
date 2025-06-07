<?php

namespace Database\Seeders;

use App\Models\Characters; // Pastikan Model Characters diimpor dengan benar
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str; // Tambahkan ini untuk menggunakan Str::slug()

class CharactersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data untuk Galib
        Characters::create([
            'name' => 'Galib',
            'slug' => Str::slug('Galib'), // Otomatis bikin slug 'galib'
            'profession' => 'Bos Publishing House',
            'key_trait' => 'Logis, Dingin, Setia',
            'quote' => 'Nih, kalo butuh, masalah kepake atau enggak itu urusanmu.',
            // Data likes dan dislikes harus berupa array, Laravel akan otomatis mengkonversi ke JSON
            'likes' => json_encode(['Kopi Hitam', 'Buku-buku langka', 'Ketertiban', 'Diam-diam mengamati Edelia']),
            'dislikes' => json_encode(['Drama berlebihan', 'Ketidakpastian', 'Orang yang tidak mandiri']),
            'full_bio' => 'Galib adalah sosok yang dingin dan logis, namun memiliki kesetiaan yang mendalam. Ia tumbuh bersama Edelia dan menjadi penyeimbang baginya. Setelah perpisahan yang menyakitkan, Galib membangun kerajaan publishing house-nya sendiri, tetapi tidak pernah berhenti memantau Edelia dari kejauhan. Ambisi dan pengkhianatan di masa lalu membentuknya menjadi individu yang pragmatis namun tetap menyimpan luka.',
            'is_main_character' => true,
        ]);

        // Data untuk Edelia
        Characters::create([
            'name' => 'Edelia',
            'slug' => Str::slug('Edelia'), // Otomatis bikin slug 'edelia'
            'profession' => 'Penulis (Awal), CEO',
            'key_trait' => 'Ambisius, Imajinatif, Keras Kepala',
            'quote' => 'Aku harus membuktikan diriku sendiri.',
            'likes' => json_encode(['Kebebasan berekspresi', 'Tantangan baru', 'Karya sastra mendalam', 'Musik indie']),
            'dislikes' => json_encode(['Batasan', 'Kegagalan', 'Terlalu bergantung pada orang lain']),
            'full_bio' => 'Edelia adalah penulis berbakat dengan imajinasi liar dan ambisi yang membara. Sejak kecil, ia selalu ingin membuktikan dirinya, terutama setelah insiden keluarga. Keras kepalanya membawanya menjauh dari Galib dan masuk ke dunia Velure yang penuh intrik. Perjalanannya dipenuhi pilihan sulit dan pengorbanan yang mengubahnya secara drastis, menjadikannya tokoh kunci dalam konflik besar.',
            'is_main_character' => true,
        ]);

        // Lo bisa tambahin karakter pendukung di sini juga nanti,
        // misal: Ayah Galib, Ibu Galib, Teman Edelia, dll.
    }
}
