<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LogController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil log terbaru per antrian (MAX id per antrian)
        $latestLogsSub = Log::select(DB::raw('MAX(id) as id'))
            ->groupBy('antrian_id');

        // 2. Query utama dengan relasi
        $query = Log::with([
            'pengguna',
            'antrian.pengguna',
            'antrian.booth',
            'antrian.paket'
        ])->whereIn('id', $latestLogsSub);

        // 3. Filter berdasarkan tanggal antrian
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereHas('antrian', function($q) use ($request) {
                $q->whereBetween('tanggal', [$request->start_date, $request->end_date]);
            });
        } elseif ($request->filled('start_date')) {
            $query->whereHas('antrian', function($q) use ($request) {
                $q->whereDate('tanggal', $request->start_date);
            });
        }

        // 4. Filter search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('pengguna', fn($q2) => $q2->where('nama_pengguna', 'like', "%$search%"))
                  ->orWhereHas('antrian.pengguna', fn($q3) => $q3->where('nama_pengguna', 'like', "%$search%"))
                  ->orWhereHas('antrian.booth', fn($q4) => $q4->where('nama_booth', 'like', "%$search%"))
                  ->orWhereHas('antrian.paket', fn($q5) => $q5->where('nama_paket', 'like', "%$search%"));
            });
        }

        // 5. Ambil hasil dan set timezone WIB
        $logs = $query->orderBy('created_at', 'desc')->get()->map(function($log) {
            $log->created_at = $log->created_at->clone()->timezone('Asia/Jakarta');
            $log->updated_at = $log->updated_at->clone()->timezone('Asia/Jakarta');


            if ($log->antrian) {
                // Ubah tanggal antrian ke WIB
                $log->antrian->tanggal = Carbon::parse($log->antrian->tanggal, 'Asia/Jakarta')->format('Y-m-d');

                // Jika ada kolom jam, tampilkan juga WIB
                if (isset($log->antrian->jam)) {
                    $log->antrian->jam = Carbon::parse($log->antrian->jam, 'Asia/Jakarta')->format('H:i:s');
                }
            }

            return $log;
        });

        return view('Operator.log.index', compact('logs', 'request'));
    }
}
