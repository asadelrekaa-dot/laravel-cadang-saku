<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Income;
use App\Models\Nominal_wallet;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function createIncome(Request $request)
    {
    $request->validate([
        'wallet_id' => 'required|exists:wallet,id',
        'kategori_id' => 'required|exists:categories,id',
        'waktu' => 'required',
        'nominal' => 'required|numeric',
        'notes' => 'nullable',
    ]);

    $income = Income::create([
        'user_id' => $request->user()->id,
        'wallet_id' => $request->wallet_id,
        'kategori_id' => $request->kategori_id,
        'waktu' => $request->waktu,
        'notes' => $request->notes,
        'nominal' => $request->nominal,
    ]);

    $saldo = Nominal_wallet::where(
    'wallet_id',
    $request->wallet_id
    )->first();

$saldo->increment('nominal', $request->nominal);

    return response()->json([
        'status' => 'success',
        'message' => 'Income berhasil ditambahkan',
        'data' => $income,
    ], 201);
}

    public function getIncome(Request $request)
{
    $income = Income::where(
        'user_id',
        $request->user()->id
    )->get();

    return response()->json([
        'status' => 'success',
        'data' => $income,
    ]);
}

    public function destroy(Request $request, $id)
    {
        $income = Income::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $saldo = Nominal_wallet::where('wallet_id', $income->wallet_id)->first();
        if ($saldo) {
            $saldo->decrement('nominal', $income->nominal);
        }

        $income->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Income berhasil dihapus',
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'wallet_id' => 'required|exists:wallet,id',
            'kategori_id' => 'required|exists:categories,id',
            'waktu' => 'required',
            'nominal' => 'required|numeric',
            'notes' => 'nullable',
        ]);

        $income = Income::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $saldo = Nominal_wallet::where('wallet_id', $income->wallet_id)->first();

        $oldNominal = $income->nominal;
        $income->update([
            'wallet_id' => $request->wallet_id,
            'kategori_id' => $request->kategori_id,
            'waktu' => $request->waktu,
            'notes' => $request->notes,
            'nominal' => $request->nominal,
        ]);

        if ($saldo) {
            $saldo->increment('nominal', $request->nominal - $oldNominal);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Income berhasil diperbarui',
            'data' => $income,
        ]);
    }
}
