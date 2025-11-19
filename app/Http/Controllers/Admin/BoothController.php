<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Booth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BoothController extends Controller
{
    public function index(Request $request)
    {
        $query = Booth::query();

        if ($request->filled('search')) {
            $query->where('nama_booth', 'like', '%' . $request->search . '%')
                  ->orWhere('kapasitas', 'like', '%' . $request->search . '%');
        }

        $booth = $query->latest()->paginate(10);

        return view('admin.booth.index', compact('booth'));
    }

    public function create()
    {
        return view('admin.booth.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_booth' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $data = $request->only(['nama_booth', 'kapasitas']);

        // Upload gambar
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('booth', 'public');
        }

        Booth::create($data);

        return redirect()->route('admin.booth.index')->with('success', 'Booth berhasil ditambahkan');
    }

    public function edit($id)
    {
        $booth = Booth::findOrFail($id);
        return view('admin.booth.edit', compact('booth'));
    }

    public function update(Request $request, $id)
    {
        $booth = Booth::findOrFail($id);

        $request->validate([
            'nama_booth' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama_booth', 'kapasitas']);

        // Upload gambar baru
        if ($request->hasFile('gambar')) {

            // Hapus gambar lama jika ada
            if ($booth->gambar && Storage::disk('public')->exists($booth->gambar)) {
                Storage::disk('public')->delete($booth->gambar);
            }

            // Simpan gambar baru
            $data['gambar'] = $request->file('gambar')->store('booth', 'public');
        }

        $booth->update($data);

        return redirect()->route('admin.booth.index')->with('success', 'Booth berhasil diperbarui');
    }

    public function destroy($id)
    {
        $booth = Booth::findOrFail($id);

        // Hapus gambar
        if ($booth->gambar && Storage::disk('public')->exists($booth->gambar)) {
            Storage::disk('public')->delete($booth->gambar);
        }

        $booth->delete();

        return redirect()->route('admin.booth.index')->with('success', 'Booth berhasil dihapus');
    }
}
