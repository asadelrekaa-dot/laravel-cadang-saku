<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Beri_pinjaman;
use App\Models\Nominal_wallet;
use App\Models\Deadline_pinjaman;
use Illuminate\Http\Request;

class BeriPinjamanController extends Controller
{
    public function createBeriPinjaman (Request $request)
    {
        $request->validate([
            'wallet_id' => 'required|exists:wallet,id',
            'waktu' => 'required',
            'nama' => 'required',
            'notes' => 'nullable',
            'nominal' => 'required|numeric',
            'deadline' => 'required|date',
        ]);

        $beriPinjaman = Beri_pinjaman::create([
            'user_id' => $request->user()->id,
            'wallet_id' => $request->wallet_id,
            'waktu' => $request->waktu,
            'nama' => $request->nama,
            'notes' => $request->notes,
            'nominal' => $request->nominal,
            'status' => 'unpaid',
        ]);

        Deadline_pinjaman::create([
            'beri_pinjaman_id' => $beriPinjaman->id,
            'deadline' => $request->deadline,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Beri pinjaman berhasil ditambahkan',
            'data' => $beriPinjaman,
        ], 201);
    }

    public function updateStatusBeriPinjaman(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:paid,unpaid',
    ]);

    $beriPinjaman = Beri_pinjaman::where(
        'user_id',
        $request->user()->id
    )->findOrFail($id);

    // jika sebelumnya unpaid lalu menjadi paid
    if (
        $beriPinjaman->status === 'unpaid' &&
        $request->status === 'paid'
    ) {
        $saldo = Nominal_wallet::where(
            'wallet_id',
            $beriPinjaman->wallet_id
        )->first();

        $saldo->increment(
            'nominal',
            $beriPinjaman->nominal
        );
    }

    $beriPinjaman->update([
        'status' => $request->status,
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Status pinjaman berhasil diupdate',
        'data' => $beriPinjaman,
    ]);
}

    public function getBeriPinjaman(Request $request)
    {
        $beriPinjaman = Beri_pinjaman::with('deadline')
            ->where('user_id', $request->user()->id)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $beriPinjaman,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $beriPinjaman = Beri_pinjaman::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $beriPinjaman->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Pinjaman berhasil dihapus',
        ]);
    }
}
