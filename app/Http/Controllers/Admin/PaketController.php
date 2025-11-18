<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaketController extends Controller
{
    public function index(Request $request)
    {
        $query = Paket::query();

        if ($request->filled('search')) {
            $query->where('nama_paket', 'like', '%' . $request->search . '%')
                  ->orWhere('harga', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
        }

        $pakets = $query->latest()->paginate(10);

        return view('admin.paket.index', compact('pakets'));
    }

    public function create()
    {
        return view('admin.paket.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama_paket', 'harga', 'deskripsi']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('paket', 'public');
        }

        Paket::create($data);

        return redirect()->route('admin.paket.index')->with('success', 'Paket berhasil ditambahkan');
    }

    public function show($id)
    {
        $paket = Paket::findOrFail($id);
        return view('admin.paket.show', compact('paket'));
    }

    public function edit($id)
    {
        $paket = Paket::findOrFail($id);
        return view('admin.paket.edit', compact('paket'));
    }

    public function update(Request $request, $id)
    {
        $paket = Paket::findOrFail($id);

        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama_paket', 'harga', 'deskripsi']);

        if ($request->hasFile('gambar')) {
            if ($paket->gambar) {
                Storage::disk('public')->delete($paket->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('paket', 'public');
        }

        $paket->update($data);

        return redirect()->route('admin.paket.index')->with('success', 'Paket berhasil diperbarui');
    }

    public function destroy($id)
    {
        $paket = Paket::findOrFail($id);

        if ($paket->gambar) {
            Storage::disk('public')->delete($paket->gambar);
        }

        $paket->delete();

        return redirect()->route('admin.paket.index')->with('success', 'Paket berhasil dihapus');
    }
}
