<?php

namespace App\Http\Controllers\Api; // Namespace udah bener untuk API controller

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Characters; // Pastikan Model Characters diimpor dengan benar
use Illuminate\Validation\ValidationException; // <-- TAMBAHKAN INI
use Illuminate\Support\Str; // <-- TAMBAHKAN INI untuk Str::slug()

class CharactersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data karakter. Kita juga bisa menggunakan ->get()
        $characters = Characters::all();
        return response()->json([
            'message' => 'Data characters berhasil ditampilkan.',
            'data' => $characters
        ], 200); // Status OK
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // 1. Validasi inputan
            // Menggunakan $validatedData untuk menangkap hasil validasi
            $validatedData = $request->validate([
                'name' => 'required|string|max:100|unique:characters,name', // Name harus unik
                'profession' => 'nullable|string|max:255',
                'key_trait' => 'nullable|string|max:255',
                'quote' => 'nullable|string', // text column, jadi tidak perlu max length
                'likes' => 'nullable|json', // Validasi sebagai JSON string
                'dislikes' => 'nullable|json', // Validasi sebagai JSON string
                'full_bio' => 'nullable|string', // text column
                'visual_homepage' => 'nullable|string|max:255',
                'visual_detail' => 'nullable|string|max:255',
                'is_main_character' => 'nullable|boolean', // Boleh null, atau boolean
            ]);

            // 2. Buat slug dari nama sebelum membuat karakter
            $validatedData['slug'] = Str::slug($validatedData['name']);

            // 3. Pastikan is_main_character diatur, default ke false jika tidak ada di request
            if (!isset($validatedData['is_main_character'])) {
                $validatedData['is_main_character'] = false;
            }

            // 4. Buat data karakter baru menggunakan $validatedData
            $character = Characters::create($validatedData);

            // 5. Beri respons sukses
            return response()->json([
                'message' => 'Data karakter berhasil ditambahkan.',
                'data' => $character
            ], 201); // Status HTTP 201 Created

        } catch (ValidationException $e) {
            // Tangani error validasi
            return response()->json([
                'message' => 'Validasi gagal. Pastikan semua data yang dibutuhkan sudah terisi dengan format yang benar.',
                'errors' => $e->errors() // Method errors() hanya ada di ValidationException
            ], 422); // Status HTTP 422 Unprocessable Entity
        } catch (\Exception $e) { // <-- Tambahkan ini untuk error tak terduga lainnya
            // Tangani error lain yang tidak terduga
            return response()->json([
                'message' => 'Terjadi kesalahan pada server.',
                'error' => $e->getMessage()
            ], 500); // Status HTTP 500 Internal Server Error
        }
    }

    /**
     * Display the specified resource.
     * @param string $slug atau $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $identifier)
    {
        // Cari karakter berdasarkan slug atau ID
        // Gunakan where() dan first() untuk mencari
        $character = Characters::where('slug', $identifier)
            ->orWhere('id', $identifier)
            ->first();

        if (!$character) {
            return response()->json([
                'message' => 'Karakter tidak ditemukan.'
            ], 404); // Status HTTP 404 Not Found
        }

        return response()->json([
            'message' => 'Data karakter berhasil ditampilkan.',
            'data' => $character
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param string $identifier
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $identifier)
    {
        try {
            $character = Characters::where('slug', $identifier)
                ->orWhere('id', $identifier)
                ->first();

            if (!$character) {
                return response()->json([
                    'message' => 'Karakter tidak ditemukan.'
                ], 404);
            }

            // Validasi inputan untuk update
            $validatedData = $request->validate([
                'name' => 'required|string|max:100|unique:characters,name,' . $character->id, // Name unik, kecuali untuk diri sendiri
                'profession' => 'nullable|string|max:255',
                'key_trait' => 'nullable|string|max:255',
                'quote' => 'nullable|string',
                'likes' => 'nullable|json',
                'dislikes' => 'nullable|json',
                'full_bio' => 'nullable|string',
                'visual_homepage' => 'nullable|string|max:255',
                'visual_detail' => 'nullable|string|max:255',
                'is_main_character' => 'nullable|boolean',
            ]);

            // Update slug jika nama berubah
            if (isset($validatedData['name']) && $validatedData['name'] !== $character->name) {
                $validatedData['slug'] = Str::slug($validatedData['name']);
            }

            // Pastikan is_main_character diatur, default ke false jika tidak ada di request
            if (!isset($validatedData['is_main_character'])) {
                $validatedData['is_main_character'] = false; // Atau biarkan nilai lama jika tidak ada di request
            }

            $character->update($validatedData);

            return response()->json([
                'message' => 'Data karakter berhasil diperbarui.',
                'data' => $character
            ], 200); // Status HTTP 200 OK

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan pada server.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param string $identifier
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $identifier)
    {
        try {
            $character = Characters::where('slug', $identifier)
                ->orWhere('id', $identifier)
                ->first();

            if (!$character) {
                return response()->json([
                    'message' => 'Karakter tidak ditemukan.'
                ], 404);
            }

            $character->delete();

            return response()->json([
                'message' => 'Karakter berhasil dihapus.'
            ], 200); // Status HTTP 200 OK (atau 204 No Content)
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan pada server.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
