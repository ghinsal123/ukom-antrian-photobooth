<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $customerId = session('customer_id');
        $pengguna = Pengguna::findOrFail($customerId);

        return view('customer.edit-profil', compact('pengguna'));
    }

    public function update(Request $request)
    {
        $request->validate([
            // Nama tidak divalidasi karena tidak boleh diubah
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $customerId = session('customer_id');
        $pengguna = Pengguna::findOrFail($customerId);

        // HANYA UPDATE FOTO
        if ($request->hasFile('foto')) {

            // Hapus foto lama jika ada
            if ($pengguna->foto && Storage::disk('public')->exists($pengguna->foto)) {
                Storage::disk('public')->delete($pengguna->foto);
            }

            // Upload foto baru
            $path = $request->file('foto')->store('pengguna', 'public');
            $pengguna->foto = $path;
        }

        $pengguna->save();

        return redirect()->route('customer.dashboard')
                        ->with('success', 'Profil berhasil diperbarui!');
    }
}
