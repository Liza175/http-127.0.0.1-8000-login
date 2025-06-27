<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    // Ambil semua data mahasiswa (untuk ditampilkan di tabel)
    public function index()
{
    $mahasiswa = Mahasiswa::all();
    return response()->json([
        'data' => $mahasiswa
    ]);
}

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|max:12|unique:mahasiswas',
            'nama' => 'required|string|max:255',
            'jk' => 'required|string|max:11',
            'tgl_lahir' => 'required|date',
            'jurusan' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
        ]);

        $mahasiswa = Mahasiswa::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Mahasiswa berhasil ditambahkan',
            'data' => $mahasiswa
        ]);
    }

    // Tampilkan data berdasarkan ID
    public function show($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return response()->json($mahasiswa);
    }

    // Update data mahasiswa
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'nim' => 'required|string|max:12|unique:mahasiswas,nim,' . $id . ',nim',
            'nama' => 'required|string|max:255',
            'jk' => 'required|string|max:11',
            'tgl_lahir' => 'required|date',
            'jurusan' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data mahasiswa berhasil diupdate',
            'data' => $mahasiswa
        ]);
    }

    // Hapus data mahasiswa
    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data mahasiswa berhasil dihapus'
        ]);
    }
}
