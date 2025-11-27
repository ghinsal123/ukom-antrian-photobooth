<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaketController extends Controller
{
    /**
     * Menampilkan daftar paket dengan fitur pencarian & paginasi
     */
    public function index(Request $request)
    {
        $query = Paket::query();

        // Jika kolom search diisi, filter berdasarkan nama, harga, atau deskripsi
        if ($request->filled('search')) {
            $query->where('nama_paket', 'like', '%' . $request->search . '%')
                  ->orWhere('harga', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
        }

        // Ambil data terbaru dan paginasi 10 per halaman
        $paket = $query->latest()->paginate(10);

        return view('admin.paket.index', compact('paket'));
    }

    /**
     * Menampilkan form tambah paket
     */
    public function create()
    {
        return view('admin.paket.create');
    }

    /**
     * Menyimpan paket baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ], [
            'nama_paket.required' => 'Nama paket wajib diisi.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus berformat JPG, JPEG, atau PNG.',
            'gambar.max' => 'Ukuran gambar maksimal 4MB.',
        ]);

        // Ambil data kecuali file gambar
        $data = $request->only(['nama_paket', 'harga', 'deskripsi']);

        // Jika ada gambar diupload, simpan ke storage publik
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('paket', 'public');
        }

        // Simpan ke Database
        Paket::create($data);

        return redirect()->route('admin.paket.index')->with('success', 'Paket berhasil ditambahkan');
    }

    /**
     * Menampilkan detail paket
     */
    public function show($id)
    {
        $paket = Paket::findOrFail($id);
        return view('admin.paket.show', compact('paket'));
    }

    // Menampilkan form edit paket
    public function edit($id)
    {
        $paket = Paket::findOrFail($id);
        return view('admin.paket.edit', compact('paket'));
    }

    /**
     * Memperbarui data paket
     */
    public function update(Request $request, $id)
    {
        $paket = Paket::findOrFail($id);

        // Validasi input
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ], [
            'nama_paket.required' => 'Nama paket wajib diisi.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus berformat JPG, JPEG, atau PNG.',
            'gambar.max' => 'Ukuran gambar maksimal 4MB.',
        ]);

        // Ambil data text
        $data = $request->only(['nama_paket', 'harga', 'deskripsi']);

        // Jika ada gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($paket->gambar) {
                Storage::disk('public')->delete($paket->gambar);
            }
            // Upload gambar baru
            $data['gambar'] = $request->file('gambar')->store('paket', 'public');
        }

        // Update ke database
        $paket->update($data);

        return redirect()->route('admin.paket.index')->with('success', 'Paket berhasil diperbarui');
    }

    /**
     * Menghapus paket dari database
     */
    public function destroy($id)
    {
        $paket = Paket::findOrFail($id);

        // Jika ada gambar, hapus dari storage
        if ($paket->gambar) {
            Storage::disk('public')->delete($paket->gambar);
        }

        // Hapus data dari database
        $paket->delete();

        return redirect()->route('admin.paket.index')->with('success', 'Paket berhasil dihapus');
    }
}