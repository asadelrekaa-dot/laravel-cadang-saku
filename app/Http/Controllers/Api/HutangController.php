<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Deadline_hutang;
use App\Models\Hutang;
use App\Models\Nominal_wallet;
use Illuminate\Http\Request;

class HutangController extends Controller
{
    public function createHutang(Request $request)
    {
        $request->validate([
            'wallet_id' => 'required|exists:wallet,id',
            'waktu' => 'required',
            'nama' => 'required',
            'notes' => 'nullable',
            'nominal' => 'required|numeric',
            'deadline' => 'required|date',
        ]);

        $hutang = Hutang::create([
            'user_id' => $request->user()->id,
            'wallet_id' => $request->wallet_id,
            'waktu' => $request->waktu,
            'nama' => $request->nama,
            'notes' => $request->notes,
            'nominal' => $request->nominal,
            'status' => 'unpaid',
        ]);

        Deadline_hutang::create([
            'hutang_id' => $hutang->id,
            'deadline' => $request->deadline,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Hutang berhasil ditambahkan',
            'data' => $hutang,
        ], 201);
    }

    public function updateStatusHutang(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:paid,unpaid',
    ]);

    $hutang = Hutang::where('user_id', $request->user()->id)
        ->findOrFail($id);

    // jika sebelumnya unpaid lalu menjadi paid
    if (
        $hutang->status === 'unpaid' &&
        $request->status === 'paid'
    ) {
        $saldo = Nominal_wallet::where(
            'wallet_id',
            $hutang->wallet_id
        )->first();

        $saldo->decrement(
            'nominal',
            $hutang->nominal
        );
    }

    $hutang->update([
        'status' => $request->status,
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Status hutang berhasil diupdate',
        'data' => $hutang,
    ]);
}

    public function getHutang(Request $request)
{
    $hutang = Hutang::with('deadline')
        ->where('user_id', $request->user()->id)
        ->get();

    return response()->json([
        'status' => 'success',
        'data' => $hutang,
    ]);
}

    public function destroy(Request $request, $id)
    {
        $hutang = Hutang::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $hutang->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Hutang berhasil dihapus',
        ]);
    }
}
