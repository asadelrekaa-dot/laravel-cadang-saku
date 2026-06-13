<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Nominal_wallet;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index(Request $request)
    {
        $wallets = Wallet::where('user_id', $request->user()->id)->get();

        $data = $wallets->map(function ($wallet) {
            $nominal = Nominal_wallet::where('wallet_id', $wallet->id)
                ->where('user_id', $wallet->user_id)
                ->latest()
                ->first();

            return [
                'id' => $wallet->id,
                'nama_wallet' => $wallet->nama_wallet,
                'nominal' => $nominal ? (int) $nominal->nominal : 0,
                'created_at' => $wallet->created_at,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function createWallet(Request $request)
    {
        $request->validate([
            'nama_wallet' => 'required',
            'nominal' => 'required|numeric|min:0',
        ]);

        $wallet = Wallet::create([
            'user_id' => $request->user()->id,
            'nama_wallet' => $request->nama_wallet,
        ]);

        Nominal_wallet::create([
            'user_id' => $request->user()->id,
            'wallet_id' => $wallet->id,
            'nominal' => $request->nominal,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $wallet->id,
                'nama_wallet' => $wallet->nama_wallet,
                'nominal' => (int) $request->nominal,
            ],
        ], 201);
    }

    public function destroy(Request $request, $id)
    {
        $wallet = Wallet::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        Nominal_wallet::where('wallet_id', $wallet->id)->delete();
        $wallet->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Wallet deleted successfully',
        ]);
    }
}
