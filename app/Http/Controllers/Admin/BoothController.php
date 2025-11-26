<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Controller untuk mengelola data booth di panel admin
 * Meliputi CRUD: index, create, store, show, edit, update, destroy
 */
class BoothController extends Controller
{
    /**
     * Menampilkan daftar booth dengan fitur pencarian + pagination
     */
    public function index(Request $request)
    {
        $query = Booth::query();

        // Jika ada kata kunci pencarian
        if ($request->filled('search')) {
            $query->where('nama_booth', 'like', '%' . $request->search . '%')
                  ->orWhere('kapasitas', 'like', '%' . $request->search . '%');
        }

        // Ambil data terbaru + pagination
        $booth = $query->latest()->paginate(10);

        return view('admin.booth.index', compact('booth'));
    }

    /**
     * Menampilkan halaman form untuk membuat data booth baru
     */
    public function create()
    {
        return view('admin.booth.create');
    }

    /**
     * Menyimpan data booth baru ke database
     * Termasuk upload gambar (jika ada)
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_booth' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1|max:10',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ], [
            // Pesan error custom
            'nama_booth.required' => 'Nama booth wajib diisi.',
            'kapasitas.required' => 'Kapasitas wajib diisi.',
            'kapasitas.min' => 'Kapasitas minimal adalah 1.',
            'kapasitas.max' => 'Kapasitas maksimal adalah 10.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus berformat JPG, JPEG, atau PNG.',
            'gambar.max' => 'Ukuran gambar maksimal 4MB.',
        ]);

        // Ambil data kecuali gambar
        $data = $request->only(['nama_booth', 'kapasitas']);

        // Upload gambar jika ada file
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('booth', 'public');
        }

        // Simpan data
        Booth::create($data);

        return redirect()->route('admin.booth.index')->with('success', 'Booth berhasil ditambahkan');
    }

    /**
     * Menampilkan detail dari satu booth
     */
    public function show($id)
    {
        $booth = Booth::findOrFail($id);
        return view('admin.booth.show', compact('booth'));
    }

    /**
     * Menampilkan form untuk edit booth tertentu
     */
    public function edit($id)
    {
        $booth = Booth::findOrFail($id);
        return view('admin.booth.edit', compact('booth'));
    }

    /**
     * Memperbarui data booth 
     * Jika ada gambar baru, gambar lama akan dihapus
     */
    public function update(Request $request, $id)
    {
        $booth = Booth::findOrFail($id);

        // Validasi input update
        $request->validate([
            'nama_booth' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1|max:10',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nama_booth.required' => 'Nama booth wajib diisi.',
            'kapasitas.required' => 'Kapasitas wajib diisi.',
            'kapasitas.min' => 'Kapasitas minimal adalah 1.',
            'kapasitas.max' => 'Kapasitas maksimal adalah 10.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus berformat JPG, JPEG, atau PNG.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = $request->only(['nama_booth', 'kapasitas']);

        // Jika user upload gambar baru
        if ($request->hasFile('gambar')) {

            // Hapus gambar lama
            if ($booth->gambar && Storage::disk('public')->exists($booth->gambar)) {
                Storage::disk('public')->delete($booth->gambar);
            }

            // Upload gambar baru
            $data['gambar'] = $request->file('gambar')->store('booth', 'public');
        }

        // Update data
        $booth->update($data);

        return redirect()->route('admin.booth.index')->with('success', 'Booth berhasil diperbarui');
    }

    /**
     * Menghapus booth dari database
     * Termasuk hapus file gambar dari storage
     */
    public function destroy($id)
    {
        $booth = Booth::findOrFail($id);

        // Hapus gambar jika ada
        if ($booth->gambar && Storage::disk('public')->exists($booth->gambar)) {
            Storage::disk('public')->delete($booth->gambar);
        }

        // Hapus data
        $booth->delete();

        return redirect()->route('admin.booth.index')->with('success', 'Booth berhasil dihapus');
    }
}