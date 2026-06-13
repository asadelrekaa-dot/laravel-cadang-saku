<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Beri_pinjaman;
use App\Models\Hutang;
use App\Models\Income;
use App\Models\Outcome;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $income = Income::where('user_id', $userId)
            ->with('kategori')
            ->get()
            ->map(fn($item) => [
                'id' => $item->id,
                'type' => 'income',
                'wallet_id' => $item->wallet_id,
                'kategori_id' => $item->kategori_id,
                'kategori' => $item->kategori?->nama ?? 'Lainnya',
                'waktu' => $item->waktu,
                'notes' => $item->notes,
                'nominal' => (int) $item->nominal,
            ]);

        $outcome = Outcome::where('user_id', $userId)
            ->with('kategori')
            ->get()
            ->map(fn($item) => [
                'id' => $item->id,
                'type' => 'outcome',
                'wallet_id' => $item->wallet_id,
                'kategori_id' => $item->kategori_id,
                'kategori' => $item->kategori?->nama ?? 'Lainnya',
                'waktu' => $item->waktu,
                'notes' => $item->notes,
                'nominal' => (int) $item->nominal,
            ]);

        $hutang = Hutang::where('user_id', $userId)
            ->with('deadline')
            ->get()
            ->map(fn($item) => [
                'id' => $item->id,
                'type' => 'hutang',
                'wallet_id' => $item->wallet_id,
                'nama' => $item->nama,
                'waktu' => $item->waktu,
                'notes' => $item->notes,
                'nominal' => (int) $item->nominal,
                'status' => $item->status,
                'deadline' => $item->deadline?->deadline,
            ]);

        $pinjaman = Beri_pinjaman::where('user_id', $userId)
            ->with('deadline')
            ->get()
            ->map(fn($item) => [
                'id' => $item->id,
                'type' => 'beri-pinjaman',
                'wallet_id' => $item->wallet_id,
                'nama' => $item->nama,
                'waktu' => $item->waktu,
                'notes' => $item->notes,
                'nominal' => (int) $item->nominal,
                'status' => $item->status,
                'deadline' => $item->deadline?->deadline,
            ]);

        $all = collect()
            ->merge($income)
            ->merge($outcome)
            ->merge($hutang)
            ->merge($pinjaman)
            ->sortByDesc('waktu')
            ->values();

        return response()->json([
            'status' => 'success',
            'data' => $all,
        ]);
    }
}
