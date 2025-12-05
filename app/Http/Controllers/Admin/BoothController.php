<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BoothController extends Controller
{
    // ==============================
    // LIST DATA
    // ==============================
    public function index(Request $request)
    {
        $query = Booth::query();

        if ($request->filled('search')) {
            $query->where('nama_booth', 'like', '%' . $request->search . '%')
                  ->orWhere('kapasitas', 'like', '%' . $request->search . '%');
        }

        $booths = $query->latest()->paginate(10);
        return view('admin.booth.index', compact('booths'));
    }


    // ==============================
    // HALAMAN CREATE
    // ==============================
    public function create()
    {
        return view('admin.booth.create');
    }


    // ==============================
    // SIMPAN DATA BARU
    // ==============================
    public function store(Request $request)
    {
        $request->validate([
            'nama_booth' => 'required|string|max:255',
            'kapasitas'  => 'required|integer',
            'gambar'     => 'required|array|min:2',
            'gambar.*'   => 'image|mimes:jpg,jpeg,png|max:2048',
        ], [
            // Bahasa Indonesia
            'nama_booth.required' => 'Nama booth wajib diisi.',
            'kapasitas.required'  => 'Kapasitas wajib diisi.',
            'gambar.required'     => 'Gambar booth wajib diupload.',
            'gambar.array'        => 'Format gambar tidak sesuai.',
            'gambar.min'          => 'Minimal harus mengupload 2 gambar booth, agar mendeskripsikan gambar boothnya',
            'gambar.*.image'      => 'File yang diupload harus berupa gambar.',
            'gambar.*.mimes'      => 'Format gambar harus JPG, JPEG, atau PNG.',
            'gambar.*.max'        => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Upload gambar
        $gambarPaths = [];
        foreach ($request->file('gambar') as $file) {
            $gambarPaths[] = $file->store('booth', 'public');
        }

        Booth::create([
            'nama_booth' => $request->nama_booth,
            'kapasitas'  => $request->kapasitas,
            'gambar'     => $gambarPaths,
        ]);

        return redirect()->route('admin.booth.index')
            ->with('success', 'Booth berhasil ditambahkan.');
    }


    // ==============================
    // HALAMAN EDIT
    // ==============================
    public function edit(Booth $booth)
    {
        return view('admin.booth.edit', compact('booth'));
    }


    // ==============================
    // UPDATE DATA
    // ==============================
    public function update(Request $request, Booth $booth)
    {
        $request->validate([
            'nama_booth' => 'required|string|max:255',
            'kapasitas'  => 'required|integer',
            'gambar.*'   => 'image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nama_booth.required' => 'Nama booth wajib diisi.',
            'kapasitas.required'  => 'Kapasitas wajib diisi.',
            'gambar.*.image'      => 'File harus berupa gambar.',
            'gambar.*.mimes'      => 'Format gambar harus JPG, JPEG, atau PNG.',
            'gambar.*.max'        => 'Ukuran gambar maksimal 2MB.',
        ]);

        $gambarLama = $booth->gambar ?? [];
        $hapus = $request->remove_images ?? [];

        // ❗ Validasi minimal 2 gambar tersisa
        if ((count($gambarLama) - count($hapus)) < 2) {
            return back()->withErrors('Minimal harus memiliki 2 gambar! Tidak bisa menghapus lebih banyak.');
        }

        // Hapus gambar yang ditandai
        $gambarSetelahHapus = array_filter($gambarLama, function ($path) use ($hapus) {
            if (in_array($path, $hapus)) {
                Storage::disk('public')->delete($path);
                return false;
            }
            return true;
        });

        // Upload gambar baru
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $gambarSetelahHapus[] = $file->store('booth', 'public');
            }
        }

        $booth->update([
            'nama_booth' => $request->nama_booth,
            'kapasitas'  => $request->kapasitas,
            'gambar'     => array_values($gambarSetelahHapus),
        ]);

        return redirect()->route('admin.booth.index')
            ->with('success', 'Booth berhasil diperbarui.');
    }


    // ==============================
    // DETAIL
    // ==============================
    public function show(Booth $booth)
    {
        return view('admin.booth.show', compact('booth'));
    }


    // ==============================
    // HAPUS DATA
    // ==============================
    public function destroy(Booth $booth)
    {
        foreach ($booth->gambar as $path) {
            Storage::disk('public')->delete($path);
        }

        $booth->delete();

        return redirect()->route('admin.booth.index')
            ->with('success', 'Booth berhasil dihapus.');
    }
}
