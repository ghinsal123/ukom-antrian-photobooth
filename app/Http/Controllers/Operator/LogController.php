<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Admin\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $query = Log::with(['pengguna', 'antrian']);

        // Filter berdasarkan periode
        if ($request->filter == 'hari') {
            $query->whereDate('created_at', today());
        } elseif ($request->filter == 'minggu') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($request->filter == 'bulan') {
            $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($request->filter == 'tahun') {
            $query->whereYear('created_at', now()->year);
        }

        $logs = $query->orderBy('created_at', 'desc')->get();

        return view('Operator.log.index', compact('logs', 'request'));
    }
}
